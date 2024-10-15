<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class ParallelCategoriesGrid
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Main categories';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' parallel categories title';
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
