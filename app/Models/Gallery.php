<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Gallery extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,HasTranslations;


    public $translatable = ['title','description'];
    public function images()
    {
        return $this->hasMany(Images::class, 'gallery_id', 'id')->orderBy('sort')->orderByDesc('id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('gallery-image')->optimize();

        $t = explode('x',config('app.media.gallery_thumb'));

        if (config('starter-kit.gallery_thumb') == null || config('starter-kit.gallery_thumb') == ''){
            $t[0] = 500 ;
            $t[1] = 500 ;
        }


        $this->addMediaConversion('gthumb')->width($t[0])
            ->height($t[1])
            ->crop(Manipulations::CROP_CENTER, $t[0], $t[1])->optimize();
//                    ->watermark(public_path('images/logo.png'))->watermarkOpacity(50);
//                    ->withResponsiveImages();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('gthumb');
        } else {
            return "no image";
        }
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
