<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\OfferUser;
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
            'category' => $category ,
            'restaurant' => $this->restaurant ? new RestaurantSimpleResource($this->restaurant) : '' ,
            $this->mergeWhen($this->category_id == '1', [
                'description' => $description ,
                'number_requests' => (int) $this->number_requests ,
                'voucher_number' => $this->voucher_number,
                'winner' => optional($this->winner)->name.' '.optional($this->winner)->last_name ,
                'withdraw_day' => $this->withdraw_day ,
                'number_join' => number_join_offer($this->id) ,
                'ratio_hundred' => ($this->number_requests * (OfferUser::where('offer_id' , $this->id)->count() / 100)) * 100,
            ]),
            $this->mergeWhen($this->category_id == '2', [
                'discount' => $this->discount,
            ]),
            $this->mergeWhen($this->category_id == '1' || $this->category_id == '3', [
                'image' => url('local/public/img/ads/' . $this->image) ,
            ]),
        ];
    }
}
