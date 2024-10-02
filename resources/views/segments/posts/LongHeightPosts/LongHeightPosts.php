<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class LongHeightPosts
{
    public static function onAdd(Part $part = null)
    {
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
        $setting->key = $part->area_name . '_' . $part->part.'_btn';
        $setting->value = __("Find more");
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' button text';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/bg-girl.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_group')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_btn')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
