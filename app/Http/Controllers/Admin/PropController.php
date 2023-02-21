<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropSaveRequest;
use App\Models\Cat;
use App\Models\Product;
use App\Models\Prop;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class PropController extends Controller
{
    //
    public function __construct()
    {
//        \Auth::login(User::role('admin')->first());
    }

    public function index()
    {
        $props = Prop::orderBy('sort')->paginate(15);
        return view('admin.props.propIndex', compact('props'));
    }

    public function create()
    {
        $allCategories = Cat::all();
        return view('admin.props.propForm', compact('allCategories'));
    }

    public function store(PropSaveRequest $req)
    {
        $item = new Prop();
        $id = $this->updateOrCreate($item, $req);
        return redirect()->route('admin.props.index', $id)->with('message', 'prop inserted');
    }

    public function updateOrCreate(Prop $item, $req)
    {

//        if ($req->file('file') != null &&  $req->input('type') == 'multilevel') {
//            $exl = $req->file('file')->getPathName();
//            $brands = [];
//            Excel::load($exl, function ($reader) use (&$item) {
//                $results = $reader->get();
//                $last = '';
//                foreach ($reader->all() as $index => $itemz) {
//                    if ($last != $itemz['brand']) {
//                        $last = $itemz['brand'];
//                        $tmp['title'] = $last;
//                        $tmp['children'] = [];
//                        $brands[] = $tmp;
//                    }
//                    if ($itemz['model'] == null) {
//                        continue;
//                    }
//                    $brands[count($brands)-1]['children'][] = $itemz['model'];
//                }
//                $item->options = json_encode($brands);
//            });
//        }
        $item->name = $req->input('name');
        $item->type = $req->input('type');
        $item->required = $req->input('required');
        $item->searchable = $req->input('searchable');
        $item->width = $req->input('width');
        $item->label = $req->input('label');
        $item->unit = $req->input('unit');
        $item->priceable = $req->has('priceable');
        $item->icon = $req->input('icon');


        $data = [];
        if (($req->has('options'))){

        $tit = $req->input('options')['title'];
        $val = $req->input('options')['value'];
        foreach ($tit as $k => $v) {
            $data[] = ['title' => $v,'value' => $val[$k] ];
        }
        }
        $item->options = json_encode($data);
        $item->save();
        $item->category()->sync($req->input('category'));
        return $item->id;
//        $item->options = ;
    }

    public function edit($id)
    {
        $p = Prop::whereId($id)->firstOrFail();
        $allCategories = Cat::all();
        $cats = $p->category()->pluck('id')->toArray();
        return view('admin.props.propForm', compact('p', 'allCategories','cats'));
    }

    public function update($id, PropSaveRequest $req)
    {
        $item = Prop::whereId($id)->firstOrFail();
        $this->updateOrCreate($item, $req);
        return back()->with('message', 'prop update success');
    }

    public function delete($id)
    {
        Prop::whereId($id)->firstOrFail()->delete();
        return back();
    }

    public function sort($catId)
    {
        $cat = Cat::findOrFail($catId);
        $props = $cat->props()->orderBy('sort')->select('type', 'label', 'name', 'id', 'sort')->get();
        return view('admin.props.propSort', compact('props', 'cat'));
    }

    public function sortStore(Request $req)
    {
        if ($req->input('sort') == null || $req->input('sort') == '[]') {
            return back()->withErrors(['with no change']);
        }
        foreach (json_decode($req->input('sort'), true) as $i => $item) {
            Prop::findOrFail($item['id'])->update(['sort' => $i]);
        }
        return back()->with('success', ['update success']);
    }

    public function list($id)
    {
        $cat = Cat::whereId($id)->firstOrFail();
        return [$cat,$cat->props()
            ->orderBy('sort')->select('name', 'type', 'options', 'label', 'width', 'required', 'searchable','priceable')->get()];
    }
}
