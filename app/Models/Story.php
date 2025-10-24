<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Story extends Model
{
    //
    use HasTranslations, SoftDeletes;

    public $translatable = ['title'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('optimized/stories/' . $this->image. '.webp');
    }

    public function imgOriginalUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('stories/' . $this->image);
    }

    public function url()
    {
        if ($this->file == null) {
            return asset('/assets/upload/logo.svg');
        }
        // For S3 files - match Img model implementation
        return Storage::disk(config('filesystems.default'))->url($this->file);
    }

    public function commentCount(){
        return 15;
    }

}
