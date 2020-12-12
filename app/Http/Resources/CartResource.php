<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item' => json_decode($this->item_json),
            'final_price' => final_price_cart($this->id),
        ];
    }
}
