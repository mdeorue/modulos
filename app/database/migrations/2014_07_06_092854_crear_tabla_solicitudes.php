<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSolicitudes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_solicitud', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->integer('modulo')->unsigned();
			$tabla->string('matricula', 12);
			$tabla->integer('estado');
			$tabla->timestamps();

			$tabla->foreign('modulo')
      			->references('id')->on('sb_modulo');

      		$tabla->foreign('matricula')
      			->references('matricula')->on('sb_alumno');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sb_solicitud');
	}

}
