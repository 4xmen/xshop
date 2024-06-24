<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Attachment extends Model
{
    use HasFactory,HasTranslations;

    public static $mrohps = [Product::class,Post::class,Group::class,
        Category::class,Clip::class,Gallery::class];

    public $translatable = ['title','subtitle','body'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function url()
    {
        if ($this->file == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('attachments/' . $this->file);
    }

    public function tempUrl() // WIP
    {
        if ($this->file == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('attachments/' . $this->file);
    }
}
