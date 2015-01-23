<?php

class AsignaturaCarrera extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_asignatura_carrera';

	protected $fillable = array('asignatura', 'carrera');

	public function carrera(){
		return $this->belongsTo('Carrera', 'carrera');
	}

	public function asignatura(){
		return $this->belongsTo('Asignatura', 'asignatura');
	}

}
