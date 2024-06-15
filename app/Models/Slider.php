<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['body'];

    protected $casts = [
        'dataz'
    ];

    public function imgUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('sliders/' . $this->image);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getDatazAttribute(){
        $result = [];
        foreach (json_decode($this->data) as $item) {
            $result[$item->key] = $item->value;
        }

        return $result;
    }
}
