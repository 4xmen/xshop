<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;


    public static $invoiceStatus = ['PENDING', 'CANCELED', 'FAILED', 'PAID', 'PROCESSING', 'COMPLETED'];

    public function getRouteKey()
    {
        return 'hash';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->hash = generateUniqueID((strlen(Invoice::count()) + 2));
        });
    }
}
