<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class RestaurantSimpleResource extends JsonResource
{

    public function toArray($request)
    {

        if ( App::getLocale() == 'ar') {
            $name = $this->name_ar ;
        }else {
            $name  = $this->name_en ;
        }

        if ($this->image == ''){
            $image = url('local/public/img/setting/' . getSetting('restaurant_image'));
        }else{
            $image = url('local/public/img/user/' .$this->image );
        }

        if ($this->restaurant->image == ''){
            $logo = url('local/public/img/setting/' . getSetting('restaurant_image'));
        }else{
            $logo = url('local/public/img/restaurant/' .$this->restaurant->image );

        }
        if ($this->min_waiting != '' & $this->max_waiting != ''){
            $time_waiting = $this->min_waiting.' - '.$this->max_waiting;
        }else{
            $time_waiting = '';
        }


        return [
            'id'     => $this->id,
            'logo'   => $logo ,
            'image'  => $image,
            'name'   => $name ?? '',
            'tag'   => $this->tag ?? '',
            'payment_method' => PaymentMethodResource::collection($this->payment_methods),
            'delivery' => new DeliveryResource($this->delivery),
            'time_waiting' => $time_waiting,
            'min' => (float) 10.00,
            'rate'   => 5
        ];
    }
}
