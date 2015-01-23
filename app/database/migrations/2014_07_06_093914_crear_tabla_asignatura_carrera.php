<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAsignaturaCarrera extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_asignatura_carrera', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('asignatura', 7);
			$tabla->integer('carrera')->unsigned();
			$tabla->timestamps();

			$tabla->foreign('asignatura')
      			->references('codigo')->on('sb_asignatura')
      			->onDelete('cascade')
      			->onUpdate('cascade');

      		$tabla->foreign('carrera')
      			->references('id')->on('sb_carrera')
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
		Schema::drop('sb_asignatura_carrera');
	}

}
