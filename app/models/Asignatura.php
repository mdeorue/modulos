<?php

class Asignatura extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_asignatura';

	protected $fillable = array('codigo', 'asignatura', 'nivel', 'facultad', 'modulos');

	public function carreras(){
		return $this->belongsToMany('AsignaturaCarrera', 'codigo', 'asignatura', 'modulos');
	}

}
