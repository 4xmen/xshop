<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class XController extends Controller
{

    protected $model = User::class;
    protected $name = "User";
    protected $cols = [];
    protected $extra_cols = ['id'];
    protected $listView = 'admin.users.user-list';
    protected $formView = 'admin.users.user-form';
    protected $filterables = [];

    protected $searchable = [];


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-edit-2-line'],
    ];


    public function createOrUpdate($item, $request)
    {

    }

    protected function showList($query)
    {


        if (hasRoute('trashed')){
            $this->extra_cols[] = 'deleted_at';
        }
        $items = $query->paginate(config('app.panel.page_count'),
            array_merge($this->extra_cols, $this->cols));
        $cols = $this->cols;
        $buttons = $this->buttons;
        return view($this->listView, compact('items', 'cols', 'buttons'));
    }

    protected function makeSortAndFilter()
    {


        if (!\request()->has('sort') || !in_array(\request('sort'), $this->cols)) {
            $query = $this->model::orderByDesc('id');
        } else {
            $query = $this->model::orderBy(\request('sort'), \request('sortType', 'asc'));
        }

        foreach (\request()->input('filter', []) as $col => $filter) {
            if (isJson($filter)) {
                $vals = json_decode($filter);
                if (count($vals) != 0) {
                    $query->whereIn($col, $vals);
                }
            } else {
                $query->where($col, $filter);
            }
        }

        if (mb_strlen(trim(\request()->input('q', ''))) > 0) {
            foreach ($this->searchable as $col) {
                $query->where(function ($query) {
                    foreach ($this->searchable as $key => $col) {
                        if ($key === 0) {
                            $query->where($col, 'LIKE', '%' . \request()->input('q', '') . '%');
                        } else {
                            $query->orWhere($col, 'LIKE', '%' . \request()->input('q', '') . '%');
                        }
                    }
                });
            }
        }
        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = $this->makeSortAndFilter();
        return $this->showList($query);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $item = new $this->model();
        $item = $this->create($item,$request);
        logAdmin(__METHOD__, $this->model , $item->id);

        if ($request->ajax()){
            return ['OK' => true,];
        }else{
            return redirect()->route('admin.'.$this->model.'.index')->with(['message' => __('As you wished created successfully')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($item)
    {
        //
        logAdmin(__METHOD__, $this->model , $item->id);
        $item->delete();
        return redirect()->back()->with(['message' => __('As you wished removed successfully')]);
    }

    /**
     * restore removed the specified resource from storage.
     */
    public function restoreing($item)
    {
        //
        logAdmin(__METHOD__, $this->model , $item->id);
        $item->restore();
        return redirect()->back()->with(['message' => __('As you wished restored successfully')]);
    }


    /**
     * Show list of trashed
     */
    public function trashed()
    {
        $query = $this->makeSortAndFilter()->onlyTrashed();
        return $this->showList($query);
    }

    protected function do_bulk($msg,$action,$ids)
    {
        logAdminBatch(__METHOD__ . '.' . $action, $this->model, $ids);
        return redirect()->back()->with(['message' => $msg]);
    }
}
