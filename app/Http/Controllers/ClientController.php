<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class ClientController extends Controller
{

    public $paginate = 12;

    //
    public function welcome()
    {
        $area = 'index';
        $title = config('app.name');
        $subtitle = getSetting('subtitle');
        return view('client.welcome', compact('area', 'title', 'subtitle'));
    }

    public function post(Post $post)
    {
        $area = 'post';
        $title = $post->title;
        $subtitle = $post->subtitle;
        $post->increment('view');
        return view('client.post', compact('area', 'post', 'title', 'subtitle'));
    }
    public function gallery(Gallery $gallery)
    {
        $area = 'gallery';
        $title = $gallery->title;
        $subtitle = \Str::limit(strip_tags($gallery->description),15);
        $gallery->increment('view');
        return view('client.gallery', compact('area', 'gallery', 'title', 'subtitle'));
    }

    public function posts()
    {
        $area = 'posts-list';
        $title = __("Posts list");
        $subtitle = '';
        $posts = Post::where('status', 1)->orderByDesc('id')->paginate($this->paginate);
        return view('client.default-list', compact('area', 'posts', 'title', 'subtitle'));
    }

    public function galleries()
    {
        $area = 'galleries-list';
        $title = __("Galleries list");
        $subtitle = '';
        $galleries = Gallery::where('status', 1)->orderByDesc('id')->paginate($this->paginate);
        return view('client.default-list', compact('area', 'galleries', 'title', 'subtitle'));
    }

    public function tag($slug)
    {

        $tag = Tag::where('slug->' . config('app.locale'), 'like', $slug)->first();
        return $tag;
    }


    public function submitComment(Request $request)
    {
        $request->validate([
            'commentable_type' => ['required', 'string', 'min:5'],
            'commentable_id' => ['required', 'integer'],
            'message' => ['required', 'string', 'min:5'],
            'parent_id' => ['nullable', 'integer'],
        ]);

        $comment = new Comment();
        if (!auth()->check() && !auth('customer')->check()) {
            $request->validate([
                'name' => ['required', 'string', 'min:2'],
                'email' => ['required', 'email'],
            ]);
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->status = 0;
        } else {
            if (auth()->check()) {
                $comment->commentator_type = User::class;
                $comment->commentator_id = auth()->id();
                $comment->status = 1;
            } else {
                $comment->commentator_type = Customer::class;
                $comment->commentator_id = auth('customer')->id();
                $comment->status = 0;
            }
        }

        $comment->parent_id = $request->input('parent_id', null);
        $comment->body = $request->input('message');
        $comment->commentable_type = $request->input('commentable_type');
        $comment->commentable_id = $request->input('commentable_id');
        $comment->ip = request()->ip();
        $comment->save();

        return redirect()->back()->with(['message' => __('Your comment has been submitted')]);
    }

    public function search(Request $request)
    {

    }

    public function group(Group $group){
        $area = 'group';
        $title = $group->name;
        $subtitle = $group->subtitle;
        $posts = $group->posts()->orderByDesc('id')->paginate($this->paginate);
        return view('client.group', compact('area', 'posts', 'title', 'subtitle','group'));
    }
}
