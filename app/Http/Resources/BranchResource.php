<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class BranchResource extends JsonResource
{
    public function toArray($request)
    {
        if ( App::getLocale() == 'ar') {
            $branch_name = $this->branch_name_ar ;
            $branch_address = $this->branch_address_ar ;
        }else {
            $branch_name = $this->branch_name_en ;
            $branch_address = $this->branch_address_en ;
        }

        return [
            'id' => $this->id,
            'phone' => $this->phone ,
            'email' => $this->email ,
            'branch_name' => $branch_name ,
            'branch_address' => $branch_address,

        ];
    }
}
