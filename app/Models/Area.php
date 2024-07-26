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
        'categories_page',
        'category',
        'clip',
        'clips',
        'comments',
        'compare',
        'customer',
        'floats',
        'footer',
        'galleries',
        'gallery',
        'group',
        'groups',
        'groups_page',
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
        'products_page',
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
        return json_decode($this->valid_segments,true);
    }


    public function getRouteKeyName(){
        return 'name';
    }

    public function parts(){
        return $this->hasMany(Part::class);
    }
}
