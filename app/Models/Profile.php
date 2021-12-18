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

    const AVATARS_IMG_PATH = 'img/avatar';

    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = Str::remove(self::AVATARS_IMG_PATH, $value);
    }

    public function getAvatarAttribute($value)
    {
        return file_exists(public_path(self::AVATARS_IMG_PATH . '/' . $value)) && !empty($value)
            ? url(self::AVATARS_IMG_PATH . '/' . $value)
            : url('img/tp-avatar.jpg');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    //my functions

    public function fullname()
    {
        $fullname = $this->firstname . " " .
            ($this->middlename ? $this->middlename . " " : '') .
            $this->lastname;

        return $fullname;
    }
}
