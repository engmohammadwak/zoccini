<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Favorite extends Model
{
    use SoftDeletes;

    public $table = 'favorites';

    const TYPE_SELECT = [
        '0' => 'meals',
        '1' => 'restaurant',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'object_favority',
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

    public function item()
    {
        return $this->belongsTo(Item::class, 'object_favority');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'object_favority');
    }
}
