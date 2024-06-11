<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Group extends Model
{
    use HasFactory, SoftDeletes,HasTranslations;

    public $translatable = ['name','subtitle','description'];
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    //
    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Group::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function imgUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('groups/' . $this->image);
    }

    public function bgUrl()
    {
        if ($this->bg == null) {
            return null;
        }

        return \Storage::url('groups/' . $this->bg);
    }
}
