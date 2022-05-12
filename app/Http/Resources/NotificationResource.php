<?php


namespace App\Http\Resources;


use App\Repository\NotificationAppUserRepository;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Notification;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        $data = json_decode($this->data);
        return [
//            'id' => $this->id,
            'title' => isset($data->title) ? $data->title : '',
            'body' => isset($data->body) ? $data->body : '',
            'type' => null,
            'status' => null,
            'offer_id' => isset($data->offer) ? $data->offer : null,
            'order_id' => isset($data->order) ? $data->order : null,
//            'type' => isset($data->type) ? $data->type : '',
//            'status' => isset($data->status) ? $data->status : '',
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
