<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('transactionId');
            $table->unsignedBigInteger('inventoriesId');
            $table->integer('inventoriesQty');
            $table->foreign('transactionId')->references('id')->on('transactions');
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
        Schema::dropIfExists('shop_transactions');
    }
}
