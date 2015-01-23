<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaFacultadad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_facultad', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('codigo', 5)->unique();
			$tabla->string('facultad', 50);
			$tabla->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sb_facultad');
	}

}
