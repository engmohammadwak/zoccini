<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class TicketMessageResource extends JsonResource
{
    public function toArray($request)
    {
        $created = new Carbon($this->created_at);
        $now = Carbon::now();

        $user = Auth::user()['id'];
        if ($user == $this->user_id){
            $data = true;
        }else{
            $data = false;

        }

        return [
            'id' => $this->id,
            'message' => $this->message,
            'sender' => $data,
            'created_at' => $created->diffForHumans($now),
        ];
    }
}
