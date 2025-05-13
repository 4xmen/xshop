<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class GridGroup
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = "group set list";
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part;
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_groups';
        $setting->value = json_encode(Group::inRandomOrder()->limit(4)->pluck('id')->toArray());
        $setting->type = 'GROUP_SET';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part;
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_groups')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
