<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
