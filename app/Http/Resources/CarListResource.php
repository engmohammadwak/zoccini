<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class CarListResource extends JsonResource
{
    public function toArray($request)
    {

        if (App::getLocale() == 'ar')
        {
            $car_brand = optional($this->car_brand)->name_ar;
            $car_color = optional($this->car_color)->name_ar;
            $car_type = optional($this->car_type)->name_ar;
        }else{
            $car_brand = optional($this->car_brand)->name_en;
            $car_color = optional($this->car_color)->name_en;
            $car_type = optional($this->car_type)->name_en;
        }
        return [
            'id' => $this->id,
            'car_brand_id' =>  $car_brand ,
            'car_type_id' => $car_type,
            'car_color_id' => $car_color,
            'pate_number' => $this-> pate_number,
        ];
    }
}