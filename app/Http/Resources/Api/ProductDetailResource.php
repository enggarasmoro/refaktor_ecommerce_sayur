<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    public function toArray($request)
    {
        // underlying model provides toDetailArray()
        if (method_exists($this->resource, 'toDetailArray')) {
            return $this->resource->toDetailArray();
        }
        return parent::toArray($request);
    }
}
