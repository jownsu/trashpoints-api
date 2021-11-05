<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrashCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    const TRASH_CATEGORY_IMG_PATH = 'trash_categories';

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::TRASH_CATEGORY_IMG_PATH, $value);
    }

    public function getImageAttribute($value)
    {
        return self::TRASH_CATEGORY_IMG_PATH . '/' . $value;
    }

    public function trashes()
    {
        return $this->hasMany(Trash::class);
    }
}
