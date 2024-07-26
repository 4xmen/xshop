<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function welcome(){
        $area = 'index';
        $title = config('app.name');
        $subtitle = getSetting('subtitle');
        return view('client.welcome',compact('area','title','subtitle'));
    }

    public function post(Post $post){
        $area = 'post';
        $title = $post->title;
        $subtitle = $post->subtitle;
        return view('client.post',compact('area','post','title','subtitle'));
    }
}
