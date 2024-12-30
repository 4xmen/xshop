<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoriesCollection extends JsonResource
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
        ];
    }
}
