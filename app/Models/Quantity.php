<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Metable\Metable;

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
class Quantity extends Model
{
    use HasFactory, Metable, SoftDeletes;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
