<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PostResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray(Request $request)
    {
        /** @var \App\Models\User|null $postAuthor */
        $postAuthor = $this->whenLoaded('user');
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'author' => $postAuthor?->name ?? '-',
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
}
