<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use App\Models\Slider;

class DowntownSlider
{
    public static function onAdd(Part $part = null)
    {
        Slider::addData($part->area_name . '_' . $part->part . '_btn','View offer');
        Slider::addData($part->area_name . '_' . $part->part . '_link','/');
        Slider::addData($part->area_name . '_' . $part->part . '_circle','I’ll then hold the Shift key and will click on the circle');
        Slider::addData($part->area_name . '_' . $part->part . '_subtitle','Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aliquid aspernatur, commodi corporis cupiditate');
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#000000';
        $setting->data = json_encode(['name' => 'downtown-color']);
        $setting->type = 'COLOR';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' text color';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#ffffff';
        $setting->data = json_encode(['name' => 'downtown-bg']);
        $setting->type = 'COLOR';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' bg color';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Slider::remData($part->area_name . '_' . $part->part . '_btn');
        Slider::remData($part->area_name . '_' . $part->part . '_link');
        Slider::remData($part->area_name . '_' . $part->part . '_subtitle');
        Slider::remData($part->area_name . '_' . $part->part . '_circle');
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
