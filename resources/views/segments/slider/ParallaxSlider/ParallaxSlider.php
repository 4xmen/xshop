<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use App\Models\Slider;

class ParallaxSlider
{
    public static function onAdd(Part $part = null)
    {
        Slider::addData($part->area_name . '_' . $part->part . '_btn','View offer');
        Slider::addData($part->area_name . '_' . $part->part . '_link','/');
        Slider::addData($part->area_name . '_' . $part->part . '_subtitle','Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aliquid aspernatur, commodi corporis cupiditate');
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#000000';
        $setting->data = json_encode(['name' => 'parallax-color']);
        $setting->type = 'COLOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' text color';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Slider::remData($part->area_name . '_' . $part->part . '_btn');
        Slider::remData($part->area_name . '_' . $part->part . '_link');
        Slider::remData($part->area_name . '_' . $part->part . '_subtitle');
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
