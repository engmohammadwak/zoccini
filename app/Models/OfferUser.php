<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class OfferUser extends Model
{
    // use SoftDeletes;
    public $table = 'offer_user';

    protected $appends = [
        'user_name',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
//status 1 Reservation order  2 confirm order
    protected $fillable = [
        'user_id',
        'order_id',
        'offer_id',
        'status',
        'winner',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function offer()
    {
        return $this->belongsTo(AllAd::class, 'offer_id');
    }

    public function getUserNAmeAttribute($value)
    {
//        return is_null($this->user_id) ? "" : );
        return 1;
    }
}
