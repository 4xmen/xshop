<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Part;
use App\Models\Setting;

class TreeGridProducts
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = 'Favorite products';
        $setting->type = 'TEXT';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' main title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = '#273763';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'three-main-bg-color']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' main color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_category';
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' main category';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_badgex';
        $setting->value = '22%';
        $setting->type = 'TEXT';
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' Second badge text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_gradx1';
        $setting->value = '#FF7D33';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'three-main-bg-gx1']);
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' second gradiant color 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_gradx2';
        $setting->value = '#FF971D';
        $setting->data = json_encode(['name' => 'three-main-bg-gx2']);
        $setting->type = 'COLOR';
        $setting->size = 3;

        $setting->title =  $part->area_name . ' ' . $part->part .' second gradiant color 2';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_categoryx';
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' second category';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_badgey';
        $setting->value = 'Sale';
        $setting->type = 'TEXT';
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' third badge text';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_grady1';
        $setting->value = '#3368ff';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'three-main-bg-gy1']);
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' third gradiant color 1';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_grady2';
        $setting->value = '#430392';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'three-main-bg-gy2']);
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' third gradiant color 2';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_categoryy';
        $setting->value = Category::first()->id;
        $setting->type = 'CATEGORY';
        $setting->size = 3;
        $setting->title =  $part->area_name . ' ' . $part->part .' third category';
        $setting->save();
    }
    public static function onRemove(Part $part = null)
    {
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_category')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_badgex')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_gradx1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_gradx2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_categoryx')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_badgey')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_grady1')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_grady2')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_categoryy')->first()?->delete();
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
