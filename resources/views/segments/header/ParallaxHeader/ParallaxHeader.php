<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class ParallaxHeader
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' default image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/bg.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
