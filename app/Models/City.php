<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Support\Facades\App;

class City extends Model
{
    use SoftDeletes;

    public $table = 'cities';

    protected $appends = [
        'name',
    ];

    const STATUS_RADIO = [
        '0' => 'inactive',
        '1' => 'active',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name_ar',
        'name_en',
        'countries_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'countries_id');
    }

    public function getNameAttribute($value)
    {
        return App::getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
}
