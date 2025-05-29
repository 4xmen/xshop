<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class ContactSummery
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/bg.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'contact us';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle';
        $setting->value = '<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis dolor enim reprehenderit.</p>';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' subtitle';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_btn';
        $setting->value = 'Products';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' button text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_link';
        $setting->value = '/';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' button link';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_address';
        $setting->value = 'no.1, Pine st, Apple sq, TX , USA';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' address text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_address_link';
        $setting->value = '/';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' address link';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_btn')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_link')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_address')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_address_link')->first()?->delete();
        File::delete(public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
