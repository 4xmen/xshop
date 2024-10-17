<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class VickushkaMainCategoriesSlider
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'categories here';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' sub title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#ebfebe';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'vicka-bg-color']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' main color';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
