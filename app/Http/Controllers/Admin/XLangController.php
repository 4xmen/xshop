<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\XLangSaveRequest;
use App\Models\Access;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\City;
use App\Models\Clip;
use App\Models\Discount;
use App\Models\Gallery;
use App\Models\Group;
use App\Models\Image;
use App\Models\Item;
use App\Models\Post;
use App\Models\Product;
use App\Models\Prop;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\State;
use App\Models\Transport;
use App\Models\XLang;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Helper;
use Illuminate\Support\Facades\Artisan;
use Spatie\Image\Image as SpatieImage;
use Spatie\Tags\Tag;
use function App\Helpers\hasCreateRoute;


const PREFIX_PATH = __DIR__ . '/../../../../';

class XLangController extends XController
{

    public $allowedModels = [
        Attachment::class,
        Discount::class,
        Product::class,
        Category::class,
        Post::class,
        Group::class,
        Slider::class,
        Item::class,
        Gallery::class,
        Clip::class,
        Prop::class,
        Setting::class,
        Image::class,
        State::class,
        City::class,
        Transport::class,
        Tag::class,
    ];


    // protected  $_MODEL_ = XLang::class;
    // protected  $SAVE_REQUEST = XLangSaveRequest::class;

    protected $cols = ['name', 'tag', 'emoji', 'is_default'];
    protected $extra_cols = ['id', 'img'];

    protected $searchable = [];

