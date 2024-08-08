<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCardCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id'=> $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->imgUrl(),
            'meta' => $this->fullMeta(),
            'max' => $this->stock_quantity,
            'qz' => QunatityCollection::collection($this->quantities),
        ];
    }
}
