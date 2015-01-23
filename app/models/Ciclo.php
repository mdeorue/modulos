<?php

class Ciclo extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_ciclo';

	protected $fillable = array('estado');

	public function estados(){
		return $this->belongsTo('EstadoCiclo', 'estado');
	}

	public function modulos(){
		return $this->hasMany('Modulo', 'ciclo');
	}

}
