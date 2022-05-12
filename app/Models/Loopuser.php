<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loopuser extends Model
{
    use SoftDeletes;

    public const VERIFICATION_TYPE_SELECT = [
        '0' => 'verification id',
        '1' => 'passboard id',
    ];

    public $table = 'loopusers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'country_id',
        'city_id',
        'user_id',
        'verification_type',
        'national',
        'expire_date',
        'attach_national',
        'invoice_image',
        'created_at',
        'updated_at',
        'deleted_at',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function bank()
    {
        return $this->hasOne(LoopBank::class, 'user_id');
    }

    public function referral_subscription()
    {
        return $this->hasOne(ReferralSubscription::class, 'user_loop_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
