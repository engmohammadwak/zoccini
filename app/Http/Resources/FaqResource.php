<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class FaqResource extends JsonResource
{
    public function toArray($request)
    {
        if ( App::getLocale() == 'ar') {
            $q = $this->q_ar ;
            $n = $this->a_ar ;
        }else {
            $q = $this->q_en ;
            $n = $this->a_en ;
        }


        return [
            'id' => $this->id,
            'question' => $q ,
            'answer' => $n ,
        ];
    }

}
