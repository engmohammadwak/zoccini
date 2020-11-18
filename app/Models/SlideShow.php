<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class SlideShow extends Model
{
    use SoftDeletes;

    public $table = 'slide_shows';


    const STATUS_RADIO = [
        '0' => 'inactive',
        '1' => 'active',
    ];

    const TYPE_SELECT = [
        'image' => 'image',
        'video' => 'video',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'video_url',
        'status',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
