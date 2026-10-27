<?php

namespace App\Models;

use App\Http\Resources\CommentMarkupCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Plank\Metable\Metable;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations, HasTags, Metable;

    public static $stock_status = ['IN_STOCK', 'OUT_STOCK', 'BACK_ORDER'];


    public $translatable = ['name', 'excerpt', 'description', 'table'];
    protected $casts = [
        'qz' => 'array',
        'qidz' => 'array'
    ];


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
            'excerpt' => [
                'title' => __("Excerpt"),
                'value' => $this->excerpt,
            ],
            'desc' => [
                'title' => __("Description"),
                'value' => $this->description,
            ],
            'created_at' => [
                'title' => __("created_at"),
                'value' => $this->created_at->tz('UTC')->toAtomString(),
            ],
            'updated' => [
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
            'price' => [
                'title' => __("Price"),
                'value' => $this->getPrice(),
            ],
            'quantity' => [
                'title' => __("Quantities"),
                'value' => $this->stock_quantity,
            ],
            'sku' => [
                'title' => __("SKU"),
                'value' => $this->sku,
            ],
            'creators' => [
                'title' => __("Creators"),
                'value' => $this->creators()->pluck('name')->implode(', '),
            ],
            'discounts' => [
                'title' => __("Discounts"),
                'value' => json_encode($this->discounts()->get(['title', 'amount', 'type'])),
            ],
        ];
    }

    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function visible_attachs()
    {
        $user = auth('customer')->user();

        $query = $this->attachs();

        if (!$user) {
            return $query->where('is_premium', false)->get();
        }

        $hasPurchased = $user->purchased_products()
            ->contains($this->id);

        if ($hasPurchased) {
            return $query->get();
        }

        return $query->where('is_premium', false)->get();
    }

    protected $guarded = [];


    public function getQzAttribute()
    {
        $result = [];
        foreach ($this->quantities as $q) {
            if ($q->count > 0) {
                $q->data = json_decode($q->data);
                $result[] = $q;
            }
        }

        return $result;
    }

    public function getQidzAttribute()
    {
        return $this->quantities()->pluck('id')->toArray();
    }


    public function registerMediaConversions(?Media $media = null): void
    {

        $optimize = getSetting('optimize');
        if ($optimize == false) {
            $optimize = 'webp';
        }
        $ti = imageSizeConvertValidate('product_image');
        $t = imageSizeConvertValidate('product_thumb');

        $mc = $this->addMediaConversion('product-thumb')
            ->width($t[0])
            ->height($t[1])
            ->crop($t[0], $t[1])
            ->optimize()
            ->sharpen(10)
            ->nonQueued()
            ->format($optimize);

        $mc2 = $this->addMediaConversion('product-image')
            ->width($ti[0])
            ->height($ti[1])
            ->crop($ti[0], $ti[1])
            ->optimize()
            ->sharpen(10)
            ->nonQueued()
            ->format($optimize);

        if (getSetting('watermark')) {
            $mc->watermark(public_path('upload/images/logo.png'),
                AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                config('app.media.watermark_opacity'));

            $mc2->watermark(public_path('upload/images/logo.png'),
                AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                config('app.media.watermark_opacity'));
        }

        $this->addMediaConversion('product-optimized')
            ->optimize()
            ->sharpen(10)
            ->nonQueued()
            ->format('webp');
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', 1);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function creators()
    {
        return $this->belongsToMany(Creator::class, 'creator_product');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_id', 'id');
    }

    public function activeDiscounts()
    {
        return $this->hasMany(Discount::class, 'product_id', 'id')
            ->where(function ($query) {
                $query->where('expire', '>=', date('Y-m-d'))
                    ->orWhereNull('expire');
            });
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    function hasDiscount()
    {
        if (!$this->isAvailable()) {
            return false;
        }
        return $this->discounts()
                ->where(function ($query) {
                    $query->where('expire', '>=', date('Y-m-d'))
                        ->orWhereNull('expire');
                })->count() > 0;
    }


    public function imgUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl('product-image');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function originalImageUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl();
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function originalOptimizedImageUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl('product-optimized');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function imgUrl2()
    {
        if ($this->getMedia()->count() > 0 && isset($this->getMedia()[1])) {
            return $this->getMedia()[1]->getUrl('product-image');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function thumbUrl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[$this->image_index]->getUrl('product-thumb');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }

    public function thumbUrl2()
    {
        if ($this->getMedia()->count() > 0 && isset($this->getMedia()[1])) {
            return $this->getMedia()[1]->getUrl('product-thumb');
        } else {
            return asset('assets/upload/logo.svg');
        }
    }


    public function fullMeta($limit = 99)
    {
        $metas = $this->getAllMeta()->toArray();
        if (empty($metas)) {
            return [];
        }

        // get all props in one query
        $props = Prop::whereIn('name', array_keys($metas))->get()->keyBy('name');

        $result = [];
        foreach ($metas as $key => $value) {
            $prop = $props->get($key);
            if (!$prop) {
                continue; // skip without error
            }

            $result[$key] = [
                'value'       => $value,
                'data'        => $prop,
                'human_value' => humanValue($prop, $value),
            ];
        }

        usort($result, fn ($a, $b) => $a['data']->sort <=> $b['data']->sort);

        return array_slice($result, 0, $limit);
    }

    public function webUrl()
    {
        return fixUrlLang(route('client.product', $this->slug));
    }


    public function webUrlLang($lang)
    {
        $url = route('client.product', $this->slug);
        return str_replace(config('app.url'), config('app.url') . '/' . $lang, $url);
    }

    public function getPrice()
    {
        $price = 0;
        if ($this->quantities()->count() == 0) {
            $price = $this->price;
        } else {
            $price = $this->quantities()->min('price');
        }

        if (!$this->isAvailable()) {
            return __('Unavailable');
        }

        if ($this->hasDiscount()) {
            $d = $this->activeDiscounts()->first();
            if ($d->type == 'PRICE') {
                $price -= $d->amount;
            } else {
                $price = ((100 - $d->amount) * $price) / 100;
            }
        }

        if ($price == 0 || $price == '' || $price == null) {
            return __("Call us!");
        }

        return number_format($price) . ' ' . config('app.currency.symbol');
    }

    public function oldPricePure()
    {
        $price = 0;
        if ($this->quantities()->count() == 0) {
            $price = $this->price;
        } else {
            $price = $this->quantities()->min('price');
        }

        if ($price == 0 || $price == '' || $price == null) {
            return __("Call us!");
        }

        return $price;
    }

    public function oldPrice()
    {
        $price = 0;
        if ($this->quantities()->count() == 0) {
            $price = $this->price;
        } else {
            $price = $this->quantities()->min('price');
        }

        if ($price == 0 || $price == '' || $price == null) {
            return __("Call us!");
        }

        return number_format($price) . ' ' . config('app.currency.symbol');
    }

    public function isFav()
    {
        if (!auth('customer')->check()) {
            return -1;
        }
        if (\auth('customer')->user()->products()->where('product_id', $this->id)->exists()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function isAvailable()
    {
        if ($this->stock_quantity == 0) {
            return false;
        }

        if ($this->stock_status != 'IN_STOCK') {
            return false;
        }
        return true;
    }


    /**
     * renew stock quantity count & min price
     * @return void
     */
    public function renewPriceAndStock()
    {
        if ($this->quantities()->count() > 0) {
            $this->stock_quantity = $this->quantities()->sum('count');
            // just apply price has quantity
            $this->price = $this->quantities()->where('count', '>', 0)->min('price');
        }
        $this->save();
    }

    public function markup()
    {


        $currency = config('app.currency.code');
        $reviews = CommentMarkupCollection::collection($this->approvedComments)->toJson();
        $markup = <<<RESULT
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "name",
  "image": "{$this->name}",
  "url": "{$this->webUrl()}",
  "description": "{$this->excerpt}",
  "brand": {
    "@type": "Brand",
    "name": "{$this->category->name}"
  },
  "sku": "{$this->sku}",
  "offers": {
    "@type": "Offer",
    "url": "{$this->webUrl()}",
    "priceCurrency": "{$currency}",
    "price": "{$this->price}"
  },
   "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": "http://schema.org/PlayAction",
    "userInteractionCount": {$this->view}
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{$this->average_rating}",
    "ratingCount": "{$this->rating_count}",
    "reviewCount": "{$this->approvedComments()->count()}"
  },
  "review": $reviews
}
</script>
RESULT;

        $keywords = $this->markupKeywords();
        return $markup . PHP_EOL .
            getValidMarkup($this->category->default_markup ?? '', $keywords) . PHP_EOL .
//            getValidMarkup($this->author->markups??'', $this->author->markupKeywords()) . PHP_EOL .
            getValidMarkup($this->markups ?? '', $keywords) . PHP_EOL;

    }

    public function seoDesc()
    {
        $template = getSetting('product_description');
        if ($template == null || $template == '') {
            $template = __('%name% sale in our shop by %price% %category.name%');
        }
        $template = str_replace('%name%', $this->name, $template);
        $template = str_replace('%price%', $this->getPrice(), $template);
        $template = str_replace('%excerpt%', $this->excerpt, $template);
        $template = str_replace('%stock_quantity%', $this->stock_quantity, $template);
        $template = str_replace('%category.name%', $this->category->name, $template);

        return $template;

    }


    public function tagsList()
    {
        if ($this->tags()->count() == 0) {
            return getSetting('keyword');
        } else {
            return implode(',', $this->tags()->pluck('name')->toArray());
        }
    }


    public function evaluations()
    {

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Product::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Product::class)
                ->where('evaluationable_id', $this->id);
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', Category::class)
                ->where('evaluationable_id', $this->category_id);
        })->get();
    }


    public function relatedProduct(int $limit = 10): array
    {
        if (!$this->exists || !$this->getKey()) {
            return [];
        }

        $limit = max(1, min($limit, 50));

        // unique id each product + limit
        $cacheKey = "product:{$this->getKey()}:related:{$limit}";

        return Cache::remember($cacheKey, now()->addHour(), function () use ($limit) {
            // All categories, including the main category.
            $categoryIds = $this->categories()
                ->pluck('categories.id')
                ->push($this->category_id)
                ->unique()
                ->values();

            $creatorIds = $this->creators()
                ->pluck('creators.id')
                ->unique()
                ->values();

            // Spatie Laravel Tags (HasTags trait).
            $tagIds = $this->tags()
                ->pluck('tags.id')
                ->unique()
                ->values();

            // No useful signals.
            if (
                $categoryIds->isEmpty()
                && $creatorIds->isEmpty()
                && $tagIds->isEmpty()
            ) {
                return [];
            }

            $candidates = static::query()
                ->select([
                    'products.id',
                    'products.category_id',
                    'products.stock_quantity',
                ])
                ->where('products.status', 1)
                ->whereNull('products.deleted_at')
                ->where('products.id', '<>', $this->getKey())
                ->where(function ($query) use (
                    $categoryIds,
                    $creatorIds,
                    $tagIds
                ) {
                    // Same main category.
                    $query->where(
                        'products.category_id',
                        $this->category_id
                    );

                    // Any shared category.
                    if ($categoryIds->isNotEmpty()) {
                        $query->orWhereHas(
                            'categories',
                            fn($q) => $q->whereIn(
                                'categories.id',
                                $categoryIds
                            )
                        );
                    }

                    // Shared creators.
                    if ($creatorIds->isNotEmpty()) {
                        $query->orWhereHas(
                            'creators',
                            fn($q) => $q->whereIn(
                                'creators.id',
                                $creatorIds
                            )
                        );
                    }

                    // Shared Spatie tags.
                    if ($tagIds->isNotEmpty()) {
                        $query->orWhereHas(
                            'tags',
                            fn($q) => $q->whereIn(
                                'tags.id',
                                $tagIds
                            )
                        );
                    }
                })
                ->withCount([
                    // Count shared categories, excluding each candidate's
                    // own main category to avoid double-counting it.
                    'categories as shared_categories_count' =>
                        fn($q) => $q
                            ->whereIn('categories.id', $categoryIds)
                            ->whereColumn(
                                'categories.id',
                                '<>',
                                'products.category_id'
                            ),

                    'creators as shared_creators_count' =>
                        fn($q) => $q->whereIn(
                            'creators.id',
                            $creatorIds
                        ),

                    'tags as shared_tags_count' =>
                        fn($q) => $q->whereIn(
                            'tags.id',
                            $tagIds
                        ),
                ]);

            // Rank the candidates in SQL.
            return DB::query()
                ->fromSub($candidates, 'ranked')
                ->select('ranked.id')
                ->selectRaw(
                    '(CASE WHEN ranked.category_id = ? THEN 10 ELSE 0 END)
     + (ranked.shared_categories_count * 3)
     + (ranked.shared_tags_count * 2)
     + (ranked.shared_creators_count * 4)
     + (CASE
          WHEN ranked.stock_quantity <= 0 THEN 0
          WHEN ranked.stock_quantity < 3 THEN 1
          WHEN ranked.stock_quantity < 10 THEN 2
          WHEN ranked.stock_quantity < 30 THEN 3
          ELSE 4
        END)
     AS similarity_score',
                    [$this->category_id]
                )
                ->orderByDesc('similarity_score')
                ->orderBy('ranked.id')
                ->limit($limit)
                ->pluck('ranked.id')
                ->map(fn($id) => (int)$id)
                ->all();
        });
    }

}
