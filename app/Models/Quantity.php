<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quantity extends Model
{
    use HasFactory,SoftDeletes;
    protected $casts = [
        'meta',
    ];


    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getMetaAttribute()
    {
        $data = json_decode($this->data, true);
        if (empty($data) || !is_array($data)) {
            return [];
        }

        $category = $this->product?->category;
        if (!$category) {
            return [];
        }

        $props = $category->props()->whereIn('name', array_keys($data))->get();
        $result = [];

        foreach ($props as $prop) {
            $value = $data[$prop->name];

            $result[$prop->name] = [
                'label'       => $prop->label,
                'type'        => $prop->type,
                'value'       => $value,
                'human_value' => humanValue($prop, $value),
            ];
        }

        return $result;
    }
}
