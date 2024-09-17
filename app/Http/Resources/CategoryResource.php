<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CategoryResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title
        ];
    }
}
