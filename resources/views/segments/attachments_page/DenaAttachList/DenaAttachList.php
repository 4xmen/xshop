<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class DenaAttachList
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area->name . '_' . $part->part.'_title';
        $setting->value = __("Website attachments list");
        $setting->type = 'text';
        $setting->size = 6;
        $setting->title =  $part->area->name . ' ' . $part->part;
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area->name . '_' . $part->part.'_title')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
