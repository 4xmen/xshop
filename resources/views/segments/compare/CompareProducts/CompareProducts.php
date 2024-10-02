<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class CompareProducts
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'compare-bg']);
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' main color';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
