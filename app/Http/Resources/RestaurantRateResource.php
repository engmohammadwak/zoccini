<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantRateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rate' => $this->rating,
            'number_rate' => $this->number_rate,
            'rate_1' => $this->rate->avg('rate_1'),
            'rate_2' =>$this->rate->avg('rate_2'),
            'rate_3' => $this->rate->avg('rate_3'),
            'rate_4' => $this->rate->avg('rate_4'),
            'rating' => RatingResource::collection($this->rate),
        ];
    }
}
