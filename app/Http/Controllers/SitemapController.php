<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Product;
use Illuminate\Http\Request;
use Xmen\StarterKit\Models\Post;

class SitemapController extends Controller
{
    //
    public function index(){
        return  response()->view('sitemap.main')->header('Content-Type', 'text/xml');
    }

    public function products(){
        $items =  Product::where('active',1)->orderByDesc('updated_at')->get();
        return view('sitemap.products',compact('items'));
    }
    public function cats(){
        $items =  Cat::orderByDesc('updated_at')->get();
        return view('sitemap.cats',compact('items'));
    }
    public function posts(){
        $items =  Post::where('status',1)->orderByDesc('updated_at')->get();
        return view('sitemap.posts',compact('items'));
    }
}
