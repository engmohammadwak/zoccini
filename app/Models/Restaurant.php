<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class Restaurant extends Model
{
    use SoftDeletes;

    public $table = 'restaurants';
    public const DIR_UPLOAD = 'restaurants';
    protected $appends = [
        'image_url',
        'commercial_registration_image_url',
        'identity_card_image_url',
        'company_seal_url',
        'name',
        'description_translate',
    ];
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
        'visits',
        'main_restaurant',
        'delivery_support',
        'offer',
        'car_delivery_support',
        'number_order_automatically',
        'company_email',
        'phone_company',
        'have_tablet',
        'referral_id',
        'plan_id',
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

    public function items()
    {
        return $this->hasMany(Item::class, 'restaurant_id', 'id')->where('status', '1');
    }

    public function branch()
    {
        return $this->hasMany(Otherbranch::class, 'restaurants_id', 'id');
    }

    public function media()
    {
        return $this->hasMany(Image::class, 'item', 'id')->where('model', Image::COMPANY_MODEL);
    }

    public function rate()
    {
        return $this->hasMany(Rate::class, 'restaurant_id', 'id');
    }

    public function queue_inside()
    {
        return $this->hasMany(Queue::class, 'restaurant_id', 'restaurant_id')->where('type', 1)->count('id');
    }

    public function queue_outside()
    {
        return $this->hasMany(Queue::class, 'restaurant_id', 'restaurant_id')->where('type', 2)->count('id');
    }

    public function getImageUrlAttribute($value)
    {
        return is_null($this->image) ? "" : assetUpload(self::DIR_UPLOAD . '/' . $this->image);
    }

    public function getCommercialRegistrationImageUrlAttribute($value)
    {
        return is_null($this->commercial_registration_image) ? "" : assetUpload(self::DIR_UPLOAD . '/' . $this->commercial_registration_image);
    }

    public function getIdentityCardImageUrlAttribute($value)
    {
        return is_null($this->identity_card_image) ? "" : assetUpload(self::DIR_UPLOAD . '/' . $this->identity_card_image);
    }

    public function getCompanySealUrlAttribute($value)
    {
        return is_null($this->company_seal) ? "" : assetUpload(self::DIR_UPLOAD . '/' . $this->company_seal);
    }

    public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query
                ->where('name_ar', 'LIKE', '%' . $value . '%')
                ->orWhere('name_en', 'LIKE', '%' . $value . '%');
        });
    }


    public function scopeActive($query)
    {
        $query->whereHas('restaurant', function ($query) {
            $query->where('status_id', 1);
        });
    }

    public function getNameAttribute($value)
    {
        return App::getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getDescriptionTranslateAttribute($value)
    {
        return App::getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'plan_id' , 'id');
    }
}
