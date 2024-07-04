<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AreaController extends Controller
{
    //
    public function index()
    {
        $areas = Area::all('name', 'icon');
        return view('admin.areas.area-list', compact('areas'));
    }

    public function desgin(Area $area)
    {

        $valids = [];
        foreach ($area->segment as $seg) {
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

        return view('admin.areas.area-design', compact('area', 'valids'));
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
        foreach ($request->input('parts',[]) as $item) {
            $data = json_decode($item);
            if ($data->id == null){
                // create
                $part = new Part();
                $part->area_id = $area->id;
                $part->segment = $data->segment;
                $part->part = $data->part;
                $part->save();
            }else{
                $part = Part::whereId($data->id)->first();
                $part->segment = $data->segment;
                $part->part = $data->part;
                $part->save();
            }
        }
        \Artisan::call('client');
        logAdmin(__METHOD__,__CLASS__,$area->id);
        return redirect()->back()->with(['message' => __('area :NAME of website updated',['NAME' => $area->name])]);
    }
}
