<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';

    const DELIVERY_SELECT = [
        '0' => 'no',
        '1' => 'yes',
    ];

    const CAR_NUMBER_YES_SELECT = [
        '0' => 'no',
        '1' => 'yes',
    ];

    const SCHEDULE_REQUEST_SELECT = [
        '0' => 'no',
        '1' => 'yes',
    ];

    protected $dates = [
        'schedule_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'restaurants_id',
        'user_id',
        'type_id',
        'sitting_area_id',
        'number_people',
        'schedule_request',
        'schedule_date',
        'car_number_yes',
        'car_number',
        'delivery',
        'delivery_company_id',
        'status_id',
        'item_json',
        'cansel_reason_id',
        'cansel_reason_message',
        'winner_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function restaurants()
    {
        return $this->belongsTo(Restaurant::class, 'restaurants_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(OrderType::class, 'type_id');
    }

    public function sitting_area()
    {
        return $this->belongsTo(SittingArea::class, 'sitting_area_id');
    }

    public function getScheduleDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setScheduleDateAttribute($value)
    {
        $this->attributes['schedule_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function delivery_company()
    {
        return $this->belongsTo(DeliveryCompany::class, 'delivery_company_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function cansel_reason()
    {
        return $this->belongsTo(CanselReason::class, 'cansel_reason_id');
    }

    public function winner()
    {
        return $this->belongsTo(AllAd::class, 'winner_id');
    }
}
