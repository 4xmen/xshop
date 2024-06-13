<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Image extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia, HasTranslations;
    public $translatable = ['title'];

    protected $guarded = [''];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $t = explode('x', config('starter-kit.post_thumb'));
        if (config('starter-kit.gallery_thumb') == null || config('starter-kit.gallery_thumb') == '') {
            $t[0] = 500;
            $t[1] = 500;
        }

        $this->addMediaConversion('image-image')->optimize();

        $this->addMediaConversion('gthumb')->width($t[0])
            ->height($t[1])
            ->nonQueued()
            ->crop( $t[0], $t[1])->optimize();
//                    ->watermark(public_path('images/logo.png'))->watermarkOpacity(50);
//                    ->withResponsiveImages();
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('gthumb');
        } else {
            return "no image";
        }
    }
}
