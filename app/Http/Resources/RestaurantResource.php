<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class RestaurantResource extends JsonResource
{
    public function toArray($request)
    {

        if (App::getLocale() == 'ar') {
            $name = $this->name_ar;
            $description = $this->description_ar;
            $country = optional($this->country)->name_ar;
            $city = optional($this->city)->name_ar;
        } else {
            $name = $this->name_en;
            $description = $this->description_en;
            $country = optional($this->country)->name;
            $city = optional($this->city)->name_en;
        }

        if ($this->image == '') {
            $image = url('local/public/img/setting/' . getSetting('restaurant_image'));
        } else {
            $image = url('local/public/img/restaurants/' . $this->image);

        }

        if (optional($this->restaurant)->image == '') {
            $logo = url('local/public/img/setting/' . getSetting('restaurant_image'));
        } else {
            $logo = url('local/public/img/user/' . $this->restaurant->image);

        }
        if ($this->min_waiting != '' & $this->max_waiting != '') {
            $time_waiting = $this->min_waiting . ' - ' . $this->max_waiting;
        } else {
            $time_waiting = '';
        }


        if ($this->open_time != '' & $this->close_time != '') {
            $open_close_time = date('h:i a', strtotime($this->open_time)) . ' - ' . date('h:i a', strtotime($this->close_time));
        } else {
            $open_close_time = '';
        }

        $now = Carbon::now()->setTimezone('Asia/Riyadh')->format('H:i');
        $begin = Carbon::parse($this->open_time)->format('H:i');
        $end = Carbon::parse($this->close_time)->format('H:i');

        if ($now >= $begin && $now <= $end) {
            $open = true;
        } else {
            $open = false;
        }

        return [
            'id' => $this->id,
            'logo' => $logo,
            'image' => $image,
            'name' => $name,
            'description' => $description,
            'tag' => $this->tag,
            'payment_method' => PaymentMethodResource::collection($this->payment_methods),
            'delivery' => new DeliveryResource($this->delivery),
            'sitting_area' => SittingAreasResource::collection($this->sitting_areas),
            'time_waiting' => $time_waiting,
            'address' => $this->address,
            'lat' => $this->lat,
            'lang' => $this->lang,
            'phone' => optional($this->restaurant)->phone,
            'opening_and_close_time' => $open_close_time,
            'country' => $country,
            'city' => $city,
            'min' => (float)min_price($this->id),
            'rate' => round($this->rating, 2),
            'number_rate' => $this->number_rate,
            'isFavority' => isFavority($this->id, 2),
            'branch' => BranchResource::collection($this->branch),
            'number_reservation_inside' => Order::where('restaurants_id', $this->id)->where('status_id', 3)->where('type_id', 1)->count() + 1,
            'number_reservation_outside' => Order::where('restaurants_id', $this->id)->where('status_id', 3)->where('type_id', 2)->count() + 1,
//            'rating' => RatingResource::collection($this->rate),
            'ads' => $this->media,
            'delivery_support' => $this->delivery_support == 1 ? true : false,
            'car_delivery_support' => $this->car_delivery_support == 1 ? true : false,
            'open' => $open,
        ];
    }
}

