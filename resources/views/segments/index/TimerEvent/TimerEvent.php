<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class TimerEvent
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Next event title';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' modern categories title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' next image';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_date';
        $setting->value = strtotime('next friday');
        $setting->type = 'DATETIME';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' next date time';
        $setting->save();

        \File::copy(__DIR__.'/../../default-assets/bg.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_last';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate dignissimos dolores
                        doloribus eaque expedita facilis ipsa itaque maiores minus nam neque, porro ratione sapiente
                        sint unde ut vero voluptatibus voluptatum.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' last content';
        $setting->type = 'EDITOR';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_last')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_date')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
