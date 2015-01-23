<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCarrera extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_carrera', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->text('carrera', 50);
			$tabla->integer('facultad')->unsigned();
			$tabla->timestamps();

			$tabla->foreign('facultad')
      			->references('id')->on('sb_facultad')
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
		Schema::drop('sb_carrera');
	}

}
