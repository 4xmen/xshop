<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Xlang
 *
 * @property int $id
 * @property string $name
 * @property string $tag
 * @property int $rtl
 * @property int $is_default
 * @property string|null $img
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\XlangFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereRtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xlang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Xlang extends Model
{
    use HasFactory;
}
