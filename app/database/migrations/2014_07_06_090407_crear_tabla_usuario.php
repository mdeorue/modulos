<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sb_usuario', function($tabla){
			$tabla->engine = 'InnoDB';

			$tabla->increments('id');
			$tabla->string('rut', 12)->unique();
			$tabla->string('usuario', 30);
			$tabla->integer('categoria');
			$tabla->text('password');
			$tabla->string('email', 40);
			$tabla->text('remember_token');
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
		Schema::drop('sb_usuario');
	}

}
