<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class VentureCompany extends Model
{
    use SoftDeletes;

    public $table = 'venture_companies';

    public const DIR_UPLOAD = 'venture_companies';

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
