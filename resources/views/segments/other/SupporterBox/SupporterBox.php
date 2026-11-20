<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Setting;

class SupporterBox
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Open now · replies in about 2 min';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = '<h2>Real people in xShop, ready when you are.</h2><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis dolor enim reprehenderit.</p>';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_link1';
        $setting->value = '#';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' link 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title1';
        $setting->value = 'Live chat';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' title 1';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle1';
        $setting->value = '24/7 online chat available';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' subtitle 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_link2';
        $setting->value = '#';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' link 2';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title2';
        $setting->value = 'xshop service';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' title 2';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle2';
        $setting->value = 'maybe address here ;)';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' subtitle 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle3';
        $setting->value = 'tel support subtitle';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' subtitle 3';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_subtitle4';
        $setting->value = 'email support subtitle here';
        $setting->type = 'TEXT';
        $setting->size = 6;
        $setting->title =  $part->area_name . ' ' . $part->part .' subtitle 4';
        $setting->save();

    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_link1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_link2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle3')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle4')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
