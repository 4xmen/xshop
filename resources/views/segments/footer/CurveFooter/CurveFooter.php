<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class CurveFooter
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = gfx()['secondary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'curve-footer-bg']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = getGrayscaleTextColor(gfx()['secondary']) ?? '#6e0000';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'curve-footer-color']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' text color';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid consequuntur culpa cupiditate dignissimos dolor doloremque error facilis ipsum iure officia quam qui, tempora! Fuga harum impedit iusto magnam veniam.';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part. ' content';
        $setting->type = 'EDITOR';
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
