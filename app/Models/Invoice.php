<?php

namespace App\Models;

use App\Events\InvoiceFailed;
use App\Events\InvoiceSucceed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;

    const PENDING = 'PENDING';
    const PROCESSING = 'PROCESSING';
    const COMPLETED = 'COMPLETED';
    const CANCELED = 'CANCELED';
    const FAILED = 'FAILED';

    protected $casts = [
        'meta' => 'array',
    ];

    public static $invoiceStatus = ['PENDING', 'CANCELED', 'FAILED', 'PAID', 'PROCESSING', 'COMPLETED'];

    public function getRouteKeyName()
    {
        return 'hash';
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function successPayments()
    {
        return $this->hasMany(Payment::class)->where('status', 'COMPLETED');
    }

    public function payByBankUrl($gateway)
    {
        return route('redirect.bank', ['invoice' => $this->id, 'gateway' => $gateway]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_product')
            ->withPivot(
                'count',
                'price_total',
                'data',
                'quantity_id'
            );
    }


    public function isCompleted()
    {
        return $this->status == 'COMPLETED' or $this->status == 'PROCESSING';
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->hash = generateUniqueID((strlen(Invoice::count()) + 2));
        });
    }

    public function storePaymentRequest($orderId,$amount, $token = null, $type = 'ONLINE', $bank = null): \App\Models\Payment
    {
        $payment = new Payment();
        $payment->order_id = $orderId;
        $payment->type = $type?$type:'ONLINE';
        $payment->amount=$amount;
        $payment->meta = [
            'fingerprint' => \Request::fingerprint(),
            'bank'        => $bank,
            'token'       => $token,
            'ip'          => \Request::ip(),
            'auth_user'   => \Auth::id(),
            'user_agent'  => \Request::userAgent(),
        ];
        /** @var \App\Models\Invoice $this */
        $this->payments()->save($payment);

//        $payment->save();

        return $payment;
    }

    public function storeSuccessPayment($paymentId, $referenceId, $cardNumber = null): \App\Models\Payment
    {
        /** @var Payment $payment */
        $payment = Payment::findOrFail($paymentId);
        $payment->reference_id = $referenceId;
        $payment->meta = array_merge($payment->meta, ['card_number' => $cardNumber]);
        $payment->status = "SUCCESS";
        $payment->save();
        /** @var \App\Models\Invoice $this */
        $this->status = "PAID";
        $this->save();
        if (config('app.sms.driver') == 'Kavenegar'){
            $args = [
                'receptor' => $this->customer->mobile,
                'template' => trim(getSetting('order')),
                'token10' => $this->customer->name,
                'token' => $this->hash,
                'token2' => number_format($this->total_price)
            ];
        }else{
            $args = array_merge($this->toArray(),$this->customer->toArray());
        }

        sendingSMS(getSetting('order'),$this->customer->mobile,$args);

        try {
            event(new InvoiceSucceed($this, $payment));
        }catch (\Throwable $exception){
            \Log::debug('Error In Event OrderSucceed. But Process Continued!',compact('payment'));
            \Log::warning($exception->getMessage(),[$exception->getTraceAsString()]);
        }

        return $payment;
    }

    public function storeFailPayment($paymentId, $message = null): \App\Models\Payment
    {
        try {
            /** @var Payment $payment */
            $payment = Payment::findOrFail($paymentId);
            if ($payment->status === Payment::SUCCESS) {
                return $payment;
            }
            $payment->status = Payment::FAIL;
            $payment->comment = $message;
            $payment->save();
        } catch (\Throwable $exception) {
            $payment = new Payment();
        }
        $this->status = "FAILED";
        /** @var \App\Models\Invoice $this */
        $this->save();
        event(new InvoiceFailed($this, $payment));

        return $payment;
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Invoice::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Invoice::class)
                ->where('evaluationable_id',$this->id);
        })->get();
    }
}
