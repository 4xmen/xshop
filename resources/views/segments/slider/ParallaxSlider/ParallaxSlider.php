<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Slider;

class ParallaxSlider
{
    public static function onAdd(Part $part = null)
    {
        Slider::addData($part->area_name . '_' . $part->part . '_btn','View offer');
        Slider::addData($part->area_name . '_' . $part->part . '_link','/');
        Slider::addData($part->area_name . '_' . $part->part . '_subtitle','Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci aliquid aspernatur, commodi corporis cupiditate');
    }
    public static function onRemove(Part $part = null)
    {
        Slider::remData($part->area_name . '_' . $part->part . '_btn');
        Slider::remData($part->area_name . '_' . $part->part . '_link');
        Slider::remData($part->area_name . '_' . $part->part . '_subtitle');
    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
