<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        $image = url('local/public/img/item/' . $this->photo);
        if ( App::getLocale() == 'ar') {
            $name        = $this->name;
            $description = $this->description_ar;
        }else {
            $name        = $this->name_en;
            $description = $this->description_en;
        }

        return [
            'id' => $this->id,
            'name' => $name,
            'price' => $this->price,
            'description' => $description,
            'photo' => $image,
        ];
    }
}
