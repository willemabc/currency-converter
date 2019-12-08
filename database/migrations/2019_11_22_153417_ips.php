<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Ips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('ips', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('from')->index();
			$table->string('to')->index();
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
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('ips');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
