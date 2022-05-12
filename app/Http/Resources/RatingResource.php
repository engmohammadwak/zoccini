<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'user' => $this->user->name .' '.$this->user->last_name,
            'created_at' => $this->created_at != '' ? $this->created_at->translatedFormat('d M Y') : '',

        ];
    }
}
