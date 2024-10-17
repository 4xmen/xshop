<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class NataliaCategories
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_category';
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' second category';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Modern categories';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' modern categories title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' modern categories subtitle';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_webp';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' background pattern image';
        $setting->save();


        File::copy(__DIR__.'/../../default-assets/woman-transparent.webp',public_path('upload/images/').$part->area_name . '.' . $part->part.'.webp');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_webp')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_category')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
