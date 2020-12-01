<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

        if ($this->image == '') {
            $photo = 'local/public/img/setting/' . getSetting('user_image');

        } else {
            $photo = $this->image;
        }

        return [
            'id' => $this->id,
            'first_name' => $this->name ?? '',
            'last_name' => $this->last_name ?? '',
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'date_of_birth' => $this->date_of_birth ?? '',
            'gender' => $this->gender ?? '',
            'sms_subscription' => $this->sms_subscription ?? '',
            'email_subscription' => $this->email_subscription ?? '',
            'image' => $photo ?? '',
        ];
    }
}
