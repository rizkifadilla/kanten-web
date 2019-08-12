<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('userId')->unique();
            $table->primary('userId');
            $table->foreign('userId')->references('id')->on('users');
            $table->unsignedBigInteger('userType');
            $table->foreign('userType')->references('id')->on('roles');
        });

        DB::table('user_roles')->insert(
            array(
                'userId' => 1,
                'userType' => 1,
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
