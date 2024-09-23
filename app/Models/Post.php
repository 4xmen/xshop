<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations, HasTags;

    public $translatable = ['title', 'subtitle', 'body'];


    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function registerMediaConversions(?Media $media = null): void
    {

        $optimize = getSetting('optimize');
        if ($optimize == false) {
            $optimize = 'webp';
        }
        $t = explode('x', config('app.media.post_thumb'));

        $t = imageSizeConvertValidate('post_thumb');

        $mc = $this->addMediaConversion('post-image')
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
            return $this->getMedia()->first()->getUrl('post-image');
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


    public function spendTime()
    {
        $word = strlen(strip_tags($this->body));
        $m = ceil($word / 1350);

        return $m . ' ' . __('minute(s)');
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function mainGroup()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
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

    public function webUrl()
    {
        return fixUrlLang(route('client.post', $this->slug));
    }


    public function markup()
    {
        $type = 'BlogPosting';
        if (strpos(strtolower(implode(',', $this->groups()->pluck('name')->toArray())), __('article')) !== false) {
            $type = 'Article';
        }
        if (strpos(strtolower(implode(',', $this->groups()->pluck('name')->toArray())), __('news')) !== false) {
            $type = 'NewsArticle';
        }

        $app = config('app.name');
        $logo = asset('upload/images/logo.png');
        $author = $this->author->name ?? $app;
        return <<<RESULT
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "$type",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{$this->webUrl()}"
  },
  "headline": "{$this->title}",
  "description": "{$this->subtitle}",
  "image": "{$this->imgUrl()}",
  "author": {
    "@type": "Person",
    "name": "$author"
  },
  "publisher": {
    "@type": "Organization",
    "name": "$app",
    "logo": {
      "@type": "ImageObject",
      "url": "$logo"
    }
  },
   "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": "http://schema.org/PlayAction",
    "userInteractionCount": {$this->view}
  },
  "datePublished": "{$this->created_at}",
  "dateModified": "{$this->updated_at}"
}
</script>
RESULT;

    }

    public function tagsList()
    {
        if ($this->tags()->count() == 0) {
            return getSetting('keyword');
        } else {
            return implode(',', $this->tags()->pluck('name')->toArray());
        }
    }

    public function tableOfContents(){
        list($toc, $modifiedHtml) = generateTOC($this->body);
        return $toc;
    }

    public function bodyContent(){
        list($toc, $modifiedHtml) = generateTOC($this->body);
        return $modifiedHtml;
    }


    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Post::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Post::class)
                ->where('evaluationable_id',$this->id);
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Group::class)
                ->where('evaluationable_id',$this->group_id);
        })->get();
    }
}
