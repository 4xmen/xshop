<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adv extends Model
{
    use SoftDeletes;

    protected $casts = [
        'expire' => 'date'
    ];
    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('assets/upload/logo.svg');
        }

        return \Storage::url('ad/' . $this->image);
    }
}
