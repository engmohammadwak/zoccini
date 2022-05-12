<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type ,
            $this->mergeWhen($this->type == 1, [
                'mail' => new ItemResource($this->item),
            ]),
            $this->mergeWhen($this->type == 2, [
                'restaurant' => new RestaurantSimpleResource($this->restaurant),
            ]),
        ];
    }
}

