<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Prop extends Model
{

    use HasFactory, HasTranslations, SoftDeletes;

    public $translatable = ['label', 'unit'];

    protected $casts = [
        'dataz',
        'optionz',
        'datas'
    ];

    public static $prop_types = ['text', 'number', 'checkbox', 'color', 'select', 'multi', 'singlemulti', 'date', 'time'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getDatazAttribute()
    {
        $result = [];
        foreach (json_decode($this->options) as $item) {
            $result[$item->title] = $item->value;
        }

        return $result;
    }

    public function getDatasAttribute()
    {
        $result = [];
        foreach (json_decode($this->options) as $item) {
            $result[$item->value] = $item->title;
        }

        return $result;
    }

    public function getOptionzAttribute()
    {
        return json_decode($this->options);
    }
}
