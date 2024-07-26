<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

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
        $post->increment('view');
        return view('client.post',compact('area','post','title','subtitle'));
    }

    public function tag($slug){

        $tag = Tag::where('slug->'.config('app.locale'),'like',$slug)->first();
        return $tag;
    }
}
