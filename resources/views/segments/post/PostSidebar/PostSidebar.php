<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class PostSidebar
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area->name . '_' . $part->part.'_invert';
        $setting->value = 0;
        $setting->size = 12;
        $setting->type = 'CHECKBOX';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area->name . ' ' . $part->part. ' invert sidebar position';
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
