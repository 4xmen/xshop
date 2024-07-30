<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $cacheKey = 'products_' . md5($request->getUri());

        $data = Cache::remember($cacheKey, now()->addMinutes(env('CACHE_LIFE_TIME', 10)), function () use ($request) {
            $product = Product::query();
            /**
             * Product Sort by keys
             */
            if (isset($request['sort']) && !is_null($request['sort'])) {
                if ($request['sort'] === 'new')
                    $product = $product->orderByDesc('created_at');
                if ($request['sort'] === 'old')
                    $product = $product->orderBy('created_at');
                if ($request['sort'] === 'most_view')
                    $product = $product->orderByDesc('view');
                if ($request['sort'] === 'less_view')
                    $product = $product->orderBy('view');
                if ($request['sort'] === 'most_buy')
                    $product = $product->orderByDesc('sell');
                if ($request['sort'] === 'less_buy')
                    $product = $product->orderBy('sell');
            }
            if (isset($request['category']) && !is_null($request['category']))
                $product = $product->where('category_id', Category::firstWhere('slug', $request['category'])->id);

            if (isset($request['search']) && !is_null($request['search']))
                $product = $product->where('name', 'LIKE', "%$request->search%");

            if (isset($request['min_price']) &&
                isset($request['max_price']) &&
                !is_null($request['min_price']) &&
                !is_null($request['max_price'])
            ) {
                $product = $product->whereBetween('buy_price', [
                    intval($request->min_price),
                    intval($request->max_price)
                ]);
            }
            $request->merge([
                'loadCategory' => true
            ]);
            return [
                'products' => ProductResource::collection($product->paginate($request->input('per_page', 20)))->resource->toArray(),
            ];
        });
        return success($data);
    }
}
