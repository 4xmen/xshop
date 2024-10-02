<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class WaveFooter
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_speed';
        $setting->value = 2;
        $setting->size = 4;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' speed wave 1';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_speed2';
        $setting->value = 6;
        $setting->size = 4;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' speed wave 2';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_speed3';
        $setting->value = 4;
        $setting->size = 4;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' speed wave 3';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_speed')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_speed2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_speed3')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
