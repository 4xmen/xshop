<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;

class GradientGroupGrid
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_title';
        $setting->value = 'Lorem ipsum';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title = $part->area_name . ' ' . $part->part . ' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_subtitle';
        $setting->value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aliquid aspernatur, commodi corporis cupiditate';
        $setting->type = 'TEXT';
        $setting->size = 12;
        $setting->title = $part->area_name . ' ' . $part->part . ' sub title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group';
        $setting->value = Group::first()->id;
        $setting->type = 'GROUP';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' group';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_btn';
        $setting->value = __('Read more');
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title = $part->area_name . ' ' . $part->part . ' button text';
        $setting->save();



        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color2';
        $setting->value = '#3368ff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'gradient-group-color2']);
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' third gradiant color 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color1';
        $setting->value = '#430392';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'gradient-group-color1']);
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' third gradiant color 2';
        $setting->save();


        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part . '_deg';
        $setting->value = 45;
        $setting->size = 4;
        $setting->type = 'NUMBER';
        $setting->data = json_encode(['xmin' => 0, 'xmax' => 360, 'name' => 'gradient-group-deg', 'suffix' => 'deg']);
        $setting->title = $part->area_name . ' ' . $part->part . ' degree';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {

        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_subtitle')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_group')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_title')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_btn')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_color1')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_color2')->first()?->delete();
        Setting::where('key', $part->area_name . '_' . $part->part . '_deg')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
