<?php

namespace Database\Seeders;

use App\Models\Collect;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->has(Profile::factory(1))
            ->has(Wallet::factory(1))
            ->has(Order::factory(2))
            ->has(Collect::factory(7))
            ->has(Transaction::factory(2))
            ->create();
    }
}
