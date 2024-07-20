<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class NoLinkImage
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area->name . '_' . $part->part.'_group';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area->name . ' ' . $part->part. ' group';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area->name . '_' . $part->part.'_dark';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'CHECKBOX';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area->name . ' ' . $part->part. ' dark mode';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
