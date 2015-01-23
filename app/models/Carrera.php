<?php

class Carrera extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_carrera';

	protected $fillable = array('id', 'carrera', 'facultad');

	public function alumnos(){
		return $this->hasMany('Alumno', 'carrera');
	}

	public function asignaturas(){
		return $this->hasMany('AsignaturaCarrera', 'carrera');
	}

	public function facultad(){
		return $this->belongsTo('Facultad', 'facultad');
	}

}
