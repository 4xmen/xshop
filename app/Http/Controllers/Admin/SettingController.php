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
use Spatie\Image\Image;

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
        $cats = Category::all(['id', 'name'])->toArray();
        $menus = Menu::all(['id', 'name']);
        $groups = Group::all(['id', 'name'])->toArray();
        $catz = array_merge([['id' => 0, 'name' => __('All')]], $cats);
        $groupz = array_merge([['id' => 0, 'name' => __('All')]], $groups);
        return view('admin.commons.setting',
            compact('settings', 'cats', 'groups', 'menus', 'catz', 'groupz'));
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
        logAdmin(__METHOD__, __CLASS__, $set->id);
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
            if ($set == null) {
                continue;
            }
            if ($set->type == 'PRODUCT_QUERY' || $set->type == 'POST_QUERY') {
                $set->value = implode(',', $val);
                $set->raw = implode(',', $val);
                $set->save();
            } elseif ($set != null && !$request->hasFile($key)) {

                $set->value = validateSettingRequest($set, $val);
                $set->raw = validateSettingRequest($set, $val);
                // need to test
                if (config('app.xlang.active') && config('app.xlang.main') != 'en' && (
                        $set->type != 'TEXT' && $set->type != 'EDITOR' && $set->type != 'LONGTEXT')) {
                    $set->setTranslation('value', 'en', $val);
                }
                $set->save();
            }
        }
        $files = $request->allFiles();
        if (isset($files['file'])) {
            $format = getSetting('optimize');
            foreach ($files['file'] as $index => $file) {
                if (($file->guessExtension() == 'jpg' || $file->guessExtension() == 'png') && ($index != 'site_image')) {

                    $i = Image::load($file->getRealPath())
                        ->optimize()
                        ->format($format);

                    $file->move(public_path('upload/images/'), str_replace('_', '.', $index));//store('/images/'.,['disk' => 'public']);
                    $optimizedFile = public_path('upload/images/optimized-') . str_replace('_', '.', $index);
                    $optimizedFile = str_replace(['jpg', 'png', 'gif'], 'webp', $optimizedFile);
                    $i->save($optimizedFile);
                } else
                    if ($file->guessExtension() == 'mp4' || $file->guessExtension() == 'mp3') {
                        $file->move(public_path('upload/media/'), str_replace('_', '.', $index));//store('/images/'.,['disk' => 'public']);
                    } else {

                        $file->move(public_path('upload/file/'), str_replace('_', '.', $index));//store('/images/'.,['disk' => 'public']);
                    }
            }
        }

        if ($request->has('build')) {
            Artisan::call('build');
        }
        logAdmin(__METHOD__, __CLASS__, null);
        return redirect()->back()->with(['message' => __('Setting of website updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function cacheClear()
    {
        $f = Setting::where('key', 'cache_number')->first();
        $f->value += 1;
        $f->save();
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return redirect()->back()->with(['message' => __('Cache cleared')]);
    }

    public function liveEdit($slug)
    {
        $settings = Setting::where('active', true)->where('key', 'LIKE', $slug . '%')
            ->orderBy('section')->get();
        $cats = Category::all(['id', 'name'])->toArray();
        $catz = array_merge([['id' => 0, 'name' => __('All')]], $cats);
        $menus = Menu::all(['id', 'name']);
        $groups = Group::all(['id', 'name'])->toArray();
        $groupz = array_merge([['id' => 0, 'name' => __('All')]], $groups);
        return view('admin.commons.live',
            compact('settings', 'cats', 'groups', 'menus', 'catz', 'groupz'));
    }
}
