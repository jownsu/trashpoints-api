<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'contact_no',
        'address',
        'avatar'
    ];

    const AVATARS_IMG_PATH = 'avatar';

    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = Str::remove(self::AVATARS_IMG_PATH, $value);
    }

    public function getAvatarAttribute($value)
    {
        if($value){
            return self::AVATARS_IMG_PATH . '/' . $value;
        }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
