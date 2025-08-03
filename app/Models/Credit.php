<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    const TYPE_CHARGE = 'CHARGE';
    const TYPE_PAYMENT = 'PAYMENT';
    const TYPE_REFUND = 'REFUND';
    const TYPE_ADMIN_ADJUSTMENT = 'ADMIN_ADJUSTMENT';

    const STATUS_PENDING = 'PENDING';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_FAILED = 'FAILED';
    const STATUS_CANCELLED = 'CANCELLED';

    protected $fillable = [
        'customer_id',
        'type',
        'amount',
        'status',
        'payment_id',
        'invoice_id',
        'reference_id',
        'description',
        'data',
        'processed_at'
    ];

    protected $casts = [
        'data' => 'array',
        'processed_at' => 'datetime',
        'amount' => 'int'
    ];

    public static $types = [
        self::TYPE_CHARGE,
        self::TYPE_PAYMENT,
        self::TYPE_REFUND,
        self::TYPE_ADMIN_ADJUSTMENT
    ];

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_COMPLETED,
        self::STATUS_FAILED,
        self::STATUS_CANCELLED
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function isCharge()
    {
        return $this->type === self::TYPE_CHARGE;
    }

    public function isPayment()
    {
        return $this->type === self::TYPE_PAYMENT;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
