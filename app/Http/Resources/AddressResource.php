<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nice_name' => $this->nice_name,
            'area' => $this->area ,
            'street' => $this->street ,
            'building' => $this->building ,
            'floor' => $this->floor ,
            'apartment_no' => $this->apartment_no ,
            'additional_direction' => $this->additional_direction ,
            'landing_number' => $this->landing_number ,
            'phone' => $this->phone ,
            'lat' => $this->lat  ,
            'lang' => $this->lang ,
            'main_address' => $this->main_address ,
        ];
    }
}
