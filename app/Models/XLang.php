<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XLang extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'xlangs';

    public function imgUrl()
    {
        if ($this->img == null || $this->img == '') {
            return asset('/assets/upload/logo.svg');
        } else {
            return \Storage::url('langz/optimized-' . $this->img);
        }
    }
    public function imgOriginalUrl()
    {
        if ($this->img == null || $this->img == '') {
            return asset('/assets/upload/logo.svg');
        } else {
            return \Storage::url('langz/' . $this->img);
        }
    }

    public function getRouteKeyName(){
        return 'tag';
    }
}
