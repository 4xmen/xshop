<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Attachment extends Model
{
    use HasFactory;
}
