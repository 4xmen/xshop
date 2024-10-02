<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class LianaInvoice
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_desc';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid consequuntur culpa cupiditate dignissimos dolor doloremque error facilis ipsum iure officia quam qui, tempora! Fuga harum impedit iusto magnam veniam.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' invoice footer description';
        $setting->type = 'EDITOR';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_desc')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
