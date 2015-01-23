<?php

class Modulo extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_modulo';

	protected $fillable = array('ciclo', 'modulo', 'profesor', 'asignatura', 'capacidad', 'horario_dia', 'horario_hora', 'horario_hora_fin', 'inicio', 'estado', 'sala', 'prioritario');

	public function asignatura(){
		return $this->belongsTo('Asignatura', 'asignatura');
	}

	public function profesor(){
		return $this->belongsTo('User', 'profesor');
	}

	public function ciclo(){
		return $this->belongsTo('Ciclo', 'ciclo');
	}

	public function solicitudes(){
		return $this->hasMany('Solicitud', 'modulo');
	}

}