    protected $listView = 'admin.xlangs.xlang-list';
    protected $formView = 'admin.xlangs.xlang-form';


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'show' =>
            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(XLang::class, XLangSaveRequest::class);
    }

    /**
     * @param $xlang XLang
     * @param $request  XLangSaveRequest
     * @return XLang
     */
    public function save($xlang, $request)
    {


        if ($xlang->id == null && $request->tag != 'en') {

            define("TRANSLATE_CONFIG_PATH", PREFIX_PATH . 'config/translator.php');
            define("TRANSLATE_NEW_FILE", PREFIX_PATH . 'resources/lang/' . $request->tag . '.json');
            $config = file_get_contents(TRANSLATE_CONFIG_PATH);
            $re = '/\'languages\' \=\> (.*)\,/m';
            preg_match_all($re, $config, $matches, PREG_SET_ORDER, 0);
            $oldLangs = $matches[0][1];

            $newLans = json_encode(array_unique(array_merge(json_decode($oldLangs), [$request->tag])));
            $newConfig = (str_replace($oldLangs, $newLans, $config));
            file_put_contents(TRANSLATE_CONFIG_PATH, $newConfig);

            if (!file_exists(TRANSLATE_NEW_FILE)) {
                file_put_contents(TRANSLATE_NEW_FILE, '{}');
            }
        }
        $xlang->name = $request->input('name');
        $xlang->tag = $request->input('tag');
        $xlang->rtl = $request->has('rtl');

        $xlang->is_default = $request->has('is_default');
        if ($xlang->is_default) {
            Xlang::where('is_default', '1')->update([
                'is_default' => 0,
            ]);
        }

        if (!$request->has('emoji')) {
            $xlang->emoji = $request->input('emoji');
        } else {
            $xlang->emoji = getEmojiLanguagebyCode($xlang->tag);
        }


        if ($request->has('img')) {
            $xlang->img = $this->storeFile('img', $xlang, 'langz');
            $key = 'img';
            $format = $request->file($key)->guessExtension();
            if (strtolower($format) == 'png') {
                $format = 'webp';
            }
            $i = SpatieImage::load($request->file($key)->getPathname())
                ->optimize()
//                ->nonQueued()
                ->format($format);
            $i->save(storage_path() . '/app/public/langz/optimized-' . $xlang->$key);
        }
        $xlang->save();
        Artisan::call('translator:update');
        return $xlang;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view($this->formView);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(XLang $item)
    {
        //
        return view($this->formView, compact('item'));
    }

    public function bulk(Request $request)
    {

//        dd($request->all());
        $data = explode('.', $request->input('action'));
        $action = $data[0];
        $ids = $request->input('id');
        switch ($action) {
            case 'delete':
                $msg = __(':COUNT items deleted successfully', ['COUNT' => count($ids)]);
                $this->_MODEL_::destroy($ids);
                break;
            /**restore*/
            case 'restore':
                $msg = __(':COUNT items restored successfully', ['COUNT' => count($ids)]);
                foreach ($ids as $id) {
                    $this->_MODEL_::withTrashed()->find($id)->restore();
                }
                break;
            /*restore**/
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(XLang $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, XLang $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(XLang::withTrashed()->where('id', $item)->first());
    }

    /*restore**/

    public function translate()
    {
        $langs = Xlang::all();
//        return  Product::where('name->en',null)->get();
        return view('admin.xlangs.xlang-translates', compact('langs'));
    }

    public function download($tag)
    {
        define("TRANSLATE_FILE", PREFIX_PATH . 'resources/lang/' . $tag . '.json');
        return response()->download(TRANSLATE_FILE, $tag . '.json');
    }

    public function upload($tag, Request $request)
    {
        define("TRANSLATE_FILE", PREFIX_PATH . 'resources/lang/' . $tag . '.json');
        if (!$request->hasFile('json')) {
            return redirect()->back();
        }
        $data = (file_get_contents($request->file('json')->getRealPath()));
        if (json_decode($data) == null) {
            return redirect()->back()->withErrors(__("Invalid json file!"));
        }
        file_put_contents(TRANSLATE_FILE, $data);
        return redirect()->back()->with(['message' => __("Translate updated")]);
    }


    public function ai($tag)
    {

//        set_time_limit(300);

        define("TRANSLATE_FILE", PREFIX_PATH . 'resources/lang/' . $tag . '.json');
        $file = file_get_contents(TRANSLATE_FILE);
        $url = config('app.xlang.api_url') . '/json?form=en&to=' . $tag;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $response = $client->post($url,
            ['body' => $file]
        );
        file_put_contents(TRANSLATE_FILE, $response->getBody()->getContents());
        return redirect()->back()->with(['message' => __("Translated by ai xstack service :TAG", ['TAG' => $tag])]);
    }

    public function translateModel($id, $model)
    {

        if (!in_array($model, $this->allowedModels)) {
            return abort(404);
        }
        $langs = Xlang::where('is_default', 0)->get();
        $cls = $model;
        $model = ($model)::where('id', $id)->firstOrFail();
//        return $model;
        $translates = $model->translatable;
        return view('admin.xlangs.xlang-translate-model', compact('model', 'translates', 'langs', 'cls'));
    }

    public function translateModelSave($id, $model, Request $request)
    {

        if (!in_array($model, $this->allowedModels)) {
            return abort(404);
        }
//        $langs = Xlang::where('is_default', 0)->get();
        $model = ($model)::where('id', $id)->firstOrFail();
//        $model = Product::whereId('id',$id)->first();
        foreach ($request->input('data') as $lang => $items) {
            foreach ($items as $k => $item) {
                if ($item != null) {
                    $model->setTranslation($k, $lang, $item);
                }
            }
        }


        $model->save();
        return redirect()->back()->with(['message' => __('Translate updated')]);

    }

    public function translateModelAi($id, $model, $tag, $field)
    {

        if (!in_array($model, $this->allowedModels)) {
            return abort(404);
        }
        $langs = Xlang::where('is_default', 0)->get();
        $model = ($model)::where('id', $id)->firstOrFail();
//        $model = Product::whereId('id',$id)->first();
        $url = config('app.xlang.api_url').'/text?form=' . config('app.xlang_main') . '&to=' . $tag;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
        ]);

        $response = $client->post($url,
            ['form_params' => ['body' => $model->$field]],
        );
//        file_put_contents(TRANSLATE_FILE, $response->getBody());
        if ($response->getStatusCode() != 200) {
            return redirect()->back()->withErrors(__("API error!"));
        }
//        dd($response->getBody()->getContents());
        $model->setTranslation($field, $tag, $response->getBody()->getContents());
        $model->save();
        return redirect()->back()->with(['message' => __('Translate updated')]);

    }

}
