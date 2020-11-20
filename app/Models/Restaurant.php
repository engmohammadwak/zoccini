<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class Restaurant extends Model
{
    use SoftDeletes;

    public $table = 'restaurants';

    protected $dates = [
        'end_date_subscription',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'mins',
        'delivery_id',
        'tag',
        'address',
        'opening_time',
        'description',
        'lat',
        'lang',
        'number_of_employees',
        'number_branches',
        'subscription_package',
        'end_date_subscription',
        'country_id',
        'city_id',
        'agree_terms_of_use',
        'min_price',
        'rating',
        'fast_delivery',
        'number_rate',
        'open_time',
        'close_time',
        'min_waiting',
        'max_waiting',
        'file_size_used',
        'created_at',
        'updated_at',
        'deleted_at',
        'image',
        'commercial_registration_image',
        'identity_card_image',
        'company_seal',
        'other_image',
    ];




    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function restaurant()
    {
        return $this->belongsTo(User::class, 'restaurant_id');
    }


    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function payment_methods()
    {
        return $this->belongsToMany(PaymentMethod::class);
    }

    public function sitting_areas()
    {
        return $this->belongsToMany(SittingArea::class);
    }

    public function getEndDateSubscriptionAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateSubscriptionAttribute($value)
    {
        $this->attributes['end_date_subscription'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function items(){
        return $this->hasMany(Item::class, 'restaurant_id', 'id')->where('status' , '1');
    }

}
