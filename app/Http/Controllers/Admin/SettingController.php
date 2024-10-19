<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingSaveRequest;
use App\Models\Category;
use App\Models\Group;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $settings = Setting::where('active', true)
            ->orderBy('section')->get();  //ESH// just active setting`s show
        $cats = Category::all(['id','name']);
        $menus = Menu::all(['id','name']);
        $groups = Group::all(['id','name']);
        return view('admin.commons.setting',
            compact('settings', 'cats','groups','menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingSaveRequest $request)
    {
        //
        $set = new Setting();
        $set->title = $request->title;
        $set->key = $request->key;
        $set->section = $request->section;
        $set->type = $request->type;
        $set->size = $request->size;
        $set->save();
        logAdmin(__METHOD__,__CLASS__,$set->id);
        return redirect()->back()->with(['message' => __('Setting added to website')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $all = $request->all();
        foreach ($all as $key => $val) {
            $set = Setting::where('key', $key)->first();
            if ($set != null && !$request->hasFile($key)) {

                $set->value = validateSettingRequest($set,$val);
                $set->raw = validateSettingRequest($set,$val);
                // need to test
                if (config('app.xlang.active') && config('app.xlang.main') != 'en' && (
                    $set->type != 'TEXT' && $set->type != 'EDITOR' && $set->type != 'LONGTEXT')){
                    $set->setTranslation('value','en' , $val);
                }
                $set->save();
            }
        }
        $files = $request->allFiles();
        if (isset($files['file'])) {
            foreach ($files['file'] as $index => $file) {
                if ($file->guessExtension() == 'mp4' || $file->guessExtension() == 'mp3'){
                    $file->move(public_path('upload/media/'), str_replace('_','.',$index) );//store('/images/'.,['disk' => 'public']);
                }else{
                    $file->move(public_path('upload/images/'), str_replace('_','.',$index) );//store('/images/'.,['disk' => 'public']);
                }
            }
        }
        logAdmin(__METHOD__,__CLASS__,null);
        return redirect()->back()->with(['message' => __('Setting of website updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function cacheClear(){
        $f = Setting::where('key','cache_number')->first();
        $f->value += 1;
        $f->save();
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return redirect()->back()->with(['message' => __('Cache cleared')]);
    }
}
