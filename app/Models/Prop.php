<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @mixin \Eloquent
 * @property string $unit
 * @method static \Illuminate\Database\Eloquent\Builder|Prop whereUnit($value)
 */
class Prop extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function category()
    {
        return $this->belongsToMany(Cat::class);
    }
}
