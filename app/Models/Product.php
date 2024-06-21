<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Metable\Metable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations, HasTags, Metable;

    public static $stock_status = ['IN_STOCK', 'OUT_STOCK', 'BACK_ORDER'];

    public $translatable = ['name', 'excerpt', 'description','table'];

    public function registerMediaConversions(?Media $media = null): void
    {
        $ti = explode('x', config('app.media.product_image'));

        if (config('app.media.product_image') == null || config('app.media.product_image') == '') {
            $ti[0] = 1200;
            $ti[1] = 1200;
        }
        $t = explode('x', config('app.media.product_thumb'));

        if (config('app.media.product_thumb') == null || config('app.media.product_thumb') == '') {
            $t[0] = 500;
            $t[1] = 500;
        }

        $this->addMediaConversion('product-thumb')
            ->width($t[0])
            ->height($t[1])
            ->crop($t[0], $t[1])
            ->optimize()
            ->sharpen(10)
            ->nonQueued()
            ->format('webp');

        $this->addMediaConversion('product-image')
            ->width($ti[0])
            ->height($ti[1])
            ->crop($ti[0], $ti[1])
            ->optimize()
            ->sharpen(10)
            ->nonQueued()
            ->format('webp');

    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', 1)->whereNull('sub_comment_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class, 'product_id');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_id', 'id');
    }

    public function activeDiscounts()
    {
        return $this->hasMany(Discount::class, 'product_id', 'id')->where(function ($query) {
            $query->where('expire', '>=', date('Y-m-d'))
                ->orWhereNull('expire');
        });
    }

    public function quesions()
    {
        return $this->hasMany(Question::class);
    }

    function hasDiscount()
    {
        return $this->discounts()->where('expire', '>', date('Y-m-d'))->count() > 0;
    }

    public function isFav()
    {
        if (auth('customer')->check()) {
            return \auth('customer')->user()->products()->where('product_id', $this->id)->exists();
        } else {
            return false;
        }
    }

    public function imgUrl(){
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl();
        } else {
            return asset('assets/upload/logo.svg');
        }
    }
    public function imgUrl2(){
        if ($this->getMedia()->count() > 0 && isset($this->getMedia()[1])) {
            return $this->getMedia()[1]->getUrl();
        } else {
            return asset('assets/upload/logo.svg');
        }
    }
    public function thumbUrl(){
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl('product-thumb');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }
    public function thumbUrl2(){
        if ($this->getMedia()->count() > 0 && isset($this->getMedia()[1])) {
            return $this->getMedia()[1]->getUrl('product-thumb');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }


}
