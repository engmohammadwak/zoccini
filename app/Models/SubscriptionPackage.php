<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class SubscriptionPackage extends Model
{
    use SoftDeletes;

    public $table = 'subscription_packages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'name_en',
        'description',
        'description_en',
        'price',
        'duration',
        'number_branches',
        'percentage_of_sales',
        'created_at',
        'updated_at',
        'deleted_at',
        'referral_price',
        'offer',
        'have_map',
        'currency_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

}
