<?php

class Configuracion extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_configuracion';

	protected $fillable = array('ins_pub');

}
