<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class Group extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

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
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    //
    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Group::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    public function imgUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('optimized/groups/' . $this->image.'.webp');
    }

    public function imgOriginalUrl()
    {
        if ($this->image == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('groups/' . $this->image);
    }

    public function bgUrl()
    {
        if ($this->bg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('optimized/groups/'  . $this->bg.'.webp');
    }

    public function bgOriginalUrl()
    {
        if ($this->bg == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('groups/' . $this->bg);
    }

    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function webUrl()
    {
        return fixUrlLang(route('client.group',$this->slug));
    }

    public function published($limit = 10, $order = 'id', $dir = 'DESC')
    {
        return $this->posts()->where('status', 1)
            ->orderBy($order, $dir)->limit($limit)->get(['title', 'slug', 'icon']);
    }

    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Group::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', Group::class)
                ->where('evaluationable_id',$this->id);
        })->get();
    }

    public function markup()
    {
        $keywords = $this->markupKeywords();
        // add markups
        return getValidMarkup($this->markups??'', $keywords) . PHP_EOL ;
    }
}
