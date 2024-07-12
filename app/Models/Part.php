<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;


    public function getBlade(){
        $className= ucfirst($this->part);
        $handle = "\\Resources\\Views\\Segments\\$className";
        $handle::onMount($this);
        return 'segments.'.$this->segment.'.'.$this->part.'.'.$this->part;
    }
    public function getBladeWithData(){
        $className= ucfirst($this->part);
        $handle = "\\Resources\\Views\\Segments\\$className";
        return ['blade' => 'segments.'.$this->segment.'.'.$this->part.'.'.$this->part, 'data' =>  $handle::onMount($this)];
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
