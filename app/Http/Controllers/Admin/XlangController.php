<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\XlangSaveRequest;
use App\Models\Cat;
use App\Models\Product;
use App\Models\Prop;
use App\Models\Setting;
use App\Models\Xlang;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Artisan;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Clip;
use Xmen\StarterKit\Models\Gallery;
use Xmen\StarterKit\Models\Image;
use Xmen\StarterKit\Models\MenuItem;
use Xmen\StarterKit\Models\Post;
use Xmen\StarterKit\Models\Slider;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

const PREFIX_PATH = __DIR__ . '/../../../../';
class XlangController extends Controller
{

    public $allowedModels = [
        Product::class,
        Cat::class,
        Post::class,
        Category::class,
        Slider::class,
        MenuItem::class,
        Gallery::class,
        Clip::class,
        Prop::class,
        Setting::class,
        Image::class
    ];

    public function createOrUpdate(Xlang $xlang, XlangSaveRequest $request)
    {
        $xlang->name = $request->input('name');
        $xlang->tag = $request->input('tag');
        $xlang->rtl = $request->has('rtl');

        $xlang->is_default = $request->has('is_default');
        if ($xlang->is_default) {
            Xlang::where('is_default', '1')->update([
                'is_default' => 0,
            ]);
        }


        if ($request->hasFile('img')) {
            $name = time() . '.' . request()->img->getClientOriginalExtension();
            $xlang->img = $name;
            $request->file('img')->storeAs('public/langz', $name);
        }
        $xlang->save();
        return $xlang;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Artisan::call('translator:update');
        $langs = Xlang::paginate(99);
        return view('admin.langs.langIndex', compact('langs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.langs.langForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(XlangSaveRequest $request)
    {
        //
        if ($request->tag != 'en') {

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

        $xlang = new Xlang();
        $xlang = $this->createOrUpdate($xlang, $request);
        logAdmin(__METHOD__, Xlang::class, $xlang->id);
        return redirect()->route('admin.lang.index')->with(['message' => __('Lang') . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Xlang $xlang
     * @return \Illuminate\Http\Response
     */
    public function show(Xlang $xlang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Xlang $xlang
     * @return \Illuminate\Http\Response
     */
    public function edit(Xlang $xlang)
    {
        //
        return view('admin.langs.langForm', compact('xlang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Xlang $xlang
     * @return \Illuminate\Http\Response
     */
    public function update(XlangSaveRequest $request, Xlang $xlang)
    {
        //
        $xlang = $this->createOrUpdate($xlang, $request);
        logAdmin(__METHOD__, Xlang::class, $xlang->id);
        return redirect()->route('admin.lang.index')->with(['message' => __('Lang') . ' ' . __('updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Xlang $xlang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Xlang $xlang)
    {
        //
        $xlang->delete();
        logAdmin(__METHOD__, Xlang::class, $xlang->id);
        return redirect()->route('admin.lang.index')->with(['message' => __('Lang') . ' ' . __('deleted successfully')]);
    }

    public function translate()
    {
        $langs = Xlang::all();
//        return  Product::where('name->en',null)->get();
        return view('admin.langs.translateIndex', compact('langs'));
    }


    public function download($tag)
    {
        define("TRANSLATE_FILE", PREFIX_PATH . 'resources/lang/' . $tag . '.json');
        return response()->download(TRANSLATE_FILE, $tag . '.json');
    }

    public function ai($tag)
    {

//        set_time_limit(300);

        define("TRANSLATE_FILE", PREFIX_PATH . 'resources/lang/' . $tag . '.json');
        $file = file_get_contents(TRANSLATE_FILE);
        $url = config('app.xlang_api_url').'/json?form=en&to=' . $tag;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $response = $client->post($url,
            ['body' => $file]
        );
        file_put_contents(TRANSLATE_FILE, $response->getBody()->getContents());
        return redirect()->back()->with(['message' => __("Translated by ai xstack service:") . ' ' . $tag]);
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

    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('transports deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), XlangController::class, $request->input('id'));
                XlangController::destroy($request->input('id'));
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.lang.index')->with(['message' => $msg]);
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
        return view('admin.langs.translate', compact('model', 'translates', 'langs', 'cls'));
    }

    public function translateModelSave($id, $model, Request $request)
    {

        if (!in_array($model, $this->allowedModels)) {
            return abort(404);
        }
        $langs = Xlang::where('is_default', 0)->get();
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
        $url = config('app.xlang_api_url').'/text?form=' . config('app.xlang_main') . '&to=' . $tag;

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
