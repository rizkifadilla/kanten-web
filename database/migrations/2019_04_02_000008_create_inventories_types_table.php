<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
        });

        // Insert the Parent Column
        DB::table('inventories_types')->insert(
            array(
                'type' => 'Limited'
            )
        );
        DB::table('inventories_types')->insert(
            array(
                'type' => 'Always Available'
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
        Schema::dropIfExists('inventories_types');
    }
}
