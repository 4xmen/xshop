<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SvgList
{
    public static function onAdd(Part $part = null)
    {
        for ($i = 1; $i <= 4; $i++) {


            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.$i.'_svg';
            $setting->value = null;
            $setting->type = 'FILE';
            $setting->size = 12;
            $setting->title =  $part->area_name . ' ' . $part->part.' Image '.$i;
            $setting->save();

            File::copy(__DIR__.'/../../default-assets/html.svg',public_path('upload/images/').$part->area_name  . '.' . $part->part. $i.'.svg');

            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_title'.$i;
            $setting->value = 'Title '.$i;
            $setting->type = 'TEXT';
            $setting->size = 6;
            $setting->title =  $part->area_name . ' ' . $part->part .' title '.$i;

            $setting->save();
            $setting = new Setting();
            $setting->section = 'theme';
            $setting->key = $part->area_name . '_' . $part->part.'_link'.$i;
            $setting->value = '/';
            $setting->type = 'TEXT';
            $setting->size = 6;
            $setting->title =  $part->area_name . ' ' . $part->part .' link '.$i;
            $setting->save();

        }
    }
    public static function onRemove(Part $part = null)
    {
        for ($i = 1; $i <= 4; $i++) {
            Setting::where('key',$part->area_name . '_' . $part->part.'_title'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.'_link'.$i)->first()?->delete();
            Setting::where('key',$part->area_name . '_' . $part->part.$i.'_svg')->first()?->delete();
        }
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
