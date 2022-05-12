<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class TableResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'number' => $this->number,
            'chares' => $this->chares,
            'status_id' => $this->status_id,
            'status_name' => App::getLocale() == 'ar' ? $this->status->name_ar : $this->status->name_en,
//            'sitting_area_id' => new SittingAreasResource($this->sitting_area),

        ];
    }
}
