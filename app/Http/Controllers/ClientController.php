<?php

namespace App\Http\Controllers;

use App\Contracts\Payment;
use App\Http\Requests\ContactSubmitRequest;
use App\Mail\AuthMail;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Clip;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\Post;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Plank\Metable\Meta;
use Spatie\Tags\Tag;

class ClientController extends Controller
{

    public function __construct()
    {

        $this->middleware(function ($request, $next) {

            if ($request->attributes->get('set_lang') != true) {
                app()->setLocale(config('app.locale'));
                \Session::remove('locate');
            } elseif (\Session::has('locate')) {
                app()->setLocale(\Session::get('locate'));
            }

            return $next($request);
        });

    }

    public $paginate = 12;

    //
    public function welcome()
    {
        $area = 'index';
        $title = config('app.name');
        $subtitle = getSetting('subtitle');
        return view('client.welcome', compact('area', 'title', 'subtitle'));
    }

    public function post($slug)
    {

        $post = Post::where('slug', $slug)->firstOrFail();

        if ($post->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'post';
        $title = $post->title;
        $subtitle = $post->subtitle;
        $post->increment('view');
        $breadcrumb = [
            __('Posts') => postsUrl(),
            $post->mainGroup->name => $post->mainGroup->webUrl(),
            $post->title => null,
        ];
        return view('client.post', compact('area', 'post', 'title', 'subtitle', 'breadcrumb'));
    }

    public function clip($slug)
    {

        $clip = Clip::where('slug', $slug)->firstOrFail();

        if ($clip->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'clip';
        $title = $clip->title;
        $subtitle = '';
        $breadcrumb = [
            __('Video clips') => clipsUrl(),
            $clip->title => null,
        ];
        $model = $clip;
        return view('client.default-list', compact('area', 'clip', 'title', 'subtitle', 'breadcrumb','model'));
    }

    public function gallery($slug)
    {

        $gallery = Gallery::where('slug', $slug)->firstOrFail();
        if ($gallery->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'gallery';
        $title = $gallery->title;
        $subtitle = \Str::limit(strip_tags($gallery->description), 15);
        $gallery->increment('view');
        $breadcrumb = [
            __('Galleries') => gallariesUrl(),
            $gallery->title => null,
        ];
        return view('client.gallery', compact('area', 'gallery', 'title', 'subtitle', 'breadcrumb'));
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

    public function attachment($slug)
    {

        $attachment = Attachment::where('slug', $slug)->firstOrFail();
        $area = 'attachment';
        $title = $attachment->title;
        $subtitle = $attachment->subtitle;
        $breadcrumb = [
            __('Attachments') => attachmentsUrl(),
            $attachment->title => null,
        ];
        $model = $attachment;
        return view('client.default-list', compact('area', 'attachment', 'title', 'subtitle', 'breadcrumb','model'));
    }

    public function tag($slug)
    {

        $tag = Tag::where('slug->' . config('app.locale'), 'like', $slug)->first();
        $posts = Post::withAnyTags([$tag])->where('status', 1)->paginate(100);
        $products = Product::withAnyTags([$tag])->where('status', 1)->paginate(100);
        $clips = Clip::withAnyTags([$tag])->where('status', 1)->paginate(100);
        $title = __('Tag') . ': ' . $tag->name;
        $subtitle = '';
        return view('client.tag', compact('tag', 'posts', 'products', 'clips', 'title', 'subtitle'));
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

        if ($request->input('parent_id') != '') {
            $comment->parent_id = $request->input('parent_id', null);
        }
        $comment->body = $request->input('message');
        $comment->commentable_type = $request->input('commentable_type');
        $comment->commentable_id = $request->input('commentable_id');
        $comment->ip = request()->ip();
        $comment->save();

        return redirect()->back()->with(['message' => __('Your comment has been submitted')]);
    }

    public function search(Request $request)
    {

        if (isGuestMaxAttemptTry('search', 5, 1)) {
            return  abort(403);
        }

        guestLog('search');

        $q = trim($request->input('q'));
        if (mb_strlen($q) < 3) {
            return abort(403, __('Search word is too short'));
        }
        $q = '%' . $q . '%';
        $posts = Post::where('status', 1)->where(function ($query) use ($q) {
            $query->where('title', 'LIKE', $q)
                ->orWhere('subtitle', 'LIKE', $q)
                ->orWhere('body', 'LIKE', $q);
        })->paginate(100);
        $products = Product::where('status', 1)->where(function ($query) use ($q) {
            $query->where('name', 'LIKE', $q)
                ->orWhere('excerpt', 'LIKE', $q)
                ->orWhere('description', 'LIKE', $q);
        })->paginate(100);
        $clips = Clip::where('status', 1)->where(function ($query) use ($q) {
            $query->where('title', 'LIKE', $q)
                ->orWhere('body', 'LIKE', $q);
        })->paginate(100);
        $title = __('Search for') . ': ' . $request->input('q');
        $subtitle = '';
        $noIndex = true;
        return view('client.tag', compact('posts', 'products', 'clips', 'title', 'subtitle','noIndex'));
    }

    public function group($slug)
    {

        $group = Group::where('slug', $slug)->firstOrFail();
        $area = 'group';
        $title = $group->name;
        $subtitle = $group->subtitle;
        $posts = $group->posts()->where('status', 1)->orderByDesc('id')->paginate($this->paginate);

        if ($group->parent_id == null) {
            $breadcrumb = [
                __('Posts') => postsUrl(),
                $group->name => null,
            ];
        } else {
            $breadcrumb = [
                __('Posts') => postsUrl(),
                $group->parent->name => $group->parent->webUrl(),
                $group->name => null,
            ];

        }
        return view('client.group', compact('area', 'posts', 'title', 'subtitle', 'group', 'breadcrumb'));
    }

    public function product($slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail();
        if ($product->status = 0 && !auth()->check()) {
            return abort(403);
        }
        $area = 'product';
        $title = $product->name;
        $subtitle = $product->excerpt; // WIP SEO
        $breadcrumb = [
            __('Products') => productsUrl(),
            $product->category->name => $product->category->webUrl(),
        ];
        if ($product->category->parent_id != null) {
            $breadcrumb[$product->category->parent->name] = $product->category->parent->webUrl();
        }
        $breadcrumb[$product->name] = null;
        return view('client.product', compact('area', 'product', 'title', 'subtitle', 'breadcrumb'));
    }

    public function category($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
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

        if ($category->parent_id == null) {
            $breadcrumb = [
                __('Products') => productsUrl(),
                $category->name => null,
            ];
        } else {
            $breadcrumb = [
                __('Products') => productsUrl(),
                $category->parent->name => $category->parent->webUrl(),
                $category->name => null,
            ];

        }
        return view('client.category', compact('area', 'products', 'title', 'subtitle', 'category', 'breadcrumb'));
    }

    public function attachDl($slug)
    {
        $attachment = Attachment::where('slug', $slug)->firstOrFail();
        $attachment->increment('downloads');
        $file = (storage_path() . '/app/public/attachments/' . $attachment->file);
        if (file_exists($file)) {
            return response()->download($file);
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

    public function contact()
    {
        $area = 'contact-us';
        $title = __("Contact us");
        $subtitle = '';
        return view('client.default-list', compact('area', 'title', 'subtitle'));
    }

    public function sendContact(ContactSubmitRequest $request)
    {
        $con = new  Contact();
        $con->name = $request->full_name;
        $con->email = $request->email;
        $con->mobile = $request->phone;
        $con->subject = $request->subject;
        $con->body = $request->bodya;
        $con->save();
        return redirect()->back()->with(['message' => __('Your message has been successfully sent.')]);
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
        $subtitle = __('Sign in as customer');
        return view('client.default-list', compact('area', 'title', 'subtitle'));
    }

    public function signUp()
    {
        if (config('app.sms.sign')){
            return  abort(403);
        }
        $area = 'register';
        $title = __("sign up");
        $subtitle = __('Sign up as customer');
        return view('client.default-list', compact('area', 'title', 'subtitle'));
    }
    public function signUpNow(Request $request)
    {
        if (config('app.sms.sign')){
            return  abort(403);
        }

        $request->validate([
            'email' => ['required','email']
        ]);

        if (isGuestMaxAttemptTry('email', 1, 5)) {
           return  redirect()->back()->withErrors( __('You try attempts, Try it a few minutes'));
        }

        guestLog('email');

        $passwd = generateUniqueID(12);
        Mail::to($request->input('email'))->send(new AuthMail($passwd));
        $c = Customer::where('email', $request->email);
        if ($c->count() > 0) {
            $customer = $c->first();
            $msg = __('Your account password has been changed successfully.');
        }else{
            $customer = new Customer();
            $customer->email = $request->email;
            $msg = __('Your account has been created successfully.');
        }
        $customer->password = bcrypt($passwd);
        $customer->save();

        return  redirect()->back()->with(['message' => $msg . __("Please check your email to find password, Don't forget check spam/junk too, If you find our email in spam folder, Please mark it `Not spam`")]);
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

        if (config('app.sms.driver') == 'Kavenegar') {
            $args = [
                'receptor' => $request->input('tel'),
                'template' => trim(getSetting('sign')),
                'token' => $code
            ];
        } else {
            $args = [
                'code' => $code,
            ];
        }

        sendingSMS(getSetting('sign'), $request->input('tel'), $args);

        Log::info('auth code: ' . $code);
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


    public function sitemap()
    {

        $latestGroup = \App\Models\Group::orderByDesc('updated_at')->first();
        // Get the most recent Category
        $latestCategory = \App\Models\Category::orderByDesc('updated_at')->first();

        // Initialize a variable to hold the latest update time
        $latestUpdate = null;

        // Check if we have a latestGroup and latestCategory and compare their updated_at
        if ($latestGroup) {
            $latestUpdate = $latestGroup->updated_at;
        }

        if ($latestCategory) {
            if (!$latestUpdate || $latestCategory->updated_at > $latestUpdate) {
                $latestUpdate = $latestCategory->updated_at;
            }
        }
        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap',compact('latestUpdate'))->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }
    public function sitemapGroupCategory()
    {


        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap-groups-category')->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }
    public function sitemapPosts()
    {
        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap-posts')->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }
    public function sitemapProducts()
    {
        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap-products')->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }
    public function sitemapClips()
    {
        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap-clips')->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }
    public function sitemapGalleries()
    {
        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap-gallries')->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }
    public function sitemapAttachments()
    {
        $xmlContent = '<?xml version="1.0" encoding="utf-8" ?>' . PHP_EOL;
        $xmlContent .= view('website.sitemaps.sitemap-attachments')->render(); // Render the view and append to XML content

        // Return the XML response
        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function lang(Request $request)
    {

        $uri = '/' . $request->path();
        // Iterate through all the defined routes
        $r = null;
        $n = '';
        foreach (Route::getRoutes() as $route) {

            // Just check client routes
            if (substr($route->getName(), 0, 7) != 'client.' || $route->getName() == 'client.welcome') {
                continue;
            }

            $uri2 = str_replace('/', '\\/', $route->uri());
            $uri2 = preg_replace('/\{[a-z]*\}/m', '.*', $uri2);
            // Check if the route matches the given URI
            if (preg_match('/' . $uri2 . '/', $uri)) {
                $r = $route->action['controller'];
                $n = $route->uri();
                break;
            }
        }
        if (count(explode('@', $r)) == 1) {
            return abort(404);
        }
        $method = explode('@', $r)[1];
        $segments = $request->segments();
        $routes = explode('/', $n);
        $args = [];
        foreach ($routes as $i => $route) {
            if ($route[0] == '{') {
                $args[] = $segments[$i + 1];
            }
        }
        $args[] = $request;
        return $this->$method(...$args);
    }

    public function langIndex()
    {
        return $this->welcome();
    }


    public function pay($hash)
    {

        $invoice = Invoice::where('hash', $hash)->first();
//        dd($invoice->created_at->timestamp , (time() - 3600));

        if (!in_array($invoice->status, ['PENDING', 'CANCELED', 'FAILED']) || $invoice->created_at->timestamp < (time() - 3600)) {
            return redirect()->back()->withErrors(__('This payment method is not available.'));
        }
        $activeGateway = config('xshop.payment.active_gateway');
        /** @var Payment $gateway */
        $gateway = app($activeGateway . '-gateway');
        logger()->info('pay controller', ["active_gateway" => $activeGateway, "invoice" => $invoice->toArray(),]);

        if ($invoice->isCompleted()) {
            return redirect()->back()->with('message', __('Invoice payed.'));
        }

        $callbackUrl = route('pay.check', ['invoice_hash' => $invoice->hash, 'gateway' => $gateway->getName()]);
        $payment = null;
        try {
            $response = $gateway->request((($invoice->total_price - $invoice->credit_price) * config('app.currency.factor')), $callbackUrl);
            $payment = $invoice->storePaymentRequest($response['order_id'], (($invoice->total_price - $invoice->credit_price) * config('app.currency.factor')), $response['token'] ?? null, null, $gateway->getName());
            session(["payment_id" => $payment->id]);
            \Session::save();

            return $gateway->goToBank();
        } catch (\Throwable $exception) {
            $invoice->status = 'FAILED';
            $invoice->save();
            \Log::error("Payment REQUEST exception: " . $exception->getMessage());
            \Log::warning($exception->getTraceAsString());
            $result = false;
            $message = __('error in payment. contact admin.');
            return redirect()->back()->withErrors($message);
        }
    }

    public function rate(Request $request)
    {
        $request->validate([
            'rate.*' => ['required', 'integer'],
            'rateable_id' => ['required', 'integer'],
            'rateable_type' => ['required', 'string'],
        ]);


        //        return $request->all();

        if (isGuestMaxAttemptTry('rate', 5, 10)) {
            return [
                'OK' => false,
                'message' => __('You try attempts, Try it a few minutes'),
                'error' => __('You try attempts, Try it a few minutes'),
            ];
        }

        guestLog('rate');

        $changed = false;
        foreach ($request->rate as $k => $rt) {


            $r = Rate::where('rateable_type', $request->rateable_type)
                ->where('rateable_id', $request->rateable_id)
                ->where('rater_type', Customer::class)
                ->where('rater_id', auth('customer')->id())
                ->where('evaluation_id', $k);
            if ($r->count() != 0) {
                $rate = $r->first();
                $changed = true;
            } else {
                $rate = new Rate();
            }
            if ($rt > 0 && $rt < 5) {
                $rate->rater_type = Customer::class;
                $rate->rater_id = auth('customer')->id();
                $rate->rateable_type = $request->rateable_type;
                $rate->rateable_id = $request->rateable_id;
                $rate->evaluation_id = $k;
                $rate->rate = $rt;
                $rate->save();
            }

        }
        if ($changed) {
            return [
                'OK' => true,
                'message' => __('Your rate updated'),
            ];
        }
        return [
            'OK' => true,
            'message' => __('Your rate registered'),
        ];
    }
}
