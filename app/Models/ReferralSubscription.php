<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralSubscription extends Model
{
    use SoftDeletes;

    public $table = 'referral_subscriptions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'user_loop_id',
        'plan_id',
        'price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(Restaurant::class, 'user_id');
    }

    public function user_loop()
    {
        return $this->belongsTo(User::class, 'user_loop_id');
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'plan_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
