<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * @OA\Info(title="xShop API", version="1.0.0")
 */
/**
 * @OA\PathItem(path="/api/v1")
 */
class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/products",
     *     summary="Get list of products",
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"new", "old", "most_view", "less_view", "most_buy", "less_buy","cheap","expensive"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of products"
     *     )
     * )
     */
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
                if ($request['sort'] === 'cheap')
                    $product = $product->orderBy('price');
                if ($request['sort'] === 'expensive')
                    $product = $product->orderByDesc('price');
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
