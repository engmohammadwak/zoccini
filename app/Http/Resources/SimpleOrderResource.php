<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SimpleOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => App::getLocale() == 'ar' ? optional($this->restaurants)->name_ar : optional($this->restaurants)->name_en,
            'created_at' => $this->created_at != '' ? $this->created_at->translatedFormat('d/m/Y  h:i A') : '',
            'status_id' => $this->status_id,
            'status_name' => App::getLocale() == 'ar' ? optional($this->status)->name_ar :  optional($this->status)->name_en,
        ];

    }
}
