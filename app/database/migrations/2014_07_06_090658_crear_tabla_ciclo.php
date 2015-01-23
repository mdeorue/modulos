<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCiclo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_ciclo', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');			
			$tabla->integer('estado')->unsigned();
			$tabla->timestamps();

			$tabla->foreign('estado')
      			->references('id')->on('sb_estado_ciclo')
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
		Schema::drop('sb_ciclo');
	}

}
