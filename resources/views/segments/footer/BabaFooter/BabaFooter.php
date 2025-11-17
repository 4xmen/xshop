<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class BabaFooter
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_images';
        $setting->value = '
            <ul>
                <li><img src="'.asset('assets/upload/logo.svg').'" class="logo" alt="[logo]"></li>
                <li><img src="'.asset('assets/upload/logo.svg').'" class="logo" alt="[logo]"></li>
            </ul>';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' images';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = 'ipsum dolor sit amet, consectetur adipisicing elit. A aperiam at eum, labore modi sed unde velit veniam voluptate voluptates. Excepturi molestiae mollitia nesciunt possimus. Animi autem beatae';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' tex';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title1';
        $setting->value = 'FAQ';
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group1';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group 1';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title2';
        $setting->value = 'About us';
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title 2';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group2';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group 2';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title3';
        $setting->value = 'Other';
        $setting->size = 6;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title 3';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group3';
        $setting->value = Group::first()->id;
        $setting->size = 6;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group3';
        $setting->save();


    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_images')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();

        Setting::where('key',$part->area_name . '_' . $part->part.'_title1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title3')->first()?->delete();

        Setting::where('key',$part->area_name . '_' . $part->part.'_group1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group3')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
