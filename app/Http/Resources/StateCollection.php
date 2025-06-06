<?php

namespace App\Http\Resources;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StateCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $this State
         */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country,
            'lat' => $this->lat,
            'lng' => $this->lng
        ];
    }
}
