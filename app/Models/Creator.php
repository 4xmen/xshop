<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Creator extends Model
{
    /** @use HasFactory<\Database\Factories\CreatorFactory> */
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['name', 'subtitle', 'description'];


    public function children()
    {
        return $this->hasMany(Creator::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('creator/optimized-' . $this->image);
    }

    public function imgOriginalUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('creator/' . $this->image);
    }

    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function webUrl()
    {
        return fixUrlLang(route('client.creator',$this->slug));
    }


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Creator::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Creator::class)
                ->where('evaluationable_id',$this->id);
        })->get();
    }
}
