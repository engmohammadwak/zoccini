<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Table extends Model
{
    use SoftDeletes;

    public $table = 'tables';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurants_id',
        'number',
        'sitting_area_id',
        'chares',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sitting_area()
    {
        return $this->belongsTo(SittingArea::class, 'sitting_area_id');
    }

    public function status()
    {
        return $this->belongsTo(TableStatus::class, 'status_id');
    }
}
