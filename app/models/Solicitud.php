<?php

class Solicitud extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_solicitud';

	protected $fillable = array('modulo', 'matricula', 'alumno', 'email', 'estado', 'mod_asig');

	public function modulo(){
		return $this->belongsTo('Modulo', 'modulo');
	}

	public function alumno(){
		return $this->belongsTo('Alumno', 'matricula', 'matricula');
	}
}
