<?php

namespace App\Http\Resources;

use App\Models\Extra;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ExtraOrderResource extends JsonResource
{
    public function toArray($request)
    {
          $extra = Extra::find($this->extra_id);
        return [
            'id' => $this->extra_id,
            'name' => $extra->name,
            'quantity' => (int) $this->count ,
            'final_price' => (double) $this->final_price ,
        ];
    }

}
