<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class MainCategoriesIcon
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'cat-icon-bg']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_box';
        $setting->value = gfx()['primary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'cat-icon-box']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' box color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = '#ffffff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'cat-icon-text']);
        $setting->size =4;
        $setting->title =  $part->area_name . ' ' . $part->part .' text color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Lorem ipsum dolor sit amet';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' titles';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_limit';
        $setting->value = '4';
        $setting->size = 6;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 4, 'xmax' => 12]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' limit';
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_limit')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_box')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
