<?php

namespace App\Http\Resources;

use App\Models\OfferUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class AllAdWinnerResource extends JsonResource
{

    public function toArray($request)
    {
        if (App::getLocale() == 'ar') {
            $description = $this->description_ar;
        } else {
            $description = $this->description_en;
        }
        return [
            'id' => $this->id,
            'description' => $description,
            'number_requests' => (int)$this->number_requests,
            'voucher_number' => $this->voucher_number,
            'winner' => optional($this->winner)->name . ' ' . optional($this->winner)->last_name,
            'withdraw_day' => $this->withdraw_day,
            'number_join' => OfferUser::where('offer_id', $this->id)->count(),

        ];
    }
}
