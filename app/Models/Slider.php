<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Slider extends Model
{
    use SoftDeletes;

    public $table = 'sliders';

    public const DIR_UPLOAD = 'slider';

    protected $appends = [
        'image_url',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'image',
        'title',
        'body',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getImageUrlAttribute($value)
    {
        return is_null($this->image) ? "" : assetUpload(self::DIR_UPLOAD . '/' . $this->image);
    }
}
