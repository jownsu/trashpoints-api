<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            TrashCategorySeeder::class,
            TrashSeeder::class
        ]);

        foreach(Order::all() as $order){
            $product = Product::inRandomOrder()->take(rand(1,7))->pluck('id');
            $order->products()->attach($product, ['quantity' => rand(1,20)]);
        }

    }
}
