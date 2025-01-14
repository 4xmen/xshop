<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class SimpleUnderConstruction
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate dignissimos dolores
                        doloribus eaque expedita facilis ipsa itaque maiores minus nam neque, porro ratione sapiente
                        sint unde ut vero voluptatibus voluptatum.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' Message';
        $setting->type = 'EDITOR';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
