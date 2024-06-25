<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
//    use HasFactory;
    public static  $ticket_statuses = [['PENDING','ANSWERED','CLOSED']];


    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function subTickets(){
        return $this->hasMany(Ticket::class,'parent_id','id')->orderBy('id');
    }
}
