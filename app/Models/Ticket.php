<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property string|null $title
 * @property int $customer_id
 * @property string $body
 * @property string|null $answer
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|Ticket[] $subTickets
 * @property-read int|null $sub_tickets_count
 */
class Ticket extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function subTickets(){
        return $this->hasMany(Ticket::class,'parent_id','id')->orderBy('id');
    }
}
