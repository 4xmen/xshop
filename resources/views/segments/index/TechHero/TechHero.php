<?php

namespace Resources\Views\Segments;

use App\Models\Category;
use App\Models\Page;
use App\Models\Part;
use App\Models\Setting;

class TechHero
{
    public static function onAdd(Part $part = null)
    {
        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_categories';
        $setting->value = json_encode(Category::inRandomOrder()->limit(2)->pluck('id')->toArray());
        $setting->type = 'CATEGORY_SET';
        $setting->size = 12;
        $setting->title =  $part->area_name . ' ' . $part->part;
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
        Setting::where('key',$part->area_name . '_' . $part->part.'_categories')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_pages')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
