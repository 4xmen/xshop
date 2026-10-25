<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    public $translatable = ['name', 'subtitle', 'description'];

    function markupKeywords()
    {
        return [
            'app.name' => [
                'title' => __("App name"),
                'value' => config('app.name'),
            ],
            'name' => [
                'title' => __("Name"),
                'value' => $this->name,
            ],
            'subtitle' => [
                'title' => __("Subtitle"),
                'value' => $this->subtitle,
            ],
            'desc' => [
                'title' => __("Description"),
                'value' => $this->description,
            ],
            'created_at' => [
                'title' => __("created_at"),
                'value' => $this->created_at->tz('UTC')->toAtomString(),
            ],
            'updated_at' => [
                'title' => __("updated_at"),
                'value' => $this->updated_at->tz('UTC')->toAtomString(),
            ],
            'url' => [
                'title' => __("URL"),
                'value' => $this->webUrl(),
            ],
            'img' => [
                'title' => __("Image"),
                'value' => $this->imgUrl(),
            ],
        ];
    }
    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('optimized/categories/' . $this->image. '.webp');
    }
    public function svgUrl()
    {
        if ($this->svg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('/' . $this->svg);
    }

    public function imgOriginalUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('categories/' . $this->image);
    }

    public function bgUrl()
    {
        if ($this->bg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('optimized/categories/' . $this->bg. '.webp');
    }

    public function bgOriginalUrl()
    {
        if ($this->bg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('categories/' . $this->bg);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function props()
    {
        return $this->belongsToMany(Prop::class);
    }

    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function webUrl()
    {
        return fixUrlLang(route('client.category',$this->slug));
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function published($limit = 10, $order = 'id', $dir = 'DESC')
    {
        return  $this->products()->where('status', 1)
            ->orderBy($order, $dir)->limit($limit)->get([
                'name',
                'slug',
            ])->map(function ($item) {
                // Change 'name' to 'title'
                $item->title = $item->name; // Add title property
                unset($item->name); // Remove the old name property
                return $item; // Return the modified item
            });

    }

    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Category::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Category::class)
                ->where('evaluationable_id',$this->id);
        })->get();
    }

    public function parallelCategories($limit = 10){
        return Category::where('parent_id' , $this->parent_id)->where('id','<>',$this->id)->limit($limit)->get();
    }

    public function markup()
    {
        $keywords = $this->markupKeywords();
        // add markups
        return getValidMarkup($this->markups??'', $keywords) . PHP_EOL ;
    }
}
