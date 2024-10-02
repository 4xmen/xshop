<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class GradientTextLink
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_title';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aliquid aspernatur, commodi corporis cupiditate';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title = $part->area_name . ' ' . $part->part . ' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_btn';
        $setting->value = 'Shop';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title = $part->area_name . ' ' . $part->part . ' button text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_link';
        $setting->value = config('app.url');
        $setting->type = 'TEXT';
        $setting->ltr = true;
        $setting->size = 4;
        $setting->title = $part->area_name . ' ' . $part->part . ' button link';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_deg';
        $setting->value = 45;
        $setting->size = 4;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 0, 'xmax' => 360, 'name' => 'gradient-text-link-deg', 'suffix' => 'deg']);
        $setting->title = $part->area_name . ' ' . $part->part . ' degree';
        $setting->save();

    }

    public static function onRemove(Part $part = null)
    {
        Setting::where('key', $part->area_name . '_' . $part->part . '_btn')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_title')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_link')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_deg')->first()?->delete();
    }

    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
