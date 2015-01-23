<?php

class Bitacora extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sb_bitacora';

	protected $fillable = array('modulo', 'bitacora', 'fecha');

	public function modulo(){
		return $this->belongsTo('Modulo', 'id');
	}

}
