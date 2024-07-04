<?php

namespace Resources\Views\Segments;

use App\Models\Part;

class PreloaderCircle
{
    public static function onAdd(Part $part = null)
    {
        \Log::info('added '.$part->part.' on '.$part->segment);
    }
    public static function onRemove(Part $part = null)
    {
        \Log::info('remove '.$part->part.' on '.$part->segment);
    }
    public static function onMount(Part $part = null)
    {
        \Log::info('monted '.$part->part.' on '.$part->segment);
    }
}
