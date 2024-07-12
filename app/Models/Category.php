<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations,SoftDeletes;

    public $translatable = ['name', 'subtitle', 'description'];

    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('categories/optimized-' . $this->image);
    }
    public function imgOriginalUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('categories/' . $this->image);
    }

    public function bgUrl()
    {
        if ($this->bg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('categories/optimized-' . $this->bg);
    }
    public function bgOriginalUrl()
    {
        if ($this->bg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('categories/' . $this->bg);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function props(){
        return $this->belongsToMany(Prop::class);
    }

    public function attachs(){
        return $this->morphMany(Attachment::class,'attachable');
    }

    public function webUrl(){
        return  '#';// WIP
        return route('');
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

}
