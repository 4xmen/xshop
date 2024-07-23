<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{


    use HasFactory, HasTranslations;

    public $translatable = ['body'];

    protected $casts = [
        'dataz'
    ];

    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('sliders/optimized-' . $this->image);
    }

    public function imgOriginalUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('sliders/' . $this->image);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getDatazAttribute()
    {
        $result = [];
        foreach (json_decode($this->data) as $item) {
            $result[$item->key] = $item->value;
        }

        return $result;
    }


    public static function addData($key, $defaultValue = null)
    {
        foreach (Slider::all() as $item) {
            $data = json_decode($item->data, true);
            $data[] = ['key' => $key, 'value' => $defaultValue];
            $item->data = json_encode($data);
            $item->save();
        }
    }

    public static function remData($key)
    {
        foreach (Slider::all() as $item) {
            $tmp = $item->dataz;
            $data = [];
            foreach ($tmp as $k => $v) {
                if ($key != $k) {
                    $data[] = ['key' => $k, 'value' => $v];
                }
            }

            $item->data = json_encode($data);
            $item->save();
        }
    }

}
