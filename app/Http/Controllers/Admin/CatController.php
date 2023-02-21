<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CatSaveRequest;
use App\Models\Cat;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class CatController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }


    public function createOrUpdate(Cat $cat, CatSaveRequest $request) {
        $cat->name = $request->input('name');
        $cat->slug = \StarterKit::slug($request->input('name'));
        $cat->description = $request->input('description');
        $cat->parent_id = $request->input('parent') == '' ? null : $request->input('parent');

        if ($request->hasFile('image')) {
            $cat->media()->delete();
            $cat->addMedia($request->file('image'))->toMediaCollection();
        }
        if ($request->hasFile('image2')) {
            $name = time().'.'.request()->image2->getClientOriginalExtension();
            $cat->image = $name;
            $request->file('image2')->storeAs('public/cats', $name);
        }
        $cat->save();
        return $cat;
    }


    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Categories deleted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Cat::class,$request->input('id'));
                Cat::destroy($request->input('id'));
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.cat.index')->with(['message' => $msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $cats = Cat::paginate(20);
        return view('admin.cat.catIndex', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $cats = Cat::all();
        return view('admin.cat.catForm', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatSaveRequest $request) {
        //
        $cat = new Cat();
        $cat = $this->createOrUpdate($cat, $request);
        logAdmin(__METHOD__,Cat::class,$cat->id);
        return redirect()->route('admin.cat.index')->with(['message' => __('Product category created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cat $cat) {
        //
        $cats = Cat::where('id', '<>', $cat->id)->get();
        $ccat = $cat;
        return view('admin.cat.catForm', compact('ccat', 'cats'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatSaveRequest $request, Cat $cat) {
        //
        $this->createOrUpdate($cat, $request);
        logAdmin(__METHOD__,Cat::class,$cat->id);
        return redirect()->route('admin.cat.index')->with(['message' => __('Product category updated successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cat $cat) {
        //
        logAdmin(__METHOD__,Cat::class,$cat->id);
        $cat->delete();
        return redirect()->route('admin.cat.index')->with(['message' => __('Product category deleted successfully')]);
    }

    public function sort() {
        $cats = Cat::orderBy('sort')->whereNull('parent_id')->get();
        return view('admin.cat.catSort',compact('cats'));
    }

    public function sortStore(Request $request) {
        $request->validate([
            'info' => 'required|json'
        ]);
        $arr = json_decode($request->input('info'), true);
        $this->saveSort($arr[0]);
        logAdmin(__METHOD__, Cat::class, '0');
        if ($request->ajax()){
            return  ["OK" => true, 'msg' => "Categories sort updated"];
        }
        return redirect()->back()
            ->with(['message' => "Categories sort updated"]);
    }

    public function saveSort($arr,$parent = null){
        foreach ($arr as $key => $value) {
            $cat = Cat::whereId($value['id'])->first();
            $cat->sort = $key;
            $cat->parent_id = $parent;
            $cat->save();
            if(isset($value['children']) && count($value['children'][0]) > 0){
                $this->saveSort($value['children'][0],$value['id']);
            }
        }
    }
}
