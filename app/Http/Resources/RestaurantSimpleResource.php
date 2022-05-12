<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class RestaurantSimpleResource extends JsonResource
{

    public function toArray($request)
    {

        if (App::getLocale() == 'ar') {
            $name = $this->name_ar;
            $country = optional($this->country)->name_ar;
            $city = optional($this->city)->name_ar;
        } else {
            $name = $this->name_en;
            $country = optional($this->country)->name;
            $city = optional($this->city)->name_en;
        }

        if ($this->image == ''){
            $image = url('local/public/img/setting/' . getSetting('restaurant_image'));
        }else{
            $image = url('local/public/img/restaurants/' .$this->image );
        }

        if (optional($this->restaurant)->image == ''){
            $logo = url('local/public/img/setting/' . getSetting('restaurant_image'));
        }else{
            $logo = url('local/public/img/user/' .optional($this->restaurant)->image );

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
            'logo'   => $logo ,
            'image'  => $image,
            'name'   => $name,
            'tag'   => $this->tag,
            'payment_method' => PaymentMethodResource::collection($this->payment_methods),
            'delivery' => new DeliveryResource($this->delivery) ,
            'time_waiting' => $time_waiting,
            'max_time_waiting' => (int) $this->max_waiting,
            'min' => (float) $this->mins ,
            'lat' => $this->lat ,
            'lang' => $this->lang  ,
            'number_reservation_inside'  => Order::where('restaurants_id'  , $this->id)->where('status_id' ,3 )->where('type_id' ,1 )->count() + 1,
            'number_reservation_outside' => Order::where('restaurants_id'  , $this->id)->where('status_id' ,3 )->where('type_id' ,2 )->count() + 1,
            'rate'   => round($this->rating , 2),
            'number_rate'   => $this->number_rate,
            'isFavority' => isFavority($this->id , 2),
            'opening_and_close_time' => $open_close_time,
            'phone' => optional($this->restaurant)->phone,
            'address' => $this->address,
            'country' => $country,
            'city' => $city,

        ];
    }
}
