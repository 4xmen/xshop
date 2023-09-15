<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentClientRequest;
use App\Http\Requests\ContactSaveRequest;
use App\Http\Requests\customerUpdateRequest;
use App\Http\Requests\ProfileCustomerRequest;
use App\Http\Requests\QuestionClientRequest;
use App\Models\Attachment;
use App\Models\Cat;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Question;
use App\Models\Sms;
use App\Models\Transport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\P;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Video;
use Xmen\StarterKit\Controllers\Admin\LogController;
use Xmen\StarterKit\Models\Adv;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Clip;
use Xmen\StarterKit\Models\Comment;
use Xmen\StarterKit\Models\Gallery;
use Xmen\StarterKit\Models\Poll;
use Xmen\StarterKit\Models\Post;
use Xmen\StarterKit\Models\Slider;
use Xmen\StarterKit\Requests\CommentSaveRequest;
use function App\Helpers\getColors;
use function App\Helpers\getSetting;
use function App\Helpers\sendSMSText;
use function Xmen\StarterKit\Helpers\gLog;


class WebsiteController extends Controller
{

    private $sort = 'id';

    public function __construct()
    {
        if (getSetting('sort') == 'yes') {
            $this->sort = 'stock_quantity';
        }
    }

    //
    public function index()
    {

        if (!auth()->check() && \App\Helpers\getSetting('under') == 1) {
            return redirect('/under/index.php');
        }
        $cats = Cat::whereNull('parent_id')->limit(6)->get();
        $sliders = Slider::whereActive(true)->limit(5)->get();
//        $vid = Clip::latest()->where('active', 1)->first();

        $discount = Discount::whereNotNull('expire')
            ->where('expire', '>', date('Y-m-d'))
            ->whereNotNull('product_id')->pluck('product_id')->toArray();
        $disPros = Product::whereIn('id', $discount)->get();

        return view('website.index', compact('cats', 'sliders', 'disPros'));
    }

