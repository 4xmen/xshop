<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Credit
 *
 * @property int $id
 * @property int $amount
 * @property int $customer_id
 * @property int $invoice_id
 * @property string|null $data
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Credit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Credit newQuery()
 * @method static \Illuminate\Database\Query\Builder|Credit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Credit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Credit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Credit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Credit withoutTrashed()
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Invoice $invoice
 * @mixin \Eloquent
 */
class Credit extends Model
{
    use HasFactory,SoftDeletes;

    public function invoice(){
        return $this->belongsTo(Invoice::class);

    }
    public function customer(){
        return $this->belongsTo(Customer::class);

    }
}
