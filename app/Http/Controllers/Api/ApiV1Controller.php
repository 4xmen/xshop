<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Models\Product;
use Illuminate\Http\Request;
use Xmen\StarterKit\Models\Post;

class ApiV1Controller extends Controller
{
    //
    public function index(){
        $posts = Post::limit(10)->get();
        $products = Product::limit(10)->get();
        $categories = Cat::get();

        return [
            'posts' => $posts,
            'products' => $products,
            'categories' => $categories
        ];
    }
}
