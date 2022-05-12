<?php

namespace App\Http\Resources;

use App\Models\Address;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class OrderRestaurantDetailsResource extends JsonResource
{
    public function toArray($request)
    {

        if (App::getLocale() == 'ar')
        {
            if ($this['payment_method'] == 1)
            {
                $paymet = 'كاش';
            }else{
                $paymet = 'فيزا';
            }
        }else{
            if ($this['payment_method'] == 1)
            {
                $paymet = 'cash';
            }else{
                $paymet = 'visa';
            }
        }

        $queues = Queue::where('restaurant_id' , $this->restaurants_id)->get();
        $queueIndex = $queues->search(function($queue ) {
            return $queue->order_id === $this->id;
        });

        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'number_people' => $this->number_people,
            'sitting_area_id' => new SittingAreasResource($this->sitting_area),
            'schedule_date' => $this->schedule_date != '' ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $this->schedule_date)->format('d/m/Y  h:i A') : '',
            'created_at' => $this->created_at != '' ? $this->created_at->translatedFormat('d/m/Y  h:i A') : '',
            'time' => $this->created_at != '' ? $this->created_at->translatedFormat('h:i A') : '',
            'date' => $this->created_at != '' ? $this->created_at->translatedFormat('d/m/Y') : '',
            'sat_time' => $this->schedule_date != '' ? $this->schedule_date->translatedFormat('h:i A') : '',
            'sat_date' => $this->schedule_date != '' ? $this->schedule_date->translatedFormat('d/m/Y') : '',
            'status_id' => $this->status_id,
            'status_name' => App::getLocale() == 'ar' ? $this->status->name_ar : $this->status->name_en,
            'price' => $this->price,
            'vat' => $this->vat . '%',
            'application_services' => $this->Application_services,
            'discount_Application_services' => $this->Discount_Application_services . '%',
            'final_price' => $this->final_price,
            'payment_method' => $paymet,
            'address' => new AddressResource($this->address),
            'item' => OrderItemResource::collection($this->items),
            'role' => $queueIndex == false ? 0 : $queueIndex + 1,
            'car' => new CarListResource($this->car_number),
            'table_num' => optional($this->table_data)->number,

        ];
    }
}
