<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SlideShowResource extends JsonResource
{

    public function toArray($request)
    {
        if ($this->type == 'image'){
            $resource = url('local/public/img/slidshow/' . $this->image);
        }else{
            $resource = $this->video_url;
        }


        return [
            'id' => $this->id,
            'type' => $this->type ?? '',
            'resource' => $resource ?? '',
            'product_restaurant' => $this->product_restaurant != 0 ? $this->product_restaurant == 1 ? 'restaurant' : 'product' : '',
            'product_restaurant_id' => $this->product_restaurant_id ?? '',
        ];
    }
}
