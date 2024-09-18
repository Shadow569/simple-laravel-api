<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TagResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'identifier' => $this->identifier,
            'name' => $this->name,
        ];
    }
}
