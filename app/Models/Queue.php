<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Queue extends Model
{
    use SoftDeletes;

    public $table = 'queue';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
//type ['inside' => '1' , 'outside' =>'2']
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'order_id',
        'type',
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

    public function restaurant()
    {
        return $this->belongsTo(User::class, 'restaurant_id');
    }
}
