<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Address extends Model
{
    use SoftDeletes;

    public $table = 'addresses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nice_name',
        'area',
        'street',
        'building',
        'floor',
        'apartment_no',
        'additional_direction',
        'landing_number',
        'phone',
        'user_id',
        'lat',
        'lang',
        'main_address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
