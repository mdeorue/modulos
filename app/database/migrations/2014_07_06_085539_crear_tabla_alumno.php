<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAlumno extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_alumno', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('matricula', 12)->unique();
			$tabla->string('alumno', 50);
			$tabla->integer('ingreso');
			$tabla->string('email', 40)->unique();
			$tabla->integer('prioridad')->unsigned();
			$tabla->integer('facultad')->unsigned();
			$tabla->integer('carrera')->unsigned();
			$tabla->timestamps();

			$tabla->foreign('prioridad')
      			->references('id')->on('sb_prioridad')
      			->onDelete('cascade')
      			->onUpdate('cascade');

      		$tabla->foreign('facultad')
      			->references('id')->on('sb_facultad')
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
		Schema::drop('sb_alumno');	
	}

}
