<?php

class BecaAsignatura extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_beca_asignatura';

	protected $fillable = array('matricula', 'asignatura');

	public function alumno(){
		return $this->belongsTo('Alumno', 'matricula', 'matricula');
	}

	public function asignatura(){
		return $this->belongsTo('Asignatura', 'asignatura', 'codigo');
	}

}
