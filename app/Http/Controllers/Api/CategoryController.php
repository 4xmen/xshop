<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PropCollection;
use App\Models\Category;
use App\Models\Prop;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoriesCollection::collection(Category::orderBy('sort', 'asc')->get());
    }

    public function show(Category $category){
        return new CategoryResource($category);
    }


    public function props( $id){
        $category = Category::whereId($id)->firstOrFail();
        return PropCollection::collection($category->props()->orderBy('sort')->get());
    }
}
