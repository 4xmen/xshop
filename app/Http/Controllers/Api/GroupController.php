<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupsCollection;
use App\Models\Group;
use Illuminate\Http\Request;


/**
 * @OA\Info(title="xShop API", version="1.0.0")
 */
/**
 * @OA\PathItem(path="/api/v1")
 */
class GroupController extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/v1/groups",
     *     summary="Get list of groups",
     *     @OA\Response(
     *         response=200,
     *         description="A list of categories"
     *     )
     * )
     */
    public function index()
    {
        //
        return success(GroupsCollection::collection(Group::orderBy('sort', 'asc')->get()));
    }


    /**
     * @OA\Get(
     *     path="/api/v1/group/{group}",
     *     summary="Get category",
     *     @OA\Parameter(
     *         description="Slug of one group",
     *         name="group",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Parameter(
     *          description="sub posts per page",
     *          name="per_page",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="A group with datas"
     *     )
     * )
     */
    public function show(Group $group)
    {
        //
        return success(GroupCollection::make($group));
    }
}
