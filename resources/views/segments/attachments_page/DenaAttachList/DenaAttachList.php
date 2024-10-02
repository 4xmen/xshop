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
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = __("Website attachments list").' [ pdf, docx, zip, png, jpg, svg, mp4, rar, mp3 ]';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part;
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
