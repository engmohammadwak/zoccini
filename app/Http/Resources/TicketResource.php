<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class TicketResource extends JsonResource
{
    public function toArray($request)
    {

        if (App::getLocale() == 'ar')
        {
            $status_name = optional($this->status)->name_ar;
        }else{
            $status_name = optional($this->status)->name_en;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status_id' => $this->status_id,
            'status_name' => $status_name,
            'created_at' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $this->created_at)->format('d/m/Y'),
        ];
    }
}
