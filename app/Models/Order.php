<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function quantity(){
        return $this->belongsTo(Quantity::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
