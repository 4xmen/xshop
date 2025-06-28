<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Collection\Collection;
use Spatie\Translatable\HasTranslations;

class Creator extends Model
{



    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['name', 'subtitle', 'description'];
    public $guarded = [];

    public static function getLocale()
    {
        return app()->getLocale();
    }



    public static function findOrCreate(
        string | array | ArrayAccess $values,
        string | null $type = null,
        string | null $locale = null,
    ) {
        $creators = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $creators->first() : $creators;
    }


    public static function findFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        return static::query()
//            ->where('type', $type)
            ->where(function ($query) use ($name, $locale) {
                $query->where("name->{$locale}", $name)
                    ->orWhere("slug->{$locale}", $name);
            })
            ->first();
    }


    public static function findOrCreateFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        $creator = static::findFromString($name, $type, $locale);

        if (! $creator) {
            $creator = static::create([
                'name' => [$locale => $name],
                'slug' => sluger($name),
//                'type' => $type,
            ]);
        }

        return $creator;
    }


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
