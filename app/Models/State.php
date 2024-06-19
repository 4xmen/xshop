<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class State extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    public $translatable = ['name', 'country'];

    public function cities(){
        return $this->hasMany(City::class);
    }
}
