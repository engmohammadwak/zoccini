<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Coupon extends Model
{
    use SoftDeletes;

    public $table = 'coupons';


    const TYPE_SELECT = [
        '0' => 'Fixed',
        '1' => 'percent',
    ];

    const STATUS_SELECT = [
        '0' => 'inactive',
        '1' => 'active',
    ];

    protected $dates = [
        'start_day',
        'end_day',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'value',
        'status',
        'maximum_usage',
        'start_day',
        'end_day',
        'type',
        'number_used',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getStartDayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDayAttribute($value)
    {
        $this->attributes['start_day'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDayAttribute($value)
    {
        $this->attributes['end_day'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
