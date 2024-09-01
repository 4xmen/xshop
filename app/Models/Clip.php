<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Clip extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, HasTags;

    public $translatable = ['title', 'body'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function imgUrl()
    {
        if ($this->cover == null) {
            return asset('assets/upload/logo.svg');
        }

        return \Storage::url('cover/optimized-' . $this->cover);
    }

    public function imgOriginalUrl()
    {
        if ($this->cover == null) {
            return asset('assets/upload/logo.svg');;
        }

        return \Storage::url('clips/' . $this->cover);
    }

    public function fileUrl()
    {
        if ($this->file == null) {
            return null;
        }

        return \Storage::url('clips/' . $this->file);
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function webUrl()
    {
        return fixUrlLang(route('client.clip', $this->slug));
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

        $app = config('app.name');
        $logo = asset('upload/images/logo.png');
        $desc = str_replace('"', '', strip_tags($this->body));
        $count = $this->comments()->count();
        return <<<RESULT

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoObject",
  "name": "{$this->title}",
  "description": "{$desc}",
  "thumbnailUrl": "{$this->imgUrl()}",
  "uploadDate": "{$this->updated_at}",
  "contentUrl": "{$this->fileUrl()}",
  "embedUrl": "{$this->webUrl()}",
  "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": "http://schema.org/PlayAction",
    "userInteractionCount": {$count}
  },
  "publisher": {
    "@type": "Organization",
    "name": "$app",
    "logo": {
      "@type": "ImageObject",
      "url": "$logo"
    }
  }
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

}
