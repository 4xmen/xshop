<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class XController extends Controller
{

    protected $model = User::class;
    protected $name = "User";
    protected $listView = 'admin.users.user-list';
    protected $formView = 'admin.users.user-form';


    public function createOrUpdate($item, Request $request) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = $this->model::orderByDesc('id')->paginate(config('app.panel.page_count'));
        return view($this->listView,compact('items'));
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
    public function show( $user)
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
    public function update(Request $request,  $user)
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
}
