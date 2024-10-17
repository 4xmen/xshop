<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class LoginPatternBg
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color1';
        $setting->value = gfx()['primary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'login-bg-color-1']);
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' second gradiant color 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color2';
        $setting->value = gfx()['secondary'];
        $setting->data = json_encode(['name' => 'login-bg-color-2']);
        $setting->type = 'COLOR';
        $setting->size = 6;

        $setting->title =  $part->area_name . ' ' . $part->part .' second gradiant color 2';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_png';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' background pattern image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/pattern.png',public_path('upload/images/').$part->area_name . '.' . $part->part.'.png');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_png')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color2')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
