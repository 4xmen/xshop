<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Access extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
