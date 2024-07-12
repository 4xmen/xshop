<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class PreloaderImage
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->key = 'PreloaderImage_gif';
        $setting->title = '';
        $setting->type = 'FILE';
        $setting->section = 'Theme';
        $setting->save();
        File::copy(__DIR__.'/assets/PreloaderImage.gif',public_path('upload/images/').'PreloaderImage.gif');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key','PreloaderImage_gif')->delete();
        File::delete(public_path('upload/images/').'PreloaderImage.gif');
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
