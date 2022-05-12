<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        $image = url('local/public/img/item/' . $this->photo);
        if ( App::getLocale() == 'ar') {
            $name        = $this->name_ar;
        }else {
            $name        = $this->name_en;
        }

        $extra =  DB::table('extra_order')
            ->where('order_id', $this->pivot->order_id)
            ->where('item_id', $this->id)
            ->get();

        return [
            'id' => $this->id,
            'name' => $name,
            'price' => (double) $this->pivot->price,
            'quantity' => (int) $this->pivot->count ,
            'final_price' => (double) $this->pivot->final_price ,
            'special_request' => $this->pivot->special_request ,
            'photo' => $image,
            'extra' => ExtraOrderResource::collection($extra),
        ];
    }
}
