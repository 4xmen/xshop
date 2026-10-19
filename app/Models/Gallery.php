<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
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
        return $this->hasMany(Image::class, 'gallery_id', 'id')->orderBy('sort')->orderByDesc('id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('gallery-image')->optimize();

        $t = imageSizeConvertValidate('gallery_thumb');

        $mc = $this->addMediaConversion('gthumb')->width($t[0])
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

//            ->withResponsiveImages();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function imgUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('gthumb');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function attachs(){
        return $this->morphMany(Attachment::class,'attachable');
    }

    public function webUrl(){
        return fixUrlLang(route('client.gallery',$this->slug));
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', 1);
    }



    public function markup()
    {
        $images = '';
        $items = $this->images()->get();
        $count = $items->count();

        foreach ($items as $k => $image) {
            $i = $k + 1;

            $title = json_encode(
                $image->title,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

            $url = json_encode(
                $image->imgUrl(),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

            $images .= <<<IMG
        {
          "@type": "ListItem",
          "position": {$i},
          "item": {
            "@type": "ImageObject",
            "name": {$title},
            "contentUrl": {$url},
            "caption": {$title}
          }
        },
IMG;
        }

        $images = rtrim(trim($images), ',');

        $name = json_encode(
            $this->title,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        $url = json_encode(
            $this->webUrl(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        echo <<<DOC
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": {$name},
  "url": {$url},
  "mainEntity": {
    "@type": "ItemList",
    "numberOfItems": {$count},
    "itemListElement": [
      {$images}
    ]
  }
}
</script>
DOC;
    }
}
