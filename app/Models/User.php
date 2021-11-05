<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'id'
    ];

    public $incrementing = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $user->id = IdGenerator::generate(['table' => 'users', 'length' => 11, 'prefix' => date('Yis')]);
        });
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wallet(){
        return $this->hasOne(Wallet::class);
    }

    //my functions
    public function getBalance()
    {
        return Wallet::select('balance')->where('user_id', $this->id)->get();
    }
}
