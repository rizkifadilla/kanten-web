<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
        });

        // Insert the Parent Column
        DB::table('transaction_types')->insert(
            array(
                'type' => 'Top Up'
            )
        );
        DB::table('transaction_types')->insert(
            array(
                'type' => 'Pembayaran'
            )
        );
        DB::table('transaction_types')->insert(
            array(
                'type' => 'Transfer'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_types');
    }
}
