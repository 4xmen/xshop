<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Sms extends Model
{
    use HasFactory;
}
