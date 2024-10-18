<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;

class MaryamCategoryProducts
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Another products';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color_bg';
        $setting->value = '#1c213a';
        $setting->data = json_encode(['name' => 'maryam-bg-color']);
        $setting->type = 'COLOR';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color_text';
        $setting->value = '#ffae00';
        $setting->data = json_encode(['name' => 'maryam-text-color']);
        $setting->type = 'COLOR';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' text color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_category';
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' category';
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_category')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
