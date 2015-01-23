<?php

class Eliminacion extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_eliminacion';

	protected $fillable = array('solicitud', 'motivo', 'usuario');

	public function solicitud(){
		return $this->belongsTo('Solicitud', 'solicitud');
	}

	public function usuario(){
		return $this->belongsTo('User', 'usuario');
	}

}
