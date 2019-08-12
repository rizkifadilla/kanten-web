<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecognizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recognizers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->unique();
        });

        // Insert the Parent Column
        DB::table('recognizers')->insert(
            array(
                'type' => 'Nomor Induk Siswa Nasional'
            )
        );
        DB::table('recognizers')->insert(
            array(
                'type' => 'Nomor Induk Kependudukan'
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
        Schema::dropIfExists('recognizers');
    }
}
