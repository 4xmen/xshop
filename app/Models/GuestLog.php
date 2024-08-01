<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestLog extends Model
{
    use HasFactory;

    public static $actions = ['login','register','search','sms'];
}
