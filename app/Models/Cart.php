<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function getSmugId()
    {
        return sprintf('C-%04d', $this->id);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

}
