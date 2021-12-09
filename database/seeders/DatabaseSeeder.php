<?php

namespace Database\Seeders;

use App\Models\Collect;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Trash;
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
            $products = Product::inRandomOrder()->take(rand(1,3))->get(['id', 'price']);
            foreach ($products as $product){
                $order->products()->attach($product->id, ['quantity' => rand(1,10), 'price' => $product->price]);
            }
        }

        foreach(Collect::all() as $collect){
            $trashes = Trash::inRandomOrder()->take(rand(4,7))->get(['id', 'points']);
            foreach($trashes as $trash){
                $collect->trashes()->attach($trash->id, ['quantity' => rand(10,30), 'points' => $trash->points]);
            }
        }

        foreach(Transaction::all() as $transaction){
            $products = Product::inRandomOrder()->take(rand(1,3))->get(['id', 'price']);
            foreach ($products as $product){
                $transaction->products()->attach($product->id, ['quantity' => rand(10,30), 'price' => $product->price]);
            }
        }

    }
}
