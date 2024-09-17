<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CommentResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray(Request $request)
    {
        /** @var \App\Models\User|null $commentUser */
        $commentUser = $this->whenLoaded('user');
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'poster' => $commentUser?->name ?? '-',
        ];
    }
}
