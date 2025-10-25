<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class StoriesDefault
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_timeout';
        $setting->value = '10';
        $setting->size = 10;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' =>3, 'xmax' => 30]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' time out (seconds)';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_timeout')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
