<?php

namespace Resources\Views\Segments;

use App\Models\Menu;
use App\Models\Part;
use App\Models\Setting;

class SideMenu
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_menu';
        $setting->value = Menu::first()->id;
        $setting->type = 'MENU';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' menu';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_text';
        $setting->value = 'lorem ipsum';
        $setting->type = 'EDITOR';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part .' text';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#ececec';
        $setting->type = 'COLOR';
        $setting->size = 3;
        $setting->data = json_encode(['name' => 'side-menu-bg-color']);
        $setting->title =  $part->area_name . ' ' . $part->part .' background';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_menu')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_text')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
