<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class AllAd extends Model
{
    use SoftDeletes;

    public $table = 'all_ads';

    const STATUS_RADIO = [
        '0' => 'inactive',
        '1' => 'active',
    ];

    protected $dates = [
        'withdraw_day',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurant_id',
        'description_ar',
        'description_en',
        'number_requests',
        'voucher_number',
        'category_id',
        'discount',
        'winner_id',
        'withdraw_day',
        'created_at',
        'updated_at',
        'deleted_at',
        'image',
        'status',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function category()
    {
        return $this->belongsTo(AdsCategory::class, 'category_id');
    }


    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function getWithdrawDayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setWithdrawDayAttribute($value)
    {
        $this->attributes['withdraw_day'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
