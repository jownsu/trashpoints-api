<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectTrashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collect_trash', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collect_id',)->references('id')->on('collects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('trash_id')->references('id')->on('trashes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('quantity')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collect_trash');
    }
}
