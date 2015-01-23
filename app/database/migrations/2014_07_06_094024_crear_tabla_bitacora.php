<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaBitacora extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_bitacora', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->integer('modulo')->unsigned();
			$tabla->text('bitacora');
			$tabla->date('fecha');
			$tabla->timestamps();

			$tabla->foreign('modulo')
      			->references('id')->on('sb_modulo');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sb_bitacora');
	}

}
