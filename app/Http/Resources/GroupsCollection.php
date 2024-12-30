<?php

namespace App\Http\Resources;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupsCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $this Group
         */
        return[
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
        ];
    }
}
