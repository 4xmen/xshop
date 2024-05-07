<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public static $types = ['ONLINE', 'CHEQUE', 'CASH', 'CARD', 'CASH_ON_DELIVERY'];
    public static $status = ['PENDING','SUCCESS', 'FAIL','CANCEL'];
}
