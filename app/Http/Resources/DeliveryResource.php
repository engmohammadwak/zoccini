<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DeliveryResource extends JsonResource
{
    public function toArray($request)
    {
        if ( App::getLocale() == 'ar') {
            $name = $this->name_ar ;
        }else {
            $name  = $this->name_en ;
        }

        return [
            'id' => $this->id,
            'name' => $name,
        ];
    }
}
