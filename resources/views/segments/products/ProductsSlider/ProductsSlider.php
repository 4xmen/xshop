<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;

class ProductsSlider
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Lorem ipsum dolor sit amet';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_query';
        $setting->value = Category::first()->id.',id,DESC';
        $setting->type = 'PRODUCT_QUERY';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' query';
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
