<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
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

        $t = imageSizeConvertValidate('gallery_thumb');

        $this->addMediaConversion('image-image')->optimize();

        $mc = $this->addMediaConversion('githumb')
            ->width($t[0])
            ->height($t[1])
            ->nonQueued()
            ->crop( $t[0], $t[1])
            ->optimize()
            ->format(getSetting('optimize'));

        if (getSetting('watermark')){
            $mc->watermark(public_path('upload/images/logo.png'),
                    AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                    config('app.media.watermark_opacity'));
        }
//                    ->watermark(public_path('images/logo.png'))->watermarkOpacity(50);
//                    ->withResponsiveImages();
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('githumb');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }
    public function imgOriginalUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl();
        } else {
            return asset('assets/upload/logo.svg');
        }
    }
}
