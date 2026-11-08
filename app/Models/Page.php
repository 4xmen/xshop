<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Page extends Model implements HasMedia
{
    use SoftDeletes, HasTranslations, InteractsWithMedia;
    public $translatable = ['title', 'subtitle', 'body'];
    //
    public function children(){
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {

        $optimize = getSetting('optimize');
        if ($optimize == false) {
            $optimize = 'webp';
        }
        $t = explode('x', config('app.media.post_thumb'));

        $t = imageSizeConvertValidate('page_thumb');

        $mc = $this->addMediaConversion('page-image')
            ->width($t[0])
            ->height($t[1])
            ->crop($t[0], $t[1])
            ->optimize()
            ->sharpen(10)
            ->nonQueued()
            ->format($optimize);

        if (getSetting('watermark')) {
            $mc->watermark(public_path('upload/images/logo.png'),
                AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                config('app.media.watermark_opacity'));
        }

    }

    public function imgUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('page-image');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function orgUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl();
        } else {
            return asset('assets/upload/logo.svg');

        }
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function webUrl()
    {
        return fixUrlLang(route('client.page', $this->slug));
    }

    public function webUrlLang($lang)
    {
        $url = route('client.page', $this->slug);
        return str_replace(config('app.url'), config('app.url') . '/' . $lang, $url);
    }


    function markupKeywords()
    {
        return [
            'app.name' => [
                'title' => __("App name"),
                'value' => config('app.name'),
            ],
            'title' => [
                'title' => __("Title"),
                'value' => $this->title,
            ],
            'subtitle' => [
                'title' => __("Subtitle"),
                'value' => $this->subtitle,
            ],
            'created' => [
                'title' => __("created_at"),
                'value' => $this->created_at->tz('UTC')->toAtomString(),
            ],
            'updated' => [
                'title' => __("updated_at"),
                'value' => $this->updated_at->tz('UTC')->toAtomString(),
            ],
            'url' => [
                'title' => __("URL"),
                'value' => $this->webUrl(),
            ],
            'img' => [
                'title' => __("Image"),
                'value' => $this->imgUrl(),
            ],
        ];
    }


    public function markup()
    {
        $keywords = $this->markupKeywords();
        // add markups
        return getValidMarkup($this->markups??'', $keywords) . PHP_EOL ;
    }


}
