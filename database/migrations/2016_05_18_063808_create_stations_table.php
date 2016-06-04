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
    		$table->double('LPG');
    		$table->double('ON');
    		$table->double('PB95');
    		$table->double('PB98');
    		$table->string('verify');
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
