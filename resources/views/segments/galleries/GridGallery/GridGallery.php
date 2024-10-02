<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class GridGallery
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = __('Galleries');
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' title';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_limit';
        $setting->value = 3;
        $setting->size = 6;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 2, 'xmax' => 6]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' limit';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_limit')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
