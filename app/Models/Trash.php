<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Trash extends Model
{
    use HasFactory;

    protected $fillable = [
        'trash_category_id',
        'name',
        'points',
        'unit',
        'image'
    ];


    const TRASHES_IMG_PATH = 'trashes';

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::remove(self::TRASHES_IMG_PATH, $value);
    }

    public function getImageAttribute($value)
    {
        return self::TRASHES_IMG_PATH . '/' . $value;
    }

    public function getSmugId()
    {
        return sprintf('T-%04d', $this->id);
    }

    public function trashCategory()
    {
        return $this->belongsTo(TrashCategory::class);
    }

    public function collects()
    {
        return $this->belongsToMany(Collect::class)->withPivot(['quantity']);
    }
}
