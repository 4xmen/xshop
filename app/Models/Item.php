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
        return $this->belongsTo(MenuItem::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent');
    }
}
