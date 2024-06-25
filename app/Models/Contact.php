<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'hash';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->hash = generateUniqueID((strlen(Contact::count()) + 2));
        });
    }
}
