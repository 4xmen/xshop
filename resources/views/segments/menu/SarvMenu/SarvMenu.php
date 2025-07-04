<?php

namespace Resources\Views\Segments;

use App\Models\Menu;
use App\Models\Part;
use App\Models\Setting;

class SarvMenu
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = __("Download app");
        $setting->size = 4;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_link';
        $setting->value = __("link");
        $setting->size = 4;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' link';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_icon';
        $setting->value = 'ri-mobile-download-line' ;
        $setting->size = 4;
        $setting->type = 'ICON';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' icon';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_menu';
        $setting->value = Menu::first()->id;
        $setting->type = 'MENU';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' menu';
        $setting->save();




        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#dddddd';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'sarv-color']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' menu text color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'sarv-bg']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();




    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_icon')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_link')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_menu')->first()?->delete();
    }


    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
