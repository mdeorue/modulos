<?php

class Facultad extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_facultad';

	protected $fillable = array('codigo', 'facultad');

	public function alumnos(){
		return $this->hasMany('Alumno', 'facultad');
	}

	public function carreras(){
		return $this->hasMany('Carrera', 'facultad');
	}

	public function asignaturas(){
		return $this->hasMany('Asignatura', 'facultad');
	}

}
