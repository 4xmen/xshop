<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SinaTextBg
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquid consequuntur culpa cupiditate dignissimos dolor doloremque error facilis ipsum iure officia quam qui, tempora! Fuga harum impedit iusto magnam veniam.';
        $setting->size = 12;
        $setting->type = 'EDITOR';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' main text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_btn';
        $setting->value = 'Shop';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' button text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_link';
        $setting->value = config('app.url');
        $setting->type = 'TEXT';
        $setting->ltr = true;
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' button link';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/bg-girl.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_btn')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_link')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
