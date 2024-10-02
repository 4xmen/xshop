<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;

class FavProductWithMeta
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = "Fav product";
        $setting->type = 'text';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part;
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part;
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part;
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {


        Setting::where('key',$part->area_name . '_' . $part->part)->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
