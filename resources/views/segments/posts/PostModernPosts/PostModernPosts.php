<?php

namespace Resources\Views\Segments;

use App\Models\Group;
use App\Models\Part;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class PostModernPosts
{
    public static function onAdd(Part $part = null)
    {

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_title';
        $setting->value = __("Hello world");
        $setting->size = 12;
        $setting->type = 'TEXT';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' title';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_group';
        $setting->value = Group::first()->id;
        $setting->size = 4;
        $setting->type = 'GROUP';
//        $setting->data = json_encode(['xmin' => 2, 'xmax' => 90]);
        $setting->title =  $part->area_name . ' ' . $part->part. ' group';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_bg';
        $setting->value = '#eeeeee';
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'post-modern-bg']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' background color';
        $setting->save();

        $setting = new Setting();
        $setting->section = 'theme';
        $setting->key = $part->area_name . '_' . $part->part.'_color';
        $setting->value = gfx()['secondary'];
        $setting->type = 'COLOR';
        $setting->data = json_encode(['name' => 'post-modern-color']);
        $setting->size = 4;
        $setting->title =  $part->area_name . ' ' . $part->part .' text color';
        $setting->save();

        File::copy(__DIR__.'/../../default-assets/mask-post-modern.svg',public_path('upload/images/').$part->area_name . '.' . $part->part.'.svg');
    }
    public static function onRemove(Part $part = null)
    {

        Setting::where('key',$part->area_name . '_' . $part->part.'_group')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_title')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_bg')->first()?->delete();
        Setting::where('key',$part->area_name . '_' . $part->part.'_color')->first()?->delete();

    }
    public static function onMount(Part $part = null)
    {
        $data = file_get_contents(public_path('upload/images/').$part->area_name . '.' . $part->part.'.svg');
        $re = '/style\=\"fill\:(.*)\;stroke\-width\:0/m';
        $data = preg_replace($re, 'style="fill:'.getSetting($part->area_name.'_'.$part->part.'_bg').';stroke-width:0',$data);
        file_put_contents(public_path('upload/images/').$part->area_name . '.' . $part->part.'.svg',$data);
        return $part;
    }
}
