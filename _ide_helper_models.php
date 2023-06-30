<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Access
 *
 * @property int $id
 * @property int $user_id
 * @property string $route
 * @property int $owner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Access newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Access newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Access query()
 * @method static \Illuminate\Database\Eloquent\Builder|Access whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Access whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Access whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Access whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Access whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Access whereUserId($value)
 * @mixin \Eloquent
 */
	class Access extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $address
 * @property int $customer_id
 * @property float|null $lat
 * @property float|null $lng
 * @property int|null $state
 * @property int|null $city
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Address withoutTrashed()
 * @mixin \Eloquent
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property string $title
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Attachment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cat
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $sort
 * @property string|null $image
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $active_products
 * @property-read int|null $active_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Cat[] $children
 * @property-read int|null $children_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Cat|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prop[] $props
 * @property-read int|null $props_count
 * @method static \Database\Factories\CatFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cat withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cat withoutTrashed()
 * @property int $is_main
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereIsMain($value)
 * @mixin \Eloquent
 */
	class Cat extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string|null $subject
 * @property string $phone
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
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
	class Credit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int|null $state
 * @property int|null $city
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @property string|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCode($value)
 * @property string|null $address_alt
 * @property string|null $sms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $main_tickets
 * @property-read int|null $main_tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSms($value)
 * @property int $colleague
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereColleague($value)
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDescription($value)
 * @property int $credit
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCredit($value)
 * @property int $cerdit
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Credit[] $credits
 * @property-read int|null $credits_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCerdit($value)
 * @mixin \Eloquent
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @property int $id
 * @property int $product_id
 * @property int $amount
 * @property string $type
 * @property string $code
 * @property string|null $expire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Discount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Discount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Discount withoutTrashed()
 * @mixin \Eloquent
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \App\Models\Address|null $address
 * @mixin \Eloquent
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \App\Models\Invoice $invoice
 * @mixin \Eloquent
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Price
 *
 * @property int $id
 * @property int $price
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Price extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $excerpt Quick summary for product. This will appear on the product page under the product name and for SEO purpose.
 * @property string|null $sku SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and service that can be purchased.
 * @property int|null $virtual If this product is a non-physical item, for example a service, which does not need shipping.
 * @property int|null $downloadable If purchasing this product gives a customer access to a downloadable file, e.g. software
 * @property int|null $price
 * @property int $cat_id main category id
 * @property int $user_id
 * @property int|null $on_sale
 * @property int|null $stock_quantity
 * @property string|null $stock_status
 * @property int|null $rating_count
 * @property string|null $average_rating
 * @property int|null $total_sales
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $approved_comments
 * @property-read int|null $approved_comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cat[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Cat $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property array $tag_names
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tagged[] $tags
 * @property-read mixed $url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Plank\Metable\Meta[] $meta
 * @property-read int|null $meta_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Conner\Tagging\Model\Tagged[] $tagged
 * @property-read int|null $tagged_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product orderByMeta(string $key, string $direction = 'asc', bool $strict = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orderByMetaNumeric(string $key, string $direction = 'asc', bool $strict = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDoesntHaveMeta($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDownloadable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasMeta($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasMetaKeys(array $keys)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMeta(string $key, $operator, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaIn(string $key, array $values)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaNumeric(string $key, string $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRatingCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVirtual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withAllTags($tagNames)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withAnyTag($tagNames)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product withoutTags($tagNames)
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quantity[] $quantities
 * @property-read int|null $quantities_count
 * @property int $sell_count
 * @property int $view_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Price[] $prices
 * @property-read int|null $prices_count
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereViewCount($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Discount[] $discounts
 * @property-read int|null $discounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $quesions
 * @property-read int|null $quesions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $quesions_asnwered
 * @property-read int|null $quesions_asnwered_count
 * @property int $fee
 * @property int $extra_price
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExtraPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFee($value)
 * @property int $image_index
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImageIndex($value)
 * @property int $carat
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCarat($value)
 * @mixin \Eloquent
 */
	class Product extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Prop
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $width
 * @property int $required
 * @property int $searchable
 * @property string $type
 * @property int $sort
 * @property string|null $options
 * @property int $priceable
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cat[] $category
 * @property-read int|null $category_count
 * @method static \Database\Factories\PropFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop newQuery()
 * @method static \Illuminate\Database\Query\Builder|Prop onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop wherePriceable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereSearchable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|Prop withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Prop withoutTrashed()
 * @property string $unit
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereUnit($value)
 * @mixin \Eloquent
 */
	class Prop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Quantity
 *
 * @property int $id
 * @property int $product_id
 * @property int $count
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereUpdatedAt($value)
 * @property string|null $data
 * @property-read \Illuminate\Database\Eloquent\Collection|\Plank\Metable\Meta[] $meta
 * @property-read int|null $meta_count
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity orderByMeta(string $key, string $direction = 'asc', bool $strict = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity orderByMetaNumeric(string $key, string $direction = 'asc', bool $strict = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereDoesntHaveMeta($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereHasMeta($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereHasMetaKeys(array $keys)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereMeta(string $key, $operator, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereMetaIn(string $key, array $values)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereMetaNumeric(string $key, string $operator, $value)
 * @property int|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereImage($value)
 * @property-read \App\Models\Product $product
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Quantity withoutTrashed()
 * @mixin \Eloquent
 */
	class Quantity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $body
 * @property int $customer_id
 * @property string|null $answer
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @property int $status
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereStatus($value)
 * @mixin \Eloquent
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $section
 * @property string $type
 * @property string $title
 * @property int $active
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sms
 *
 * @property int $id
 * @property string $text
 * @property string $ip_address
 * @property string $user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereUser($value)
 * @property string|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereCode($value)
 * @property string $ip
 * @property string|null $mobile
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereMobile($value)
 * @mixin \Eloquent
 */
	class Sms extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|Ticket[] $subTickets
 * @property-read int|null $sub_tickets_count
 * @mixin \Eloquent
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transport
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $sort
 * @property int $is_default
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport newQuery()
 * @method static \Illuminate\Database\Query\Builder|Transport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Transport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Transport withoutTrashed()
 * @mixin \Eloquent
 */
	class Transport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $mobile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\AdminLog[] $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Access> $accesses
 * @property-read int|null $accesses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Access> $accesses
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Access> $accesses
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 */
	class User extends \Eloquent {}
}

