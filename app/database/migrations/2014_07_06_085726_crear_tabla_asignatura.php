<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAsignatura extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_asignatura', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('codigo', 7)->unique();
			$tabla->string('asignatura', 60);
			$tabla->integer('nivel');
			$tabla->integer('facultad')->unsigned();
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
		//
	}

}
