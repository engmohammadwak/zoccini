<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class CarList extends Model
{
    use SoftDeletes;

    public $table = 'car_lists';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'car_brand_id',
        'car_type_id',
        'car_color_id',
        'user_id',
        'pate_number',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function car_brand()
    {
        return $this->belongsTo(Carbrand::class, 'car_brand_id');
    }

    public function car_type()
    {
        return $this->belongsTo(TypeOfCar::class, 'car_type_id');
    }

    public function car_color()
    {
        return $this->belongsTo(CarColor::class, 'car_color_id');
    }
}
