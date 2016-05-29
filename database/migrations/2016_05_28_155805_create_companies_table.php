<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('name');
    		$table->string('color');
    		$table->rememberToken();
    		$table->timestamps();
    	});
        
        Schema::create('company_station', function (Blueprint $table) {
        	$table->integer('station_id')->unsigned();
            $table->integer('company_id')->unsigned();

            $table->foreign('station_id')->references('id')->on('stations')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['station_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company_station');
        Schema::drop('companies');
    }
}
