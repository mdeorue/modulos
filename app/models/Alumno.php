<?php

class Alumno extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_alumno';

	protected $fillable = array('matricula', 'alumno', 'ingreso', 'prioridad', 'facultad', 'carrera', 'grupo');

	public function carrera(){
		return $this->belongsTo('Carrera', 'carrera');
	}

	public function facultad(){
		return $this->belongsTo('Facultad', 'facultad');
	}

	public function prioridad(){
		return $this->belongsTo('Prioridad', 'prioridad');
	}

	public function solicitud(){
		return $this->hasMany('Solicitud', 'matricula', 'matricula');
	}

}
