<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class AuthorSlider
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Lorem ipsum dolor sit amet';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group';
        $setting->save();



        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = gfx()['secondary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'author-slider-color']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color2';
        $setting->value = gfx()['primary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'author-slider-color2']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .'content background color';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
