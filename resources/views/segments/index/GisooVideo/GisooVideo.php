<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class GisooVideo
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_mp4';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title = $part->area_name . ' ' . $part->part . ' video';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_deg';
        $setting->value = 35;
        $setting->size = 6;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => -180, 'xmax' => 180, 'name' => 'gisso-deg-1', 'suffix' => 'deg']);
        $setting->title = $part->area_name . ' ' . $part->part . ' angle 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_deg2';
        $setting->value = 35;
        $setting->size = 6;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => -180, 'xmax' => 180, 'name' => 'gisso-deg-2', 'suffix' => 'deg']);
        $setting->title = $part->area_name . ' ' . $part->part . ' angle 2';
        $setting->save();
    }

    public static function onRemove(Part $part = null)
    {
        Setting::where('key', $part->area_name . '_' . $part->part . '_mp4')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_deg')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_deg2')->first()?->delete();

    }

    public static function onMount(Part $part = null)
    {

        return $part;
    }
}
