<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Cat
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $sort
 * @property string|null $image
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $active_products
 * @property-read int|null $active_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Cat[] $children
 * @property-read int|null $children_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Cat|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prop[] $props
 * @property-read int|null $props_count
 * @method static \Database\Factories\CatFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cat withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cat withoutTrashed()
 * @mixin \Eloquent
 */
class Cat extends Model implements HasMedia
{
    use HasFactory,SoftDeletes, InteractsWithMedia;

    public function registerMediaConversions(Media $media = null): void
    {


        $this->addMediaConversion('cat-thumb')
            ->width(600)
            ->height(600)
            ->crop(Manipulations::CROP_CENTER, 600, 600)
            ->optimize()
            ->sharpen(10);

        if (isset($_FILES['image'])) {
            $this->addMediaFromRequest('image')->preservingOriginal();
        }
    }

    public function thumbUrl() {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('cat-thumb');
        } else {
            return asset('/images/logo.png');

        }
    }

    public function imgurl() {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->last()->getUrl();
        } else {
            return asset('/images/logo.png');
        }
    }

    public function products(){
        return$this->belongsToMany(Product::class);
    }
    public function active_products(){
        return$this->belongsToMany(Product::class)->where('');
    }

    public function backUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('cats/' . $this->image);
    }

    //
    public function parent() {
        return $this->belongsTo(Cat::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Cat::class, 'parent_id');
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function props(){
        return $this->belongsToMany(Prop::class);
    }
}
