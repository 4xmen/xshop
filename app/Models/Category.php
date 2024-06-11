<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function imgUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('category/' . $this->image);
    }
    public function bgUrl()
    {
        if ($this->bg == null) {
            return null;
        }

        return \Storage::url('category/' . $this->bg);
    }
}
