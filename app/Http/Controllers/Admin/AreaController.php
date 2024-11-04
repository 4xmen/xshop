<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\Group;
use App\Models\Part;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AreaController extends Controller
{
    //
    public function index()
    {
        $areas = Area::orderByDesc('sort')->orderBy('name')->get();
        return view('admin.areas.area-list', compact('areas'));
    }

    public function design(Area $area)
    {

        $valids = [];
        foreach ($area->segment as $seg) {
            if (File::exists(resource_path() . '/views/segments/' . $seg)) {
                $dirs = File::directories(resource_path() . '/views/segments/' . $seg);
                foreach ($dirs as $dir) {
                    $temp = explode('/', $dir);
                    $valids[] = [
                        'segment' => $temp[count($temp) - 2],
                        'part' => $temp[count($temp) - 1],
                        'data' => json_decode(file_get_contents($dir . '/' . $temp[count($temp) - 1] . '.json'), true)
                    ];
                }
            }
        }

        return view('admin.areas.area-design', compact('area', 'valids'));
    }

    public function designModel(Area $area, $model, $id)
    {

        switch ($model) {
            case 'Group':
                $m = Group::whereId($id)->first();
                break;
            case 'Category':
                $m = Category::whereId($id)->first();
                break;
            case 'Post':
                $m = Post::whereId($id)->first();
                break;
            case 'Product':
                $m = Product::whereId($id)->first();
                break;
            default:
                return abort(404);
        }

        $valids = [];
        foreach ($area->segment as $seg) {
            if (File::exists(resource_path() . '/views/segments/' . $seg)) {
                $dirs = File::directories(resource_path() . '/views/segments/' . $seg);
                foreach ($dirs as $dir) {
                    $temp = explode('/', $dir);
                    $valids[] = [
                        'segment' => $temp[count($temp) - 2],
                        'part' => $temp[count($temp) - 1],
                        'data' => json_decode(file_get_contents($dir . '/' . $temp[count($temp) - 1] . '.json'), true)
                    ];
                }
            }
        }

        $parts = $area->parts;
        foreach ($parts as $part) {
            $part->id = null;
        }
        if ($m->theme == null) {
            $data = ['parts' => $parts, 'use_default' => $area->use_default,'max' => 10];
        } else {
            $data = json_decode($m->theme, true);
        }
        return view('admin.areas.model-design', compact('m', 'valids', 'data', 'model'));
    }

    /**
     * screenshot segment
     * @param $segment
     * @param $part
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function image($segment, $part)
    {
        return response()->file(resource_path() . '/views/segments/' . $segment . '/' . $part . '/screenshot.png', ['Content-Type' => 'image/png']);
    }

    public function update(Request $request, Area $area)
    {
//        return $request->all();
        foreach ($request->input('parts', []) as $i => $item) {
            $data = json_decode($item);
            if ($data == null) {
                continue;
            }
            if ($data->id == null) {
                // create
                $part = new Part();
                $part->area_id = $area->id;
                $part->segment = $data->segment;
                $part->part = $data->part;
                $part->sort = $i;
                $part->save();
            } else {
                $part = Part::whereId($data->id)->first();
                $part->segment = $data->segment;
                $part->part = $data->part;
                $part->sort = $i;
                $part->save();
            }
        }
        foreach (json_decode($request->input('removed')) as $id) {
            Part::where('id', $id)->first()->delete();
        }
        \Artisan::call('client');

        logAdmin(__METHOD__, __CLASS__, $area->id);

        if ($request->has('use_default')) {
            $area->use_default = 1;
        } else {
            $area->use_default = 0;
        }
        $area->save();


        return redirect()->back()->with(['message' => __('area :NAME of website updated', ['NAME' => $area->name])]);
    }

    public function updateModel(Request $request, $model, $id)
    {

//        return $request->all();
        switch ($model) {
            case 'Group':
                $m = Group::whereId($id)->first();
                break;
            case 'Category':
                $m = Category::whereId($id)->first();
                break;
            case 'Post':
                $m = Post::whereId($id)->first();
                break;
            case 'Product':
                $m = Product::whereId($id)->first();
                break;
            default:
                return abort(404);
        }


        foreach ($request->input('parts', []) as $i => $item) {
            $data = json_decode($item);
            if ($data == null) {
                continue;
            }
            if ($data->id == null) {
                // create
                $part = new Part();
                $part->area_id = null;
                $part->segment = $data->segment;
                $part->part = $data->part;
                $part->sort = $i;
                $part->custom = $model.$m->id;
                $part->save();
            } else {
                $part = Part::whereId($data->id)->first();
                $part->segment = $data->segment;
                $part->part = $data->part;
                $part->sort = $i;
                $part->save();
            }
        }
        foreach (json_decode($request->input('removed')) as $id) {
            Part::where('id', $id)->first()->delete();
        }
        \Artisan::call('client');

        logAdmin(__METHOD__, __CLASS__, $m->id);

        $m->theme = [
            'parts' => Part::where('custom',$model.$m->id)->get(),
            'use_default' => ($request->has('use_default')),
            'max' => 10,
        ];

        $m->save();


        return redirect()->back()->with(['message' => __('area :NAME of website updated', ['NAME' => $model.$m->id ])]);

    }

    public function sort(Area $area)
    {
        return view('admin.areas.area-sort', compact('area'));
    }

    public function sortSave(Request $request)
    {
        foreach ($request->input('items') as $key => $v) {

            $p = Part::whereId($v['id'])->first();
            $p->sort = $key;
            $p->save();
        }
        logAdmin(__METHOD__, __CLASS__, $p->area_id);
        return ['OK' => true, 'message' => __("As you wished sort saved")];
    }

    public function build(){

        $exitCode = \Artisan::call('client');
        $exitCode = \Artisan::call('build');

        // Get the command output from cache
        $output = cache()->get('build_command_output', 'No output available');

//        return response()->json([
//            'success' => $exitCode === 0,
//            'exit_code' => $exitCode,
//            'output' => $output
//        ]);
        logAdmin(__METHOD__, __CLASS__, null);
        if ($exitCode == 0){
            \Log::info($output);
            return redirect()->back()->with(['message' => __('Assets build successfully')]);
        }else{
            \Log::error($output);
            return redirect()->back()->with(['message' => __('Assets build failed')]);
        }
    }
}
