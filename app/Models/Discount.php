<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Discount extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;

    public $translatable = ['title', 'body'];

    public static $doscount_type =['PRICE','PERCENT'];
    protected $casts  = [
        'expire' => 'datetime'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
