<?php

namespace Resources\Views\Segments;

use App\Models\Menu;
use App\Models\Part;
use App\Models\Setting;

class RecetMenu
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_menu';
        $setting->value = Menu::first()->id;
        $setting->type = 'MENU';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' menu';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_menu')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
