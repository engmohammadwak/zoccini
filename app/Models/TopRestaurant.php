<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class TopRestaurant extends Model
{
    use SoftDeletes;

    public $table = 'top_restaurants';

    public const DIR_UPLOAD = 'top_restaurants';

    protected $appends = [
        'image_url',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'body',
        'image',
        'category_id',
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

    public function category()
    {
        return $this->belongsTo(CategoryTopRestaurant::class, 'category_id');
    }
}
