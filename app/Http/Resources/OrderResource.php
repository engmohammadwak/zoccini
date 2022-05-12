<?php

namespace App\Http\Resources;

use App\Models\Address;
use App\Models\Point;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class OrderResource extends JsonResource
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

        $total = Point::where('user_id', Auth::id())->where('type_id' ,'!=' ,  4)->sum('value');
        $spent = Point::where('user_id', Auth::id())->where('type_id' ,  4)->sum('value');

        $queues = Queue::where('restaurant_id' , $this->restaurants_id)->get();
        $queueIndex = $queues->search(function($queue ) {
            return $queue->order_id === $this->id;
        });

        return [
            'id' => $this->id,
            'restaurant' => new RestaurantSimpleResource($this->restaurants),
            'number_people' => $this->number_people,
            'sitting_area_id' => new SittingAreasResource($this->sitting_area),
//            'schedule_date' => $this->schedule_date != '' ? $this->schedule_date->translatedFormat('d/m/Y  h:i A') : '',
            'schedule_date' => $this->schedule_date != '' ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $this->schedule_date)->format('d/m/Y  h:i A') : '',
            's_date' => $this->schedule_date != '' ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $this->schedule_date)->format('d/m/Y') : '',
            's_time' => $this->schedule_date != '' ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $this->schedule_date)->format('h:i A') : '',
            'created_at' => $this->created_at != '' ? $this->created_at->translatedFormat('d/m/Y  h:i A') : '',
            'status_id' => (int) $this->status_id,
            'status_name' => App::getLocale() == 'ar' ? optional($this->status)->name_ar : optional($this->status)->name_en,
            'price' => round($this->price, 2),
            'vat' => $this->vat . '%',
            'application_services' => $this->Application_services,
            'discount_Application_services' => $this->Discount_Application_services . '%',
            'final_price' => number_format((float)$this->final_price, 2, '.', ''),
            'payment_method' => $paymet,
            'address' => new AddressResource($this->address),
            'role' => $queueIndex == false ? 0 : $queueIndex + 1,
            'coin' => ($total - $spent) / getSetting('point_price'),
            'is_rate' => isRate($this->id),
            'item' => OrderItemResource::collection($this->items),
            'type' => $this->type_id,
            'delivery_company' => new DeliveryCompanyResource($this->delivery_company),

        ];
    }
}
