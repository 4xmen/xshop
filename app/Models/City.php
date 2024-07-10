<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations,SoftDeletes;

    public $translatable = ['name'];

    public function state(){
        return $this->belongsTo(State::class);
    }
}
