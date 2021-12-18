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

    const TRASH_CATEGORY_IMG_PATH = 'img/trash_categories';

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::TRASH_CATEGORY_IMG_PATH, $value);
    }

    public function getImageAttribute($value)
    {
        return file_exists(public_path(self::TRASH_CATEGORY_IMG_PATH . '/' . $value)) && !empty($value)
            ? url(self::TRASH_CATEGORY_IMG_PATH . '/' . $value)
            : url('img/tp-logo.png');
    }

    public function getSmugId()
    {
        return sprintf('TC-%04d', $this->id);
    }

    public function trashes()
    {
        return $this->hasMany(Trash::class);
    }
}
