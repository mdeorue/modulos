<?php

class Profesor extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_profesor';

	protected $fillable = array('matricula', 'profesor', 'password');

}
