<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class SimpleFooter
{
    public static function onAdd(Part $part = null)
    {


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title1';
        $setting->value = 'FAQ';
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title 1';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group1';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title2';
        $setting->value = 'FAQ';
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title 2';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group2';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group2';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_last';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid consequuntur culpa cupiditate dignissimos dolor doloremque error facilis ipsum iure officia quam qui, tempora! Fuga harum impedit iusto magnam veniam.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' last content';
        $setting->type = 'EDITOR';
        $setting->save();


//        $setting = new Setting();
//        $setting->section = 'theme';
//        $setting->key = $part->area_name . '_' . $part->part.'_bg';
//        $setting->value = '#111111';
//        $setting->type = 'COLOR';
//        $setting->data = json_encode(['name' => 'simple-footer-bg']);
//        $setting->size = 3;
//        $setting->title =  $part->area_name . ' ' . $part->part .' background';
//        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {

        Setting::where('key',$part->area_name . '_' . $part->part.'_title1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_last')->first()?->delete();
//        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
