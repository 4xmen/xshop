<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Clip;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Post;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Plank\Metable\Meta;
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

    public function clip(Clip $clip)
    {

        if ($clip->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'clip';
        $title = $clip->title;
        $subtitle = '';
        return view('client.default-list', compact('area', 'clip', 'title', 'subtitle'));
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
    public function clips()
    {
        $area = 'clips-list';
        $title = __("Video clips list");
        $subtitle = '';
        $clips = Clip::where('status', 1)
            ->orderByDesc('id')->paginate($this->paginate);
        return view('client.default-list', compact('area', 'clips', 'title', 'subtitle'));
    }

    public function attachments()
    {
        $area = 'attachments-list';
        $title = __("Attachments list");
        $subtitle = '';
        $attachs = Attachment::where('is_fillable', 1)
            ->orderByDesc('id')->paginate($this->paginate);
        return view('client.default-list', compact('area', 'attachs', 'title', 'subtitle'));
    }
    public function attachment(Attachment $attachment)
    {
        $area = 'attachment';
        $title = $attachment->title;
        $subtitle = $attachment->subtitle;
        return view('client.default-list', compact('area', 'attachment', 'title', 'subtitle'));
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
        $posts = $group->posts()->where('status', 1)->orderByDesc('id')->paginate($this->paginate);
        return view('client.group', compact('area', 'posts', 'title', 'subtitle', 'group'));
    }

    public function product(Product $product)
    {
        if ($product->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'product';
        $title = $product->name;
        $subtitle = $product->excerpt; // WIP SEO
        return view('client.default-list', compact('area', 'product', 'title', 'subtitle'));
    }

    public function category(Category $category, Request $request)
    {
        $area = 'category';
        $title = $category->name;
        $subtitle = $category->subtitle;
        $query = $category->products()->where('status', 1);

        if ($request->has('only')) {
            $query->where('stock_quantity', '>', 0);
        }
        if ($request->has('sort') && $request->input('sort') != '') {
            switch ($request->input('sort')) {
                case 'oldest':
                    $query = $query->orderBy('id');
                    break;
                case 'cheap':
                    $query = $query->where('price', '<>', 0)->orderBy('price');
                    break;
                case 'expensive':
                    $query = $query->orderByDesc('price');
                    break;
                case 'fav':
                    $query = $query->orderByDesc('view');
                    break;
                case 'sale':
                    $query = $query->orderByDesc('sell');
                    break;
                default:
                    $query = $query->orderByDesc('id');

            }
        } else {
            $query = $query->orderByDesc('id');
        }


        if ($request->has('meta')) {
            foreach ($category->props()->where('searchable', 1)->get() as $prop) {
                if (isset($request->input('meta')[$prop->name]) && $request->input('meta')[$prop->name] != '' && $request->input('meta')[$prop->name] != '[]') {
                    switch ($prop->type) {
                        case 'checkbox':
                            if ($prop->priceable) {
                                $id = Quantity::where('count', '>', 0)
                                    ->where('data', 'LIKE', '%"' . $prop->name . '":%')
                                    ->pluck('product_id')->toArray();
                                $query->whereIn('id', $id);
                            } else {

                                $query->whereHasMeta($prop->name);
                            }
                            break;
                        case 'number':
                        case 'select':
                        case 'color':
                            if ($prop->priceable) {
                                $id = Quantity::where('count', '>', 0)
                                    ->where('data', 'LIKE', '%"' . $prop->name . '":"' . $request->meta[$prop->name] . '"%')
                                    ->pluck('product_id')->toArray();

                                $id = array_merge($id, $query->whereMeta($prop->name, $request->input('meta')[$prop->name])->pluck('id')->toArray());
                                $id = array_unique($id);
                                $query->whereIn('id', $id);
                            } else {
                                $query->whereMeta($prop->name, $request->input('meta')[$prop->name]);
                            }
                            break;
                        case 'text':
                            $query->whereMeta($prop->name, 'LIKE', '%' . $request->input('meta')[$prop->name] . '%');
                            break;
                        case 'multi':
                        case 'singlemulti':
                            if ($prop->priceable) {
                                $q = Quantity::where('count', '>', 0);
                                $metas = json_decode($request->meta[$prop->name], true);
                                $q->where(function ($query) use ($metas) {
                                    foreach ($metas as $meta) {
                                        $query->orWhere('data', 'LIKE', '%' . $meta . '%');
                                    }
                                });
                                $query->whereIn('id', $q->pluck('product_id')->toArray());
                            } else {
                                $q = Meta::where('key', $prop->name)->where('metable_type', Product::class);
                                $metas = json_decode($request->meta[$prop->name], true);
                                $q->where(function ($query) use ($metas) {
                                    foreach ($metas as $meta) {
                                        $query->orWhere('value', 'LIKE', '%' . $meta . '%');
                                    }
                                });

                                $query->whereIn('id', $q->pluck('metable_id')->toArray());
                            }

                    }
                }
            }
        }


        $products = $query->paginate($this->paginate);
        return view('client.category', compact('area', 'products', 'title', 'subtitle', 'category'));
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
            $cards = json_decode(\Cookie::get('card'), true);
            $qs = json_decode(\Cookie::get('q'), true);
            if (in_array($product->id, $cards)) {
                $found = false;
                foreach ($cards as $i => $card) {
                    if ($card == $product->id && $qs[$i] == $quantity) {
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    $msg = "Product removed from card";
                    unset($cards[$i]);
                    unset($qs[$i]);
                }else{
                    $cards[] = $product->id;
                    $qs[] = $quantity;
                    $msg = "Product added to card";
                }
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
            $compares = json_decode(\Cookie::get('compares'), true);
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


    public function compare()
    {
        $area = 'compare';
        $title = __("Compare products");
        $subtitle = '';
        $ids = json_decode(\Cookie::get('compares'), true);
        $products = Product::whereIn('id', $ids)->where('status', 1)->get();
        return view('client.default-list', compact('area', 'products', 'title', 'subtitle'));
    }


    public function signOut()
    {
        auth('customer')->logout();
        return redirect()->route('client.sign-in')->with(['message' => __("Signed out successfully")]);
    }

    public function signIn()
    {
        $area = 'login';
        $title = __("sign in");
        $subtitle = 'Sign in as customer';
        return view('client.default-list', compact('area', 'title', 'subtitle'));
    }

    public function signUp()
    {

    }

    public function singInDo(Request $request)
    {
        $max = 3;
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if (isGuestMaxAttemptTry('login', $max)) {
            return redirect()->back()->withErrors([__('You try more than :COUNT attempts, Try it later', ["COUNT" => $max])]);
        }

        guestLog('login');
        $customer = Customer::where('email', $request->input('email'));
        if ($customer->count() == 0) {
            return redirect()->back()->withErrors([__('Email or password is incorrect')]);
        }

        $customer = $customer->first();

        if (\Hash::check($request->input('password'), $customer->password)) {
            auth('customer')->login($customer);
            return redirect()->route('client.profile')->with(['message' => __('Signed in successfully')]);
        } else {
            return redirect()->back()->withErrors([__('Email or password is incorrect'), __('If you forget your password call us')]);
        }
    }

    public function profile()
    {
        return auth('customer')->user();
    }

    public function sendSms(Request $request)
    {

        if (isGuestMaxAttemptTry('sms', 1, 2)) {
            return [
                'OK' => false,
                'message' => __('You try attempts, Try it a few minutes'),
                'error' => __('You try attempts, Try it a few minutes'),
            ];
        }
        guestLog('sms');
        $customer = Customer::where('mobile', $request->input('tel'));
        $code = rand(11111, 99999);

        Log::info('auth code: '.$code );
        if ($customer->count() == 0) {
            $customer = new Customer();
            $customer->mobile = $request->input('tel');
            $customer->code = $code;
            $customer->save();
        } else {
            $customer = $customer->first();
            $customer->code = $code;
            $customer->save();
        }
        // WIP send sms

        return [
            'OK' => true,
            'message' => __('Auth code send successfully'),
        ];
    }

    public function checkAuth(Request $request)
    {
        $max = 3;
        $request->validate([
            'tel' => 'required|string|min:6',
            'code' => 'required|string|min:5',
        ]);

        if (isGuestMaxAttemptTry('login', $max)) {
            return redirect()->back()->withErrors([__('You try more than :COUNT attempts, Try it later', ["COUNT" => $max])]);
        }

        guestLog('login');

        $customer = Customer::where('mobile', $request->input('tel'))
            ->where('code', $request->input('code'))->first();

        if ($customer == null) {
            return [
                'OK' => false,
                'message' => __('Auth code is invalid'),
                'error' => __('Auth code is invalid'),
            ];
        }
        $customer->code = null;
        $customer->save();

        auth('customer')->login($customer);

        return [
            'OK' => true,
            'message' => __('You are logged in successfully'),
        ];

    }

}
