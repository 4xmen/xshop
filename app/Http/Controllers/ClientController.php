<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Post;
use App\Models\Product;
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

        if ($post->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'post';
        $title = $post->title;
        $subtitle = $post->subtitle;
        $post->increment('view');
        return view('client.post', compact('area', 'post', 'title', 'subtitle'));
    }

    public function gallery(Gallery $gallery)
    {
        if ($gallery->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'gallery';
        $title = $gallery->title;
        $subtitle = \Str::limit(strip_tags($gallery->description), 15);
        $gallery->increment('view');
        return view('client.gallery', compact('area', 'gallery', 'title', 'subtitle'));
    }

    public function posts()
    {
        $area = 'posts-list';
        $title = __("Posts list");
        $subtitle = '';
        $posts = Post::where('status', 1)
            ->orderByDesc('id')->paginate($this->paginate);
        return view('client.default-list', compact('area', 'posts', 'title', 'subtitle'));
    }

    public function products()
    {
        $area = 'products-list';
        $title = __("Products list");
        $subtitle = '';
        $products = Product::where('status', 1)
            ->orderByDesc('id')->paginate($this->paginate);
        return view('client.default-list', compact('area', 'products', 'title', 'subtitle'));
    }

    public function galleries()
    {
        $area = 'galleries-list';
        $title = __("Galleries list");
        $subtitle = '';
        $galleries = Gallery::where('status', 1)
            ->orderByDesc('id')->paginate($this->paginate);
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

    public function group(Group $group)
    {
        $area = 'group';
        $title = $group->name;
        $subtitle = $group->subtitle;
        $posts = $group->posts()->orderByDesc('id')->paginate($this->paginate);
        return view('client.group', compact('area', 'posts', 'title', 'subtitle', 'group'));
    }

    public function attachDl(Attachment $attachment)
    {
        $attachment->increment('downloads');
        $file = (storage_path() . '/app/public/attachments/' . $attachment->file);
        if (file_exists($file)) {
            return response()->download($file);
        }
    }


    public function productCardToggle(Product $product)
    {

        $quantity = \request()->input('quantity', null);
        if (\Cookie::has('card')) {
            $cards = json_decode(\Cookie::get('card'),true);
            $qs = json_decode(\Cookie::get('q'),true);
            if (in_array($product->id, $cards)) {
                $msg = "Product removed from card";
                $i = array_search($product->id, $cards);
                unset($cards[$i]);
                unset($qs[$i]);
            } else {
                $cards[] = $product->id;
                $qs[] = $quantity;
                $msg = "Product added to card";
            }
            $count = count($cards);
            \Cookie::queue('card', json_encode($cards), 2000);
            \Cookie::queue('q', json_encode($qs), 2000);
        } else {
            $count = 1;
            $msg = "Product added to card";
            \Cookie::queue('card', "[$product->id]", 2000);
            \Cookie::queue('q', "[$quantity]", 2000);
            $qs = [$quantity];
            $cards = [$product->id];
        }

        if ($count > 0 && auth('customer')->check()) {
            $customer = auth('customer')->user();
            $customer->card = json_encode(['cards' => $cards, 'quantities' => $qs]);
            $customer->save();
        }

        if (\request()->ajax()) {
            return success(['count' => $count], $msg);
        } else {
            return redirect()->back()->with(['message' => $msg]);
        }
    }

    public function productCompareToggle(Product $product)
    {
        if (\Cookie::has('compares')) {
            $compares = json_decode(\Cookie::get('compares'),true);
            if (in_array($product->id, $compares)) {
                $msg = "Product removed from compare";
                unset($compares[array_search($product->id, $compares)]);
            } else {
                $compares[] = $product->id;
                $msg = "Product added to compare";
            }
            \Cookie::queue('compares', json_encode($compares), 2000);
        } else {
            $msg = "Product added to compare";
            \Cookie::queue('compares', "[$product->id]", 2000);
        }

        if (\request()->ajax()) {
            return success(null, $msg);
        } else {
            return redirect()->back()->with(['message' => $msg]);
        }
    }

    public function ProductFavToggle(Product $product)
    {
        if (!auth('customer')->check()) {
            return errors([
                __("You need to login first"),
            ], 403, __("You need to login first"));
        }

        if (auth('customer')->user()->favorites()->where('product_id', $product->id)->count() == 0) {
            auth('customer')->user()->favorites()->attach($product->id);
            $message = __('Product added to favorites');
            $fav = '1';
        } else {
            auth('customer')->user()->favorites()->detach($product->id);
            $message = __('Product removed from favorites');
            $fav = '0';
        }

        if (\request()->ajax()) {
            return success($fav, $message);
        } else {
            return redirect()->back()->with(['message' => $message]);
        }
    }
}
