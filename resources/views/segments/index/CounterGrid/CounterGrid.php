<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Database\Factories\PostFactory;

class CounterGrid
{


    public static  $count = 4;
    public static function onAdd(Part $part = null)
    {
        $icon = PostFactory::$icons;


        for ($i = 1; $i <= self::$count; $i++) {
            shuffle($icon);

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_title'.$i;
            $setting->value =  "Counter ".$i;
            $setting->size = 4;
            $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
            $setting->title =  $part->area_name . ' ' . $part->part. ' title '.$i;
            $setting->save();

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_icon'.$i;
            $setting->value = $icon[0];
            $setting->size = 4;
            $setting->type = 'ICON';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 6]);
            $setting->title =  $part->area_name . ' ' . $part->part. ' icon '.$i;
            $setting->save();

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_number'.$i;
            $setting->value = rand(100,4000);
            $setting->size = 4;
            $setting->type = 'NUMBER';
            $setting->data = json_encode(['xmin' => 0, 'xmax' => 9007199254740992]);
            $setting->title =  $part->area_name . ' ' . $part->part. ' number '.$i;
            $setting->save();
        }
    }
    public static function onRemove(Part $part = null)
    {
        for ($i = 1; $i <= self::$count; $i++) {

            Setting::where('key',$part->area_name . '_' . $part->part.'_title'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.'_icon'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.'_number'.$i)->first()?->delete();

        }
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
