<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupsCollection;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return GroupsCollection::collection(Group::orderBy('sort', 'asc')->get());
    }


    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
        return GroupCollection::make($group);
    }
}
