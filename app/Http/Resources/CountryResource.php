<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        if ( App::getLocale() == 'ar') {
            $name        = $this->name_ar;
            $currency    = optional($this->currency)->name_ar;
        }else {
            $name        = $this->name;
            $currency    = optional($this->currency)->name_en ;
        }


        return [
            'id'   => $this->id,
            'name' => $name,
            'currency' => $currency,
            'code' => $this->short_code,
            'city' => CityResource::collection($this->city),
        ];
    }
}
