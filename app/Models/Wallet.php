<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //my functions

    public function addPoints($points){
        $this->balance += $points;
        return $this->save() ? true : false;
    }

    //static functions

    public static function getWalletByUser($user_id)
    {
        return self::where('user_id', $user_id)->first();
    }

}
