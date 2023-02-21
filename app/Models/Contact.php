<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Contact extends Model
{
    use HasFactory;
}
