<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Image extends Model
{
    use SoftDeletes;

    public $table = 'images';
    public const COMPANY_MODEL = 'company';

    protected $appends = [
        'image_url',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'model',
        'item',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'model',
        'item',
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
        return is_null($this->name) ? "" : assetUpload(self::COMPANY_MODEL . '/' . $this->name);
    }

}
