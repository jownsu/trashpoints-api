<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->float('price')->default(1.00);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
