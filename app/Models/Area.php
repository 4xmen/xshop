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
        'attachmentsList',
        'card',
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
        'index',
        'invoice',
        'login',
        'menu',
        'parallax',
        'preloader',
        'product',
        'products',
        'questions',
        'search',
        'search',
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
