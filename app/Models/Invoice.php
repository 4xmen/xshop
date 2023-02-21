<?php

namespace App\Models;

use App\Traits\PaymentStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $status
 * @property int|null $total_price
 * @property string|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\InvoiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $discount_id
 * @property-read \App\Models\Discount|null $discount
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDiscountId($value)
 * @property string|null $desc
 * @property int|null $transport_id
 * @property string|null $hash
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $successPayments
 * @property-read int|null $success_payments_count
 * @property-read \App\Models\Transport|null $transport
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTransportId($value)
 * @property int $transport_price
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTransportPrice($value)
 * @property string|null $address_alt
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAddressAlt($value)
 * @property int $reserve
 * @property int|null $invoice_id
 * @property string|null $tracking_code
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereReserve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTrackingCode($value)
 * @property int $credit_price
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Invoice|null $invoice
 * @property-read \Illuminate\Database\Eloquent\Collection|Invoice[] $subInvoices
 * @property-read int|null $sub_invoices_count
 * @method static \Illuminate\Database\Query\Builder|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreditPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Invoice withoutTrashed()
 * @property int|null $address_id
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAddressId($value)
 */
class Invoice extends Model
{
    use HasFactory,PaymentStore,SoftDeletes;
    protected $fillable = ['total_price','customer_id','transport_id'];

    public function discount(){
        return $this->belongsTo(Discount::class);
    }
//
//    public function products(){
//        return $this->belongsToMany(Product::class);
//    }


    const PENDING = 'PENDING';
    const PROCESSING = 'PROCESSING';
    const COMPLETED = 'COMPLETED';
    const CANCELED = 'CANCELED';
    const FAILED = 'FAILED';

    protected $casts = [
        'meta' => 'array',
    ];
    protected $guarded = [];


    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }
    public function subInvoices(){
        return $this->hasMany(Invoice::class,'invoice_id','id');
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

    public function transport(){
        return $this->belongsTo(Transport::class);
    }

    public function getRouteKeyName()
    {
        return 'hash';
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function getAddress(){
        if ($this->address_id == null){
            return Address::$states[$this->customer->state].','.Address::$cities[$this->customer->state][$this->customer->city].','.
                $this->customer->address;
        }else{
            return Address::$states[$this->address->state].','.Address::$cities[$this->address->state][$this->address->city].','.
                Address::where('id',$this->address_id)->first()->address;
        }
    }

}
