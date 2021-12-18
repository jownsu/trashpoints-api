<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

   protected $fillable = [
       'product_category_id',
       'name',
       'description',
       'information',
       'price',
       'image'
   ];



    const PRODUCTS_IMG_PATH = 'products';

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::PRODUCTS_IMG_PATH, $value);
    }

    public function getImageAttribute($value)
    {
        return file_exists(public_path('img/' . self::PRODUCTS_IMG_PATH . '/' . $value)) && !empty($value)
            ? url('img/' . self::PRODUCTS_IMG_PATH . '/' . $value)
            : url('img/tp-logo.png');
    }

    public function getSmugId()
    {
        return sprintf('P-%04d', $this->id);
    }

/*    public function orders()
    {
        return $this->hasMany(Order::class);
    }*/

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class)->withPivot(['quantity', 'price']);
    }
}
