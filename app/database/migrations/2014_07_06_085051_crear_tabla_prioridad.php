<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPrioridad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_prioridad', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('texto', 10);
			$tabla->integer('prioridad');
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
		Schema::drop('sb_prioridad');
	}

}
