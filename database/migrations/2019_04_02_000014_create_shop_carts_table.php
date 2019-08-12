<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('orderId');
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('inventoriesId');
            $table->integer('inventoriesQty');
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('inventoriesId')->references('id')->on('inventories');
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
        Schema::dropIfExists('shop_carts');
    }
}
