<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['body'];

    public function imgUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('sliders/' . $this->image);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
