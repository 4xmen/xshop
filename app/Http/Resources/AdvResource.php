<?php

namespace App\Http\Resources;

use App\Models\Adv;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $this Adv
         */
        return [
            'id' => $this->id,
            'image' => $this->imgUrl,
            'title' => $this->title,
            'link' => $this->link,
        ];
    }
}
