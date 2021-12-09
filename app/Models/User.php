<?php

namespace App\Models;

use App\Http\Resources\GagoResource;
use App\Http\Resources\User\WalletResource;
use App\Traits\UserPointsTracker;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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

    public function getTotalSpent()
    {
        $total = $this->where('user_id', $this->id)
                    ->select(DB::raw('SUM(product_transaction.quantity * product_transaction.price) as total_spent'))
                    ->join('transactions', 'users.id', '=', 'transactions.user_id')
                    ->join('product_transaction', 'transactions.id', '=', 'product_transaction.transaction_id')
                    ->groupBy('users.id')
                    ->first();

        return $total->total_spent ?? 0;
    }

    public function getTotalEarned()
    {
        $total = $this->where('user_id', $this->id)
                    ->select(DB::raw('SUM(collect_trash.quantity * collect_trash.points) as total_earned'))
                    ->join('collects', 'users.id', '=', 'collects.user_id')
                    ->join('collect_trash', 'collects.id', '=', 'collect_trash.collect_id')
                    ->groupBy('users.id')
                    ->first();

        return $total->total_earned ?? 0;
    }

    public function getTotalPending()
    {
        $total = $this->where('user_id', $this->id)
                    ->select(DB::raw('SUM(order_product.quantity * order_product.price) as total_pending'))
                    ->join('orders', 'users.id', '=', 'orders.user_id')
                    ->join('order_product', 'orders.id', '=', 'order_product.order_id')
                    ->groupBy('users.id')
                    ->first();

        return $total->total_pending ?? 0;
    }

    public function getWallet()
    {
        $total_earned = $this->getTotalEarned();
        $total_spent = $this->getTotalSpent();
        $total_pending = $this->getTotalPending();
        $balance = $total_earned - ( $total_spent + $total_pending );

        return [
            'total_earned'  => $total_earned,
            'total_spent'   => $total_spent,
            'total_pending' => $total_pending,
            'balance'       => $balance
        ];
    }

    public function is_admin()
    {
        return $this->is_admin;
    }
}
