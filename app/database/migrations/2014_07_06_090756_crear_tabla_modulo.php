<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaModulo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_modulo', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->integer('ciclo')->unsigned();
			$tabla->string('modulo', 5);
			$tabla->string('profesor', 12);
			$tabla->integer('asignatura')->unsigned();
			$tabla->integer('capacidad')->default(4);
			$tabla->integer('horario_dia');
			$tabla->integer('horario_hora');
			$tabla->integer('horario_hora_fin');
			$tabla->date('inicio');
			$tabla->timestamps();

			$tabla->foreign('ciclo')
      			->references('id')->on('sb_ciclo')
      			->onDelete('cascade')
      			->onUpdate('cascade');

      		$tabla->foreign('profesor')
      			->references('rut')->on('sb_usuario')
      			->onDelete('cascade')
      			->onUpdate('cascade');

      		$tabla->foreign('asignatura')
      			->references('id')->on('sb_asignatura')
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
		Schema::drop('sb_modulo');
	}

}
