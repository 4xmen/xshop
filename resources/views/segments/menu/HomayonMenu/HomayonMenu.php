<?php

namespace Resources\Views\Segments;

use App\Models\Menu;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class HomayonMenu
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = __("Shop");
        $setting->size = 4;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title';
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
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'homayon-color']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' menu text color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#dddddd';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'homayon-bg']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg2';
        $setting->value = gfx()['primary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'homayon-bg-menu']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_btn';
        $setting->value = 1;
        $setting->size = 4;
        $setting->type = 'CHECKBOX';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' shop btn';
        $setting->save();


        File::copy(__DIR__.'/../../default-assets/header-circle.svg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.svg');



    }
    public static function onRemove(Part $part = null)
    {

        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_menu')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_btn')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
