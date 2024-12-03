<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class OtherFooter
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_first';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid consequuntur culpa cupiditate dignissimos dolor doloremque error facilis ipsum iure officia quam qui, tempora! Fuga harum impedit iusto magnam veniam.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' last content';
        $setting->type = 'EDITOR';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Contact us';
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_dark';
        $setting->value = 0;
        $setting->size = 6;
        $setting->type = 'CHECKBOX';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' dark mode';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_last';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid consequuntur culpa cupiditate dignissimos dolor doloremque error facilis ipsum iure officia quam qui, tempora! Fuga harum impedit iusto magnam veniam.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' last content';
        $setting->type = 'EDITOR';
        $setting->save();




        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_loc';
        $setting->value = '35.83266,50.99155,13';
        $setting->size = 12;
        $setting->type = 'LOCATION';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' location';
        $setting->save();




    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_loc')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_first')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_last')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_dark')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
