<?php

class Asistencia extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_asistencia';

	protected $fillable = array('modulo', 'matricula', 'fecha', 'hora_asis', 'hora_clase');

	public function modulo(){
		return $this->belongsTo('Modulo', 'modulo');
	}

	public function alumno(){
		return $this->belongsTo('Alumno', 'matricula', 'matricula');
	}

}
