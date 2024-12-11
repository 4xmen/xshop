<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class CurvePosts
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Lorem ipsum dolor sit amet';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' titles';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group';
        $setting->value = Group::first()->id;
        $setting->type = 'GROUP';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' group';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = gfx()['secondary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'curve-posts-slider-bg']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {

        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'bg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
