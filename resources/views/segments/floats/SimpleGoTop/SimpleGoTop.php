<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class SimpleGoTop
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_icon';
        $setting->value = 'ri-arrow-up-line';
        $setting->size = 12;
        $setting->type = 'ICON';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 6]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' icon ';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_icon')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
