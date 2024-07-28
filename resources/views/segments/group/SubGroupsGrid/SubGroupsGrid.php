<?php

namespace Resources\Views\Segments;

use App\Models\Part;

class SubGroupsGrid
{
    public static function onAdd(Part $part = null)
    {

    }
    public static function onRemove(Part $part = null)
    {

    }
    public static function onMount(Part $part = null)
    {
        return $part;
    }
}
