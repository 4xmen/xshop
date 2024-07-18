<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,SoftDeletes;

    public static $mrohps = [Product::class,Post::class,Group::class,
        Category::class,Clip::class,Gallery::class];
    public function items()
    {
        return $this->hasMany(Item::class)->orderBy('sort');
    }
}
