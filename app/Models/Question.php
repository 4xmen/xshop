<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
//    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
