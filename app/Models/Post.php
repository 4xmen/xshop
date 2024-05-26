<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Post extends Model  implements HasMedia
{
    use HasFactory,SoftDeletes, InteractsWithMedia,HasTranslations;
    public $translatable = ['title','subtitle','body'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $t = explode('x',config('app.media.post_thumb'));

        if (config('app.media.post_thumb') == null || config('app.media.post_thumb') == ''){
            $t[0] = 500 ;
            $t[1] = 500 ;
        }


        $this->addMediaConversion('posts-image')
            ->width($t[0])
            ->height($t[1])
            ->crop(Manipulations::CROP_CENTER, $t[0], $t[1])
            ->optimize()
            ->sharpen(10);
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('posts-image');
        } else {
            return "no image";
        }
    }

    public function orgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl();
        } else {
            return asset('/images/logo.png');

        }
    }


    public function spendTime()
    {
        $word = strlen(strip_tags($this->body));
        $m = ceil($word / 1350);

        return $m . ' ' . __('minute');
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approved_comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', 1);
    }

//    public function toArray()
//    {
//        return [
//            'id' => $this->id,
//            'title' => $this->title,
//            'subtitle' => $this->subtitle,
//            'body' => $this->body,
//            'categories' => $this->categories->implode(' ') ?? null,
//            'author' => $this->author->name ?? null,
//            'tags' => $this->tags->implode(' ') ?? null,
//        ];
//    }
}
