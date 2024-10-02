<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class ParallaxShort
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/bg.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Title of the parallax';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis dolor enim reprehenderit.';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' subtitle';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle')->first()?->delete();
        File::delete(public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
