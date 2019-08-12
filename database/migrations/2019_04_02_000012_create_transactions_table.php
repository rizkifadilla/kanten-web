<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender');
            $table->unsignedBigInteger('recepient');
            $table->unsignedBigInteger('type');
            $table->unsignedBigInteger('client');
            $table->integer('balanceUsed');
            $table->foreign('sender')->references('id')->on('users');
            $table->foreign('recepient')->references('id')->on('users');
            $table->foreign('type')->references('id')->on('transaction_types');
            $table->foreign('client')->references('id')->on('clients');
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
        Schema::dropIfExists('transactions');
    }
}
