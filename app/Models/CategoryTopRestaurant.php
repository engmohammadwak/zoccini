<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Support\Facades\App;

class CategoryTopRestaurant extends Model
{
    use SoftDeletes;

    public $table = 'category_top_restaurants';

    protected $appends = [
        'name',

    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name_ar',
        'name_en',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getNameAttribute($value)
    {
        return App::getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
}
