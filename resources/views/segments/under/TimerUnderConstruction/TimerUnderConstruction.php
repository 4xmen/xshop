<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class TimerUnderConstruction
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_date';
        $setting->value = strtotime('next friday');
        $setting->type = 'DATETIME';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' up time';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
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

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
