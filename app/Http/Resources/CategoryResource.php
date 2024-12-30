<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

//use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request, $data = null): array
    {
        /**
         * @var $this Category
         */

        if (!$request['loadCategory'])
            $request->merge([
                'loadCategory' => false
            ]);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'sort' => $this->sort,
            'image' => $this->imgUrl(),
            'image_original' => $this->imgOriginalUrl(),
            'bg' => $this->bgUrl(),
            'bg_original' => $this->bgOriginalUrl(),
            'svg' => $this->svgUrl(),
            'icons' => $this->icon,
            'products' => $this->when($request->input('loadProduct', true),
                ProductResource::collection($this->products()->paginate($request->input('per_page', 20)))
                    ->additional(['request' => $request['loadCategory']])),
            'products_pages_count' => ceil($this->products()->count()  / $request->input('per_page', 20) ),
        ];
    }
}
