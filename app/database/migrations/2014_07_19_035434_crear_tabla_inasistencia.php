<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInasistencia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_eliminacion', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->integer('solicitud')->unsigned();
			$tabla->integer('motivo');
			$tabla->timestamps();

			$tabla->foreign('solicitud')
      			->references('id')->on('sb_solicitud')
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
		Schema::drop('sb_eliminacion');
	}

}
