<?php

namespace Resources\Views\Segments;

use App\Models\Page;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class UnrealFooter
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = 'ipsum dolor sit amet, consectetur adipisicing elit. A aperiam at eum, labore modi sed unde velit veniam voluptate voluptates. Excepturi molestiae mollitia nesciunt possimus. Animi autem beatae';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' main text';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_contact';
        $setting->value = 'ipsum dolor sit amet, consectetur adipisicing elit. A aperiam at eum, labore modi sed unde velit veniam voluptate voluptates. Excepturi molestiae mollitia nesciunt possimus. Animi autem beatae';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' contact text';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_jpg';
        $setting->value = null;
        $setting->type = 'FILE';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part.' Image';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/city.jpg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.jpg');
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_main_title';
        $setting->value = 'Feel free to contact us';
        $setting->size = 6;
        $setting->type = 'TEXT';
        $setting->title =  $part->area_name . ' ' . $part->part. ' Main title';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_main_link';
        $setting->value = '/contact-us';
        $setting->size = 6;
        $setting->type = 'TEXT';
        $setting->title =  $part->area_name . ' ' . $part->part. ' Main title link';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_sub_title';
        $setting->value = 'Benefit posts';
        $setting->size = 6;
        $setting->type = 'TEXT';
        $setting->title =  $part->area_name . ' ' . $part->part. ' sub title';
        $setting->save();
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_pages';
        $setting->value = json_encode(Page::where('status', 1)->inRandomOrder()->limit(5)->pluck('id')->toArray());
        $setting->size = 6;
        $setting->type = 'PAGE_SET';
        $setting->title =  $part->area_name . ' ' . $part->part. ' pages';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_contact')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_main_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_sub_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_main_link')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_pages')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_jpg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
