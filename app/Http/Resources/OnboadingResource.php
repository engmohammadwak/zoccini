<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class OnboadingResource extends JsonResource
{

    public function toArray($request)
    {

        $image = url('local/public/img/onbording/' . $this->image);
        if ( App::getLocale() == 'ar') {
            $name        = $this->name_ar;
            $description = $this->description_ar;
        }else {
            $name        = $this->name_en;
            $description = $this->description_en;
        }


        return [
            'id' => $this->id,
            'name' => $name,
            'description' => $description,
            'photo' => $image,
        ];
    }
}
