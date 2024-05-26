<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class XController extends Controller
{

    protected $model = User::class;
    protected $name = "User";
    protected $cols = [];
    protected $extra_cols = ['id'];
    protected $listView = 'admin.users.user-list';
    protected $formView = 'admin.users.user-form';


    public function createOrUpdate($item, Request $request)
    {

    }

    protected function showList($query)
    {
        $items = $query->paginate(config('app.panel.page_count'), array_merge($this->extra_cols, $this->cols));
        $cols = $this->cols;
        return view($this->listView, compact('items', 'cols'));
    }

    protected function makeSortAndFilter()
    {
        if (!\request()->has('sort') || !in_array(\request('sort'), $this->cols)) {
            $query = $this->model::orderByDesc('id');
        } else {
            $query = $this->model::orderBy(\request('sort'), \request('sortType', 'asc'));
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
    public function destroy($user)
    {
        //
    }


    /**
     * Show list of trashed
     */
    public function trashed()
    {
        $query = User::onlyTrashed();
        return $this->showList($query);
    }
}
