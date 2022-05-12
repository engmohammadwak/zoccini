<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Item extends Model
{
    use SoftDeletes;


    public $table = 'items';

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
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'price',
        'photo',
        'status',
        'restaurant_id',
        'category_id',
        'sale_count',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function extra(){
        return $this->hasMany(Extra::class, 'item_id', 'id')->where('status' , 1);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }


    public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query
                ->where('name_ar', 'LIKE', '%' . $value . '%')
                ->orWhere('name_en', 'LIKE', '%' . $value . '%');
        });
    }

}
