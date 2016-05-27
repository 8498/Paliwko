<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('stations', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('name');
    		$table->float('latitude');
    		$table->float('longtitude');
    		$table->rememberToken();
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
    	Schema::drop('stations');
    }
}
