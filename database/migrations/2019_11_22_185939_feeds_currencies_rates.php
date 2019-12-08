<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FeedsCurrenciesRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('name');
			$table->string('url');
			$table->timestamps();
        });

		Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('name');
			$table->string('code')->index();
			$table->timestamps();
        });

		Schema::create('rates', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('currency_id_from')->unsigned();
			$table->integer('currency_id_to')->unsigned();
			$table->decimal('rate', 30, 16);
			$table->timestamps();
			$table->timestamp('refreshed_at')->nullable();

			$table->foreign('currency_id_from')
                ->references('id')->on('currencies')
                ->onDelete('cascade')
            ;
			$table->foreign('currency_id_to')
                ->references('id')->on('currencies')
                ->onDelete('cascade')
            ;
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

        Schema::dropIfExists('feeds');
		Schema::dropIfExists('currencies');
		Schema::dropIfExists('rates');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
