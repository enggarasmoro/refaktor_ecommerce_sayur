<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->nama,
            'subtitle' => $this->info,
            'size' => null,
            'price' => (int) $this->final_price,
            'old_price' => (int) $this->harga,
            'discount' => $this->discount_percent ?? ($this->harga > $this->final_price ? (int) round(100 - ($this->final_price / $this->harga * 100)) : null),
            'media_type' => $this->media_type,
            'media' => $this->media,
        ];
    }
}
