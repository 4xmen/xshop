<?php

namespace App\Http\Resources;

use App\Models\Quantity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QunatityCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $this Quantity
         */
        return [
            'id' => $this->id,
            'product_name' => $this->product->name,
            'count' => $this->count,
            'data'=> json_decode($this->data),
            'meta' => $this->meta,
            'price'=>  $this->price,
            'image' => $this->product->getMedia()[$this->image]->getUrl('product-image'),
        ];
    }
}
