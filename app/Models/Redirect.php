<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    //
    protected $casts  = [
        'expire' => 'date'
    ];
}
