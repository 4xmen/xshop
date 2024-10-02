<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;

class CategoriesGrid
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value =  Category::first()->name;
        $setting->size = 4;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_limit';
        $setting->value = '4';
        $setting->size = 4;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 2, 'xmax' => 6]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' count';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_category';
        $setting->value = Category::first()->id;
        $setting->size = 4;
        $setting->type = 'CATEGORY';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' category';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_limit')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_category')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
