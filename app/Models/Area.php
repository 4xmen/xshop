<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
//    use HasFactory;
    public static $allSegments = [
        'ads',
        'attachment',
        'attachments',
        'attachments_page',
        'card',
        'categories',
//        'categories_page',
        'category',
        'comments',
        'contact',
        'clip',
        'clips',
        'clips_page',
        'comments',
        'compare',
        'customer',
        'floats',
        'footer',
        'galleries',
        'galleries_page',
        'gallery',
        'group',
        'groups',
//        'groups_page',
        'header',
        'index',
        'invoice',
        'login',
        'menu',
        'other',
        'parallax',
        'post',
        'posts',
        'posts_page',
        'preloader',
        'product',
        'products',
        'product_grid',
        'products_page',
        'register',
        'questions',
        'search',
        'slider',
        'top',
    ];

    protected $casts = [
        'segments',
    ];

    public function getSegmentAttribute()
    {
        return json_decode($this->valid_segments, true);
    }


    public function getRouteKeyName()
    {
        return 'name';
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function defPart()
    {
        $p = $this->parts()->first();
        return 'segments.' . $p->segment . '.' . $p->part . '.' . $p->part;
    }
}
