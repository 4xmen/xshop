<?php

namespace App\Http\Resources;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $this Slider
         */
        return [
            'id' => $this->id,
            'body' => $this->body,
            'image' => $this->imgUrl(),
            'tag' => $this->tag,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'data' => $this->data,
            'user' => $this->load('author')
        ];
    }
}
