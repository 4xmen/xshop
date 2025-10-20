<?php

namespace Resources\Views\Segments;

use App\Models\Part;
use App\Models\Post;

class SimpleComments
{
    public static function onAdd(Part $part = null)
    {

    }
    public static function onRemove(Part $part = null)
    {

    }
    public static function onMount(Part $part = null, $model = null)
    {
        if ($model == null){
            return $part;
        }
        $part->comments = $model->approvedComments()->with('children')->whereNull('parent_id')->orderBy('id','desc')->get();
        $part->commentable_type = get_class($model);
        $part->commentable_id = $model->id;
        return $part;
    }
}
