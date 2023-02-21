<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Transport extends Model
{
    use HasFactory,SoftDeletes;
}
