<?php

namespace App\Http\Resources;

use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class OrderRestaurantResource extends JsonResource
{
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'user_name' => $this->user->name.' '.$this->user->last_name,
            'user_phone' => $this->user->phone,
            'time' => $this->created_at != '' ? $this->created_at->translatedFormat('h:i A') : '',
            'status_id' => $this->status_id,
            'status_name' => App::getLocale() == 'ar' ? $this->status->name_ar : $this->status->name_en,
            'table' => optional($this->table_data)->number,
            'type' => $this->type_id,

        ];
    }
}
