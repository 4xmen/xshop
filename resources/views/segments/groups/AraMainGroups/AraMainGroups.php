<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class AraMainGroups
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area->name . '_' . $part->part.'_title';
        $setting->value = __("Groups");
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area->name . ' ' . $part->part. ' title';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area->name . '_' . $part->part.'_group';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area->name . ' ' . $part->part. ' group';
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area->name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area->name . '_' . $part->part.'_group')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
