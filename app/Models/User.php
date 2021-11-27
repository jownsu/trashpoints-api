<?php

namespace App\Models;

use App\Http\Resources\GagoResource;
use App\Http\Resources\User\WalletResource;
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

    public function getSmugId()
    {
        return sprintf('TP-%04d', $this->id);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function collects()
    {
        return $this->hasMany(Collect::class);
    }

    public function trashes()
    {
        return $this->hasManyThrough(CollectTrash::class, Collect::class);
    }


    //my functions
/*    public function getBalance()
    {
        return Wallet::select('balance')->where('user_id', $this->id)->get();
    }*/

    public function totalEarnedPoints()
    {
        $trashes = $this->load('collects.trashes');

        $trashPoints = $trashes->collects->map(function($collection){
            return $collection->trashes->map(function($item){
                return $item->points * $item->pivot->quantity;
            })->sum();
        })->sum();

        return $trashPoints;
    }

    public function totalRedeemedPoints(){
        $trashes = $this->load('transactions.products');

        $trashPoints = $trashes->transactions->map(function($collection){
            return $collection->products->map(function($item){
                return $item->price * $item->pivot->quantity;
            })->sum();
        })->sum();

        return $trashPoints;
    }

    public function balance()
    {
        return $this->totalEarnedPoints() - $this->totalRedeemedPoints();
    }

    public function is_admin()
    {
        return $this->is_admin;
    }
}
