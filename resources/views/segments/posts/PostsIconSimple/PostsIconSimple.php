<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class PostsIconSimple
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part;
        $setting->value = Group::first()->id;
        $setting->type = 'GROUP';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part;
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_limit';
        $setting->value = 3;
        $setting->size = 6;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 2, 'xmax' => 12]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' limit';
        $setting->save();
    }

    public static function onRemove(Part $part = null)
    {
//        \Log::info(' --- onRemove rem --- '.$part->area_name . '_' . $part->part);

//        dd(Setting::where('key',$part->area_name . '_' . $part->part)->get());
        Setting::where('key',$part->area_name . '_' . $part->part)->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_limit')->first()?->delete();
    }

    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
