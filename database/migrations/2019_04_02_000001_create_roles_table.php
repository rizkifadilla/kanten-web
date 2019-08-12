<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
        });

        // Insert the Parent Column
        DB::table('roles')->insert(
            array(
                'type' => 'Admin'
            )
        );
        DB::table('roles')->insert(
            array(
                'type' => 'Seller'
            )
        );
        DB::table('roles')->insert(
            array(
                'type' => 'User'
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
        Schema::dropIfExists('roles');
    }
}
