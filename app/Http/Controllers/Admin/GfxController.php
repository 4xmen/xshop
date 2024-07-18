<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Gfx;
use Illuminate\Http\Request;

class GfxController extends Controller
{
    //
    public function index()
    {
        $prviews = Area::whereNotNull('preview')
            ->pluck('preview', 'name')->toArray();

        array_walk($prviews, function ($value, $key) use (&$prviews) {
            $prviews[$key] = route($value);
        });
        return view('admin.commons.gfx',compact('prviews'));
    }

    public function update(Request $request)
    {

        foreach ($request->input('gfx', []) as $key => $gfx) {
            $g = Gfx::where('key', $key)->first();
            if ($g != null) {
                $g->value = $gfx;
                $g->save();
            }
        }

        logAdmin(__METHOD__, __CLASS__, null);
        \Artisan::call('client');
        return redirect()->back()->with(['message' => __('GFX of website updated')]);
    }
}
