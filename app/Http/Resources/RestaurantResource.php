<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class RestaurantResource extends JsonResource
{
    public function toArray($request)
    {

        if ( App::getLocale() == 'ar') {
            $name = $this->name_ar ;
            $description = $this->description_ar ;
            $country = optional($this->country)->name_ar ?? '' ;
            $city = optional($this->city)->name_ar ?? '' ;
        }else {
            $name  = $this->name_en ;
            $description = $this->description_en ;
            $country = optional($this->country)->name ?? '' ;
            $city = optional($this->city)->name_en ?? '' ;
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


        if ($this->open_time != '' & $this->close_time != ''){
            $open_close_time =  date('h:i a', strtotime($this->open_time)).' - '.date('h:i a', strtotime($this->close_time));
        }else{
            $open_close_time = '';
        }

        return [
            'id'     => $this->id,
            'logo'   => $logo ?? '',
            'image'  => $image ?? '',
            'name'   => $name ?? '',
            'description'   => $description ?? '',
            'tag'   => $this->tag ?? '',
            'payment_method' => PaymentMethodResource::collection($this->payment_methods),
            'delivery' => new DeliveryResource($this->delivery),
            'sitting_area' => SittingAreasResource::collection($this->sitting_areas),
            'time_waiting' => $time_waiting,
            'address' => $this->address ?? '',
            'lat' => $this->lat ?? '',
            'lang' => $this->lang ?? '',
            'phone' => optional($this->restaurant)->phone,
            'opening_and_close_time' => $open_close_time,
            'country' => $country,
            'city' => $city,
            'min' => (float)min_price($this->id),
            'rate'   => 5,
            'number_rate'   => 5,
            'isFavority' => isFavority($this->id , 2),
            'branch' => BranchResource::collection($this->branch),
        ];
    }
}
