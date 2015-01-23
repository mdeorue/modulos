<?php

class Prioridad extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_prioridad';

	protected $fillable = array('texto', 'prioridad');

}
