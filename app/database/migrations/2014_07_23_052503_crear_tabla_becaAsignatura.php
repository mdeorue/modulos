<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaBecaAsignatura extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_beca_asignatura', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('matricula', 12);
			$tabla->string('asignatura', 7);
			$tabla->timestamps();

			$tabla->foreign('matricula')
      			->references('matricula')->on('sb_alumno')
      			->onDelete('cascade')
      			->onUpdate('cascade');

      		$tabla->foreign('asignatura')
      			->references('codigo')->on('sb_asignatura')
      			->onDelete('cascade')
      			->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sb_beca_asignatura');
	}

}
