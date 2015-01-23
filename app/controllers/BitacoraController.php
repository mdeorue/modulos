<?php

class BitacoraController extends BaseController {

	public function guardar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' 	=> 'required|exists:sb_modulo,id',
			'fecha'		=> 'required',
			'bitacora'	=> 'required'));
		if($validador->passes()){
			$bitacora = new Bitacora;
			$bitacora->modulo 	= Input::get('modulo');
			$bitacora->fecha 	= Input::get('fecha');
			$bitacora->bitacora = Input::get('bitacora');
			if($bitacora->save()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Bitácora guardada con éxito.';
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function widgetHistorica(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' 	=> 'required|exists:sb_modulo,id'
			));
		if($validador->passes()){
			$bitacoras = Bitacora::where('modulo', '=', Input::get('modulo'))->get();
			if($bitacoras->count()){
				$resultado['resultado'] = true;
				$resultado['widget'] = View::make('bitacora.historica', array('bitacoras' => $bitacoras, 'modulo' => Input::get('modulo')))->render();
			}else{
				$resultado['mensaje'] = 'El módulo no posee bitácoras.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

}