    public function cat(Cat $cat, Request $request)
    {

        $q = $cat->products()->where('active', 1)
            ->orderByRaw("FIELD(stock_status, \"IN_STOCK\", \"BACK_ORDER\", \"OUT_STOCK\")")
            ->orderByDesc($this->sort)->orderByDesc('id');
        if ($request->has('ext')) {
            $q = $q->where('stock_status', 'IN_STOCK')
                ->where('stock_quantity','>',0);
        }
        if ($request->has('from')) {
            $q = $q->where('price', '>=', $request->input('from'));
        }
        if ($request->has('to')) {
            $q = $q->where('price', '<=', $request->input('to'));
        }
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case "fav":
                    $q = $q->orderByDesc('average_rating');
                    break;
                case "cheap":
                    $q = $q->orderBy('price');
                    break;
                case "new":
                    $q = $q->orderByDesc('id');
                    break;
                case "expensive":
                    $q = $q->orderByDesc('price');
                    break;
                default:
                    $q = $q->orderByDesc('sell_count');
                    break;
            }
        } else {
            $q = $q->orderByDesc('sell_count');
        }
        if (isset($request->meta) && isset($request->meta['material'])){
//            dd(array_column(json_decode($request->meta['material'],true),'value'));
            if (count(json_decode($request->meta['material'],true) ) > 0){
                $q->whereMetaIn('material',array_column(json_decode($request->meta['material'],true),'value'));
            }
        }
        if (isset($request->meta) && isset($request->meta['size'])) {
            $id = Quantity::where('count','>',0)
                ->where('data','LIKE','%"size":"'.$request->meta['size'].'"%')
                ->pluck('product_id')->toArray();
            $q->whereIn('id',$id);
        }
        if (isset($request->meta) && isset($request->meta['color'])) {
            $id = Quantity::where('count','>',0)
                ->where('data','LIKE','%"color":"'.$request->meta['color'].'"%')
                ->pluck('product_id')->toArray();
            $q->whereIn('id',$id);
        }

        $products = $q->paginate(16);
        return view('website.cat', compact('cat', 'products'));
    }

    public function products()
    {
        $sld = Slider::inRandomOrder()->first();
        $products = Product::orderByDesc($this->sort)
            ->orderByDesc('id')->paginate(16);
        return view('website.products', compact('products', 'sld'));
    }

    public function product($pro)
    {

        if (is_numeric($pro)){
            $pro = Product::whereId($pro)->first();
            if ($pro == null){
                $pro = Product::inRandomOrder()->limit(1)->first();
            }

            return  redirect()->route('product',$pro->slug);

        }else{
            $pro = Product::whereSlug($pro)->first();
        }

        $cat = $pro->category;
//        $p = Product::first()->;
        $pro->increment('view_count');

        $comments = $pro->approved_comments()->paginate(10);
        return view('website.product', compact('pro', 'cat', 'comments'));
    }

    public function searchAjax(Request $request)
    {
        if (!$request->has('q') || mb_strlen(trim($request->q)) < 3) {
            $msg = __('Invalid search');
            return ['OK' => false, 'err' => $msg];
        }
        $q = trim($request->q);

        $products = Product::where(function ($query) use ($q) {
            $query->where('name', 'LIKE', '%' . $q . '%')
                ->orWhere('description', 'LIKE', '%' . $q . '%');
        })->where('active', 1)
            ->orderByDesc('stock_quantity')->limit(3)->get();

        $pros = [];
        foreach ($products as $product) {
            $pros[] = [
                'name' => $product->name,
                'link' => route('product', $product->slug),
                'image' => $product->thumbUrl(),
                'price' => $product->stock_quantity == 0 ? 'ناموجود' : $product->getPrice(),
            ];
        }
        return ['OK' => true, 'data' => $pros];
    }

    public function search(Request $request)
    {
        if (!$request->has('q') || mb_strlen(trim($request->q)) < 3) {

            $msg = __('Invalid search');
            $title = __('Search for') . ' :';
            return view('website.products', compact('msg', 'title'));
        }
        $q = trim($request->q);
        $title = __('Search for') . ' :' . $q;

        $products = Product::where(function ($query) use ($q) {
            $query->where('name', 'LIKE', '%' . $q . '%')
                ->orWhere('description', 'LIKE', '%' . $q . '%');
        })->orderByDesc('stock_quantity')->where('active', 1)
            ->paginate(16);

        $posts = Post::where(function ($query) use ($q) {
            $query->where('title', 'LIKE', '%' . $q . '%')
                ->orWhere('body', 'LIKE', '%' . $q . '%');
        })->where('status', 1)->paginate(16);


        return view('website.products', compact('products', 'title', 'posts'));
    }

    public function post(Post $post)
    {
        $comments = $post->comments()->paginate(15);
        $sld = Slider::inRandomOrder()->first();
        return view('website.post', compact('post', 'comments', 'sld'));
    }

    public function gallery(Gallery $gallery)
    {
        $title = $gallery->title;
        $subtitle = __('Gallery');
        return view('website.gallery', compact('gallery', 'title', 'subtitle'));
    }


    public function galleries()
    {
        $title = __('Galleries list');
        $subtitle = __('Galleries');
        $galleries = Gallery::where('status', 1)->paginate(16);
        return view('website.galleries', compact('galleries', 'title', 'subtitle'));
    }

    public function clips()
    {
        $title = __('Pediatric dental clips');
        $subtitle = __('Clips');
        $clips = Clip::where('active', 1)->paginate(16);
        return view('website.clips', compact('clips', 'title', 'subtitle'));
    }


    public function tag($tag)
    {
        $title = __('Tag') . ' ' . $tag;
        $subtitle = __('Tagged by') . ' ' . $tag;
        $posts = Post::withAnyTag($tag)->paginate();
        return view('website.posts', compact('posts', 'tag', 'title', 'subtitle'));
    }

    public function category(Category $category)
    {
        $title = __('Category') . ' ' . $category->name;
        $subtitle = __('Category') . ' ' . $category->name;
        $posts = $category->posts()->where('status', 1)->paginate(10);
        return view('website.posts', compact('posts', 'title', 'subtitle'));
    }

    public function posts()
    {
        $title = __('All posts');
        $subtitle = '';
        $posts = Post::where('status', 1)
            ->orderByDesc('id')->paginate(10);
        return view('website.posts', compact('posts', 'title', 'subtitle'));
    }


    public function like(Post $news, Request $request)
    {

        if (!gLog(Post::class, $news->id, 'like', $request)) {
            return ['OK' => false, 'msg' => __("You liked ago ") . $news->title];
        }

        if ($request->input('action') == 1) {
            $news->increment('like');
            return ['OK' => true, 'msg' => __("You liked ") . $news->title];
        } else {
            $news->increment('dislike');
            return ['OK' => true, 'msg' => __("You disliked ") . $news->title];
        }
    }

    public function vote(Poll $poll, Request $request)
    {

        if (!gLog(Poll::class, $poll->id, 'vote', $request)) {
            return redirect()->back()->with(['message' => __("You voted ago ") . $poll->title]);
        }


        $poll->opinions()->where('id', $request->input('poll' . $poll->id))
            ->increment('vote');
        return redirect()->route('n.poll', $poll->slug)
            ->with(['message' => __("You voted right now ") . $poll->title]);

    }

    public function poll(Poll $poll, Request $request)
    {
        $count = $poll->opinions()->sum('vote');
        $canVote = gLog(Poll::class, $poll->id, 'vote', $request, false);
        return view('website.poll', compact('poll', 'count', 'canVote'));
    }


    public function commentPost(Post $post, CommentClientRequest $request)
    {

//        return $news;
//        return $request->all();
        $data = [
            'email' => $request->email,
            'body' => $request->body,
            'name' => $request->name,
            'ip' => $request->ip()
        ];
//        if ($request->has('parent') && $request->parent != null) {
//            $data['sub_comment_id'] = $request->parent;
//        }
//        $news->comments()->create(
//            $data
//        );


//        return $news;
        $comment = new Comment();
        $comment->commentable_id = $post->id;
        $comment->commentable_type = 'Xmen\StarterKit\Models\Post';
        $comment->email = $request->email;
        $comment->body = $request->body;
        $comment->name = $request->name;
        $comment->ip = $request->ip();

        if ($request->has('parent') && $request->parent != null) {
//            $data['sub_comment_id'] = $request->parent;
            $comment->sub_comment_id = $request->parent;
        }

        $comment->save();

        return redirect()->route('post', $post->slug . '#comment-form')->with(['message' => __('Your comment submited successfully, After approve will be visbile.')]);

    }

    public function commentProduct(Product $product, CommentClientRequest $request)
    {

//        return $news;
//        return $request->all();
        $data = [
            'email' => $request->email,
            'body' => $request->body,
            'name' => $request->name,
            'ip' => $request->ip()
        ];
//        if ($request->has('parent') && $request->parent != null) {
//            $data['sub_comment_id'] = $request->parent;
//        }
//        $news->comments()->create(
//            $data
//        );


//        return $news;
        $comment = new Comment();
        $comment->commentable_id = $product->id;
        $comment->commentable_type = 'App\Models\Product';
        $comment->email = $request->email;
        $comment->body = $request->body;
        $comment->name = $request->name;
        $comment->ip = $request->ip();

        if ($request->has('parent') && $request->parent != null) {
//            $data['sub_comment_id'] = $request->parent;
            $comment->sub_comment_id = $request->parent;
        }

        $comment->save();

        return redirect()->route('product', $product->slug . '#comment-form')->with(['message' => __('Your comment submited successfully, After approve will be visbile.')]);

    }

    public function goadv(Adv $adv)
    {
        $adv->increment('click');
        if ($adv->max_click != 0 && $adv->max_click < $adv->click) {
            $adv->update(['active' => false]);
        }
        return redirect($adv->link);
    }

    public function compare()
    {
        $arr = unserialize(session('to_compare', serialize([])));
        $pros = Product::whereIn('id', $arr)->get();
        return view('website.compare', compact('pros'));
    }

    public function compareAdd(Product $pro)
    {
        $arr = unserialize(session('to_compare', serialize([])));
        if (!in_array($pro->id, $arr)) {
            $arr[] = $pro->id;
            session(['to_compare' => serialize($arr)]);
        }
        $pros = Product::whereIn('id', $arr)->get();
        return view('website.compare', compact('pros'));
    }

    public function compareRem(Product $pro)
    {
        $arr = unserialize(session('to_compare', serialize([])));
        if (in_array($pro->id, $arr)) {
            unset($arr[array_search($pro->id, $arr)]);
            session(['to_compare' => serialize($arr)]);
        }
        return redirect()->route('compare');
    }

    public function cardAdd($id)
    {
        $arr = unserialize(session('card', serialize([])));
        $arr2 = unserialize(session('qcard', serialize([])));
        if (!in_array($id, $arr)) {
            $arr[] = $id;
            session(['card' => serialize($arr)]);
        }
        return ['OK' => true, 'msg' => __('Added to card'), 'data' => count(array_merge($arr, $arr2))];
    }

    public function cardAddQ($id, $count)
    {
        $arr = unserialize(session('qcard', serialize([])));
        $counts = unserialize(session('qcounts', serialize([])));
        $arr2 = unserialize(session('card', serialize([])));
        if (!in_array($id, $arr)) {
            $arr[] = $id;
            $counts[] = $count;
            session(['qcard' => serialize($arr)]);
            session(['qcounts' => serialize($counts)]);
        }
        return ['OK' => true, 'msg' => __('Added to card'), 'data' => count(array_merge($arr, $arr2))];
    }

    public function cardRem($id)
    {
        $arr = unserialize(session('card', serialize([])));
        if (($key = array_search($id, $arr)) !== false) {
            unset($arr[$key]);
        }
        session(['card' => serialize($arr)]);
        return redirect()->route('card.show')->with(['message' => __('Product removed form card')]);
    }

    public function cardRemQ($id)
    {
        $arr = unserialize(session('qcard', serialize([])));
        $counts = unserialize(session('qcounts', serialize([])));

        if (($key = array_search($id, $arr)) !== false) {
            unset($arr[$key]);
            unset($counts[$key]);
        }
        session(['qcard' => serialize($arr)]);
        return redirect()->route('card.show')->with(['message' => __('Product removed form card')]);
    }

    public function card()
    {

        $arr = unserialize(session('card', serialize([])));
        $pros = Product::whereIn('slug', $arr)->get();
        $arr = unserialize(session('qcard', serialize([])));
        $counts = unserialize(session('qcounts', serialize([])));
        $qpros = Quantity::whereIn('id', $arr)->get();
        $transports = Transport::orderBy('sort')->orderBy('price')->get();
        $resevers = Invoice::where('reserve',1)->where('customer_id', \auth('customer')->id())
            ->whereBetween('created_at',
                [
                    Carbon::now()->subHour((int)getSetting('reserve')),
                    Carbon::now(),
                ])->get();
        \Session::put('shoping_card','1');
        \Session::save();
        return view('website.card', compact('pros', 'transports', 'qpros', 'counts', 'resevers'));
    }

    public function sign()
    {
        if (\Auth::guard('customer')->check()) {
            return redirect()->route('customer');
        }

        if (config('app.sms_signup')) {
            return view('website.signsms');
        } else {
            return view('website.sign');
        }
    }

    public function questionSend(QuestionClientRequest $request)
    {
        $q = new Question();
        $q->product_id = $request->product_id;
        $q->body = $request->body;
        $q->customer_id = Auth::guard('customer')->id();
        $q->save();
        return json_encode(['OK' => true, 'msg' => __('Your question has been sent, We answer it soon.')]);
    }

    public function mag()
    {
        $posts = Post::where('status', 1)->paginate(10);
        $title = __('Magazine');
        return view('website.posts', compact('posts', 'title'));
    }

    public function sendSMS(Request $request)
    {
//        $this->sendSMS($request->mobile,)
        $code = rand(10000, 99999);
        $mobile = $request->mobile;
        $text = config('app.name') . PHP_EOL . __("Your authentication code") . ': ' . $code;
        $sms = new Sms();
        $sms->ip = $request->ip();
        $sms->text = $text;
        $sms->code = $code;
        $sms->mobile = $mobile;
        $sms->save();
        if (Customer::where('mobile', $mobile)->count() > 0) {
            $c = Customer::where('mobile', $mobile)->first();
            $c->code = $code;
            $c->save();
        }
        sendSMSText($mobile, $text);
        return ['OK' => true, 'msg' => __('SMS send, Please login with you Auth code')];
    }

    public function checkSMS(Request $request)
    {
        $code = $request->pass;
        $mobile = $request->mobile;
        if (Customer::where('mobile', $mobile)->count() > 0) {

            if (Customer::where('mobile', $mobile)->where('code', $code)->count() > 0){
                Auth::guard('customer')->loginUsingId(Customer::where('mobile', $mobile)
                    ->where('code', $code)->first()->id);
                return ['OK' => true, 'msg' => __('Welcome')];
            }else{
                return ['OK' => false, 'err' => __('Auth code error')];
            }
            // login
        } else {
            // register
            if (Sms::where([['ip', $request->ip()], ['code', $code], ['created_at', '>=', Carbon::now()->subHours(1)->toDateTimeString()]])->count() == 0) {
                return ['OK' => false, 'err' => __('Auth code error')];
            } else {
                $c = new Customer();
                $c->mobile = $mobile;
                $c->save();
                Auth::guard('customer')->loginUsingId($c->id);
                return ['OK' => true, 'msg' => __('Welcome')];
            }
        }
    }

    public function profile(ProfileCustomerRequest $request)
    {
        $customer = Customer::whereId(Auth::guard('customer')->id())->firstOrFail();
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->state = $request->input('state');
        $customer->city = $request->input('city');
        $customer->description = $request->input('description');
        $customer->postal_code = $request->input('postal_code');
        $customer->email = $request->input('email');
//        $customer->mobile = $request->input('mobile');
        if (trim($request->input('password')) != '') {
            $customer->password = bcrypt($request->input('password'));
        }
        $customer->save();
        return redirect()->route('customer')->with(['message' => __("Profile updated")]);
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('sign');
    }

    public function discount(Request $request)
    {
        if ($request->code == '') {
            return abort(404);
        }
        return Discount::where('code', $request->code)->firstOrFail();
    }

    public function track()
    {
        $attaches = Attachment::orderBy('id', 'desc')->paginate(20);
        return view('website.track', compact('attaches'));
    }

    public function favToggle(Product $product)
    {
        if (\auth('customer')->check()) {
            if (\auth('customer')->user()->products()->where('product_id', $product->id)->exists()) {
                \auth('customer')->user()->products()->where('product_id', $product->id)->detach();
                return ['OK' => true, 'msg' => __('Product removed from favorite'), 'liked' => false];
            } else {
                \auth('customer')->user()->products()->attach($product->id);
                return ['OK' => true, 'msg' => __('Product added to favorite'), 'liked' => true];
            }
        } else {
            return ['OK' => false, 'msg' => 'You must login to do this action'];
        }
    }

    public function contact()
    {
        $title = __('ContactUs');
        return view('website.contact', compact('title'));
//        return view('website.contact');
    }

    public function sendContact(ContactSaveRequest $request)
    {
        $con = new  Contact();
        $con->full_name = $request->full_name;
        $con->email = $request->email;
        $con->Phone = $request->Phone;
        $con->subject = $request->subject;
        $con->body = $request->bodya;
        $con->save();
        return redirect()->back()->with(['message' => __('Your message has been successfully sent.')]);
    }

    public function reset()
    {
        \Session::remove('card');
        \Session::remove('qcard');
        \Session::remove('qcounts');
        \Session::save();
        return __('Card cleared') . '...';

    }

    static public function resetStockStatus(){
        Product::whereStockQuantity('0')->update(['stock_status' => 'OUT_STOCK']);
        return 'Done!';
    }

    static public  function resetQuantity(){

        $qs =  Quantity::groupBy('product_id')
            ->select('product_id', DB::raw('sum(`count`) as count'))
            ->get();
        foreach ($qs as $q){
            $p = Product::whereId($q->product_id)->first();
            if ($p != null){
                $p->stock_quantity = $q->count;
                $p->save();
            }
        }
        return 'Done!';
    }

}

