<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class AllAdResource extends JsonResource
{


    public function toArray($request)
    {
        if (App::getLocale() == 'ar') {
            $category = optional($this->category)->name_ar;
            $description = $this->description_ar;
        } else {
            $category = optional($this->category)->name_en;
            $description = $this->description_en;
        }
        return [
            'id' => $this->id,
            'category' => $category ?? '',
            'restaurant' => new RestaurantSimpleResource($this->restaurant) ?? '',
            $this->mergeWhen($this->category_id == '1', [
                'description' => $description ?? '',
                'number_requests' => $this->number_requests ?? '',
                'voucher_number' => $this->voucher_number ?? '',
                'winner' => $this->winner->name ?? '',
                'withdraw_day' => $this->withdraw_day ?? '',
                'image' => url('local/public/img/ads/' . $this->image) ?? '',
            ]),
            $this->mergeWhen($this->category_id == '2', [
                'discount' => $this->discount ?? '',
            ]),
        ];
    }
}
