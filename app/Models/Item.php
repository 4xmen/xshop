<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['title'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }


    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Item::class, 'parent');
    }

    public function dest(){
        return $this->morphTo('menuable','menuable_type','menuable_id');
    }

    public function webUrl(){
        if ($this->kind == 'direct'){

            if ( config('app.xlang.active') && app()->getLocale() != config('app.xlang.main')){
                if ($this->meta[0] != '/'){

                    $welcome = \route('client.welcome');
                    return str_replace($welcome,$welcome .'/'.app()->getLocale(),$this->meta);
                }else{
                    return  '/'.app()->getLocale() . $this->meta;
                }
            }
            return $this->meta;
        }else{
            return $this->dest->webUrl();
        }
    }
}
