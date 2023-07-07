<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingSaveRequest;
use App\Models\Cat;
use App\Models\Setting;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\MenuItem;
use Xmen\StarterKit\Models\Post;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
//        $settings = Setting::orderBy('section')->get();
        $settings = Setting::where('active', 1)->orderBy('section')->get();  //ESH// just active setting`s show
        $cats = Category::all();
        $pcats = Cat::all();
        return view('admin.setting', compact('settings', 'cats','pcats'));
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingSaveRequest $request) {
        //

        $set = new Setting();
        $set->title = $request->title;
        $set->key = $request->key;
        $set->section = $request->section;
        $set->type = $request->type;
        $set->save();
        return redirect()->back()->with(['message' => __('Setting added to website')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        //
        $all = $request->all();
        foreach ($all as $key => $val) {
            $set = Setting::where('key', $key)->first();
            if ($set != null && !$request->hasFile($key)) {
                $set->value = $val;
                $set->save();
            }
        }
        $files = $request->allFiles();
        if (isset($files['pic'])) {
            foreach ($files['pic'] as $index => $file) {
//            $name = time() . '.' . $file->getClientOriginalExtension();
//            Setting::where('key',$key)->update(['value' => $name]);
//            $request->file($index)->storeAs('public/setting', $name);
                $file->move(public_path('/images/'), str_replace('_','.',$index) );//store('/images/'.,['disk' => 'public']);
            }
        }
        return redirect()->back()->with(['message' => __('Setting of website updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function tagsearch($query) {
        $query = trim($query);
        return Tag::where('name', 'LIKE', "%$query%")->limit(5)->pluck('name')->toArray();
    }

    public function postsearch($query) {
        $query = trim($query);
        return Post::where('title', 'LIKE', "%$query%")->limit(5)->get(['id', 'title'])->toArray();
    }

    public function remMenu($id){
        MenuItem::where('menuable_id',$id)->delete();
        return true;
    }
}
