<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class HodHeader
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_png';
        $setting->value = 'url("'.asset('upload/images/'.$part->area_name . '.' . $part->part.'.png').'")';
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' pattern image';
        $setting->data = json_encode(['name' => 'hod-img']);
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/hodhod.png',public_path('upload/images/').$part->area_name . '.' . $part->part.'.png');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_png')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
