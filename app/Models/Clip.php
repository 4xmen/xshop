<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Clip extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['title','body'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function coverUrl()
    {
        if ($this->cover == null) {
            return null;
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
}
