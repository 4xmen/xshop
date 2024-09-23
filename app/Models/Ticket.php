<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
//    use HasFactory;
    public static  $ticket_statuses = ['PENDING','ANSWERED','CLOSED'];


    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }



    public function subTickets(){
        return $this->hasMany(Ticket::class,'parent_id','id')->orderBy('id');
    }


    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Ticket::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Ticket::class)
                ->where('evaluationable_id',$this->id);
        })->get();
    }
}
