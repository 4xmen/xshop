<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adv extends Model
{
    use SoftDeletes;

    public function imgUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('advs/' . $this->image);
    }
}
