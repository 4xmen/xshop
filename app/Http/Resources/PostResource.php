<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $this Post
         */
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'body' => $this->body,
            'group' => GroupsCollection::make($this->mainGroup),
            'groups'=> GroupsCollection::collection($this->groups),
//            'group' => $this->load('groups'),
            'author' => $this->load('author'),
            'view' => $this->view,
            'is_pinned' => $this->is_pinned,
            'hash' => $this->hash,
            'like' => $this->like,
            'dislike' => $this->dislike,
            'icon' => $this->icon,
            'image' => $this->imgUrl(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
