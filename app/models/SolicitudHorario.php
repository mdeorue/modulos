<?php

class SolicitudHorario extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_solicitud_horario';

	protected $fillable = array('asignatura', 'horario_dia', 'horario_hora', 'estado', 'matricula', 'ciclo');

	public function alumno(){
		return $this->belongsTo('Alumno', 'matricula', 'matricula');
	}

	public function asignatura(){
		return $this->belongsTo('Asignatura', 'codigo');
	}
}
