<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class CategoryResource extends JsonResource
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
            'food' => ItemResource::collection($this->item),
        ];
    }
}
