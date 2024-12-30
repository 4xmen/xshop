<?php

namespace App\Http\Resources;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends JsonResource
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

        if (!$request['loadGroup'])
            $request->merge([
                'loadGroup' => false
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
            'posts' => $this->when($request->input('loadPost', true),
                PostResource::collection($this->posts()->paginate($request->input('per_page', 20)))
                    ->additional(['request' => $request['loadGroup']])),
            'posts_pages_count' => ceil($this->posts()->count()  / $request->input('per_page', 20) ),
        ];
    }
}
