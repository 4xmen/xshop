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

    public function getMetaAttribute(){

        $data = json_decode($this->data,true);
        if ($data == null) {
            return [];
        }
        $props = $this->product->category->props()->whereIn('name', array_keys($data))->get();
        $result = [];
        foreach ($props as $key => $prop) {
            $result[$prop->name] =  [
                'label' => $prop->label,
                'human_value' => '',
                'type' => $prop->type,
                'value' => $data[$prop->name],
            ];
            switch ($prop->type) {
                case 'color':
                    $result[$prop->name]['human_value'] = "<div style='background:  {$data[$prop->name]}' class='color-bullet'> &nbsp; </div>";
                    break;
                case 'checkbox':
                    $result[$prop->name]['human_value'] = $data[$prop->name] ? '<i class="ri-checkbox-circle-line"></i>' : '<i class="ri-close-circle-line"></i>';
                    break;
                case 'select':
                case 'singlemulti':
                    $tmp = $prop->datas;
                    if (!is_array($data[$prop->name])) {
                        if (isset($tmp[$data[$prop->name]])){
                            $result[$prop->name]['human_value'] = $tmp[$data[$prop->name]];
                        }else{
                            $result[$prop->name]['human_value'] = '-';
                        }
                    } else {
                        $result[$prop->name]['human_value'] = '';
                        $tmp = $prop->datas;
                        foreach ($data[$prop->name] as $k => $v) {
                            $result[$prop->name]['human_value'] = $tmp[$v] . ', ';
                        }
                        $result[$prop->name]['human_value'] = trim($result[$prop->name], ' ,');
                    }
                    break;
                default:
                    if (is_array($data[$prop->name])) {
                        $result[$prop->name]['human_value'] = '<span class="meta-tag">'.implode('</span> <span class="meta-tag">', $data[$prop->name]).'</span>';
                    } else {
                        if ($data[$prop->name] == '' || $data[$prop->name] == null) {
                            $result[$prop->name]['human_value'] = '-';
                        }else{
                            $result[$prop->name]['human_value'] = $data[$prop->name];
                        }
                    }
            }

            $result[$prop->name]['human_value'] .= ' ' . $prop->unit;
        }

        return  $result;
    }
}
