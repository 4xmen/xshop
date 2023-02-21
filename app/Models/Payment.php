<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $invoice_id
 * @property int|null $amount
 * @property string|null $type
 * @property string|null $status
 * @property string $order_id
 * @property string|null $reference_id
 * @property string|null $comment
 * @property string|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Invoice $invoice
 */
class Payment extends Model
{
    use HasFactory;
    //'PENDING','SUCCESS', 'FAIL','CANCEL'
    const PENDING = 'PENDING';
    const SUCCESS = 'SUCCESS';
    const FAIL = 'FAIL';
    const CANCEL = 'CANCEL';

    protected $casts = [
        'meta' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
