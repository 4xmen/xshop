<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentMarkupCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '@type' => 'Review',
            'reviewBody' =>$this->body,
            'datePublished' => $this->created_at,
            'author' =>
                [
                    '@type' => 'Person',
                    'name' => $this->commentator()['name'],
                ],
        ];
    }
}
