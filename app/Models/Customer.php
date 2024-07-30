<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, SoftDeletes,HasApiTokens ;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date'
    ];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function main_tickets(){
        return $this->hasMany(Ticket::class)->whereNull('parent_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'customer_product');
    }
    public function credits(){
        return $this->hasMany(Credit::class);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }


    public function favorites(){
        return $this->belongsToMany(Product::class,'customer_product');
    }

}
