<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Otherbranch extends Model
{
    use SoftDeletes;

    public $table = 'otherbranches';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurants_id',
        'branch_name_ar',
        'branch_name_en',
        'branch_address_ar',
        'branch_address_en',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function restaurants()
    {
        return $this->belongsTo(Restaurant::class, 'restaurants_id');
    }
}
