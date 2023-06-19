<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Metable\Metable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Comment;
use function App\Helpers\getSetting;

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
class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Taggable, Metable, HasFactory;

    protected $guarded = [];
    protected $appends = ['url'];

    public function getTitle()
    {
        return $this->name . getSetting('prefix') . $this->id;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approved_comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', 1)->whereNull('sub_comment_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Cat::class);
    }

    public function category()
    {
        return $this->belongsTo(Cat::class, 'cat_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCode()
    {
        if ($this->sku != '')
            return $this->sku;
        else
            return $this->id;

    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this->addMediaConversion('product-image')
            ->width(1200)
//            ->height(600)
//            ->crop(Manipulations::CROP_CENTER, 1200, 600)
            ->optimize()
            ->sharpen(10);
        $this->addMediaConversion('product-thumb')
            ->width(600)
            ->height(600)
            ->crop(Manipulations::CROP_CENTER, 600, 600)
            ->optimize()
            ->sharpen(10);
    }

    public function thumbUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl('product-thumb');
        } else {
            return asset('/images/logo.png');

        }
    }

    public function thumbUrl2()
    {
        if ($this->getMedia()->count() > 0 && isset($this->getMedia()[1])) {
            return $this->getMedia()[1]->getUrl('product-thumb');
        } else {
            return asset('/images/logo.png');

        }
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl();
        } else {
            return asset('/images/logo.png');

        }
    }

    public function getUrlAttribute()
    {
        return route('product', ['pro' => $this->slug]);
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class, 'product_id');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id', 'id');
    }

    public function prices_history()
    {
        return $this->prices()->orderByDesc('id')->limit(20);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_id', 'id');
    }


    public function getPurePrice()
    {
        if ($this->discounts()->whereNull('code')->count() > 0) {
            $d = $this->discounts()->whereNull('code')->orderBy('id', 'desc')->first();
            if ($d->type == 'percent') {
                $price = $this->price - ($this->price * ($d->amount / 100));
                return $price;
            } else {
                return $this->price - $d->amount;
            }
        }
        return $this->price;
    }

    /**
     * with default
     * @param $def
     * @return float|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|int|mixed|null
     */
    public function getPurePriceDef($def)
    {
        if ($this->discounts()->whereNull('code')->count() > 0) {
            $d = $this->discounts()->whereNull('code')->orderBy('id', 'desc')->first();
            if ($d->type == 'percent') {
                $price = $def - ($def * ($d->amount / 100));
                return $price;
            } else {
                return $def - $d->amount;
            }
        }
        return $def;
    }

    public function getOldPrice()
    {
        if ($this->getPurePrice() == 0) {
            return __('Call us!');
        }
        return number_format($this->price) . ' ' . config('app.currency_type');
    }
    public function getPrice()
    {
        if ($this->getPurePrice() == 0) {
            return __('Call us!');
        }
        return number_format($this->getPurePrice()) . ' ' . config('app.currency_type');
    }

    public function quesions()
    {
        return $this->hasMany(Question::class);
    }

    public function quesions_asnwered()
    {
        return $this->hasMany(Question::class)->where('status', 1);
    }

    function hasDiscount()
    {
        return $this->discounts()->where('expire', '>', \DB::raw('NOW()'))->count() > 0;
    }

    public function isFav()
    {
        if (auth('customer')->check()) {
            return \auth('customer')->user()->products()->where('product_id', $this->id)->exists();
        } else {
            return false;
        }
    }

}
