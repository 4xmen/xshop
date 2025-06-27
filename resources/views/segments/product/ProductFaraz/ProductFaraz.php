<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class ProductFaraz
{
    public static function onAdd(Part $part = null)
    {


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = "<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eligendi itaque unde? </p>";
        $setting->size = 12;
        $setting->type = 'EDITOR';
        $setting->title =  $part->area_name . ' ' . $part->part. ' content';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#111111';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'faraz-color']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' menu text color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'faraz-bg']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();


    }
    public static function onRemove(Part $part = null)
    {

        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
