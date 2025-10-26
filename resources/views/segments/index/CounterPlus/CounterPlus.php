<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class CounterPlus
{
    public static $count = 4 ;
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'counter-plus-item-bg']);
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' counter plus item bg';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#000000';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'counter-plus-item-text-color']);
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' counter plus item bg';
        $setting->save();

        for ($i = 1; $i <= self::$count; $i++) {

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_title'.$i;
            $setting->value =  "Counter ".$i;
            $setting->size = 4;
            $setting->type = 'TEXT';
            $setting->title =  $part->area_name . ' ' . $part->part. ' title '.$i;
            $setting->save();

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_icon'.$i;
            $setting->value = 'ri-user-line';
            $setting->size = 6;
            $setting->type = 'ICON';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 6]);
            $setting->title =  $part->area_name . ' ' . $part->part. ' icon '.$i;
            $setting->save();


            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_link'.$i;
            $setting->value =  "#".$i;
            $setting->size = 6;
            $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
            $setting->title =  $part->area_name . ' ' . $part->part. ' link '.$i;
            $setting->save();

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_number'.$i;
            $setting->value = rand(100,4000);
            $setting->size = 4;
            $setting->type = 'NUMBER';
            $setting->data = json_encode(['xmin' => 0, 'xmax' => 9007199254740992]);
            $setting->title =  $part->area_name . ' ' . $part->part. ' number '.$i;
            $setting->save();
        }
    }
    public static function onRemove(Part $part = null)
    {
        for ($i = 1; $i <= self::$count; $i++) {
            Setting::where('key',$part->area_name . '_' . $part->part.'_title'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.'_icon'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.'_number'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.'_link'.$i)->first()?->delete();

        }
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
