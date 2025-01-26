<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class PedramProducts
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'My products';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color_bg';
        $setting->value = gfx()['primary'];
        $setting->data = json_encode(['name' => 'pedi-bg-color']);
        $setting->type = 'COLOR';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color_text';
        $setting->value = '#ffffff';
        $setting->data = json_encode(['name' => 'pedi-text-color']);
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

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'1_png';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/coin-left.png',public_path('upload/images/').$part->area_name . '.' . $part->part.'.png');
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'2_png';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/gold-right.png',public_path('upload/images/').$part->area_name . '.' . $part->part.'.png');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_category')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'1_png')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'2_png')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
