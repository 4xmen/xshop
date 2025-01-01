<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PropCollection;
use App\Models\Category;
use App\Models\Prop;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="xShop API", version="1.0.0")
 */
/**
 * @OA\PathItem(path="/api/v1")
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     summary="Get list of categories",
     *     @OA\Response(
     *         response=200,
     *         description="A list of categories"
     *     )
     * )
     */
    public function index()
    {
        return success(CategoriesCollection::collection(Category::orderBy('sort', 'asc')->get()));
    }


    /**
     * @OA\Get(
     *     path="/api/v1/category/{category}",
     *     summary="Get category",
     *     @OA\Parameter(
     *         description="Slug of one category",
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Parameter(
     *           description="sub products per page",
     *           name="per_page",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="A category with datas"
     *     )
     * )
     */
    public function show(Category $category)
    {
        return success(new CategoryResource($category));
    }



    public function props( $id){
        $category = Category::whereId($id)->firstOrFail();
        return PropCollection::collection($category->props()->orderBy('sort')->get());
    }
}
