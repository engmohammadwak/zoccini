<?php

namespace App\Http\Resources;

use App\Models\Notification;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\False_;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

        if ($this->image == '') {
            $photo = url('local/public/img/setting/' . getSetting('user_image'));

        } else {
            $photo = url('local/public/img/user/' . $this->image);
        }

        if ($this->user_type == 10) {
            $restaurant_name = optional($this->restaurant)->name;
        } else {
            $restaurant_name =  null;
        }


        return [
            'id' => $this->id,
            'first_name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'sms_subscription' => $this->sms_subscription,
            'email_subscription' => $this->email_subscription,
            'image' => $photo,
            'isActive' => $this->status_id == 1 ? true : false,
            $this->mergeWhen($this->user_type = 2, [
                'country' => new CountryWithoutCity($this->country),
                'city' => new CityResource($this->city),
                'currency' => new CurrencyResource($this->currency),
                'lang' => $this->lang,
                'new_notification' => Notification::where('notifiable_id' , $this->id)->where('read_at' , null)->count(),
                ]),
            $this->mergeWhen($this->user_type != 2, [
                'restaurant_name' => $restaurant_name ,
                'country' => new CountryWithoutCity(Restaurant::where('restaurant_id', $this->id)->first() ? Restaurant::where('restaurant_id', $this->id)->first()->country : null),
            ]),
        ];
    }
}
