<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->nama ?? $this->name ?? null,
            'image' => $this->image_url ?? $this->image ?? null,
            'icon' => $this->icon_emoji ?? $this->icon ?? null,
            'color' => $this->warna ?? $this->color ?? null,
        ];
    }
}
