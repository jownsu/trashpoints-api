<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    const PRODUCT_CATEGORY_IMG_PATH = 'img/product_categories';

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::PRODUCT_CATEGORY_IMG_PATH, $value);
    }

    public function getImageAttribute($value)
    {
        return file_exists(public_path(self::PRODUCT_CATEGORY_IMG_PATH . '/' . $value)) && !empty($value)
            ? url(self::PRODUCT_CATEGORY_IMG_PATH . '/' . $value)
            : url('img/tp-logo.png');
    }

    public function getSmugId()
    {
        return sprintf('PC-%04d', $this->id);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
