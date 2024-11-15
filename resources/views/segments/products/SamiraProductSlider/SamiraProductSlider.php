<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SamiraProductSlider
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Lorem ipsum dolor sit amet';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' titles';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_category';
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' category';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = gfx()['secondary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'samira-bg']);
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_limit';
        $setting->value = 4;
        $setting->size = 6;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 4, 'xmax' => 12]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' limit';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_webp';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' background pattern image';
        $setting->save();
        File::copy(__DIR__.'/../../default-assets/smoke.webp',public_path('upload/images/').$part->area_name . '.' . $part->part.'.webp');
        File::copy(__DIR__.'/../../default-assets/circle-3d-minify.svg',public_path('upload/images/').'circle-3d-minify.svg');

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_category')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_webp')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
