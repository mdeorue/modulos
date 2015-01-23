<?php

class CarreraController extends BaseController {

	public function getAsignaturasByCarrera(){
		
		$resultado['resultado'] = false;
		$idCarrera = Input::get('carrera');
		if($idCarrera != 0){
			$carrera = Carrera::find($idCarrera);
			if($carrera->count()){
				$asignaturaList = $carrera->asignaturas()->get();
				if($asignaturaList->count()){
					$codAsignaturas = $asignaturaList->lists('asignatura');
					$asignaturasList = Asignatura::select(DB::raw('CONCAT(codigo," - ",asignatura) AS asignatura, id'))->whereIn('codigo', $codAsignaturas)->get();
					if($asignaturasList->count()){
						$resultado['resultado'] = true;
						$asignaturas = $asignaturasList->lists('asignatura', 'id');
						$asignaturas[0] = 'Seleccionar Asignatura';
						$resultado['widget'] = View::make('modulo.selectAsignaturas', array('asignaturas' => $asignaturas))->render();
					}
				}
			}
		}
		return $resultado;
	}


	public function getCarrerasByFacultadMod(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'facultad' => 'required|exists:sb_facultad,id'));
		if($validador->passes()){
			$resultado['resultado'] = true;
			$facultad = Facultad::find(Input::get('facultad'));
			$carreras['carreras'] = $facultad->carreras()->lists('carrera', 'id');
			$carreras['carreras'][0] = 'Seleccione carrera';
			$resultado['widget'] = View::make('modulo.selectCarreras', $carreras)->render();
		}
		return $resultado;
	}

	public function getCarrerasByFacultadConf(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'facultad' => 'required|exists:sb_facultad,id'));
		if($validador->passes()){
			$resultado['resultado'] = true;
			$facultad = Facultad::find(Input::get('facultad'));
			$carreras['carreras'] = $facultad->carreras()->lists('carrera', 'id');
			$carreras['carreras'][0] = 'Seleccione carrera';
			$resultado['widget'] = View::make('configuracion.selectCarreras', $carreras)->render();
		}
		return $resultado;
	}

	public function getCarrerasByFacultadModulo(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'facultad' => 'required|exists:sb_facultad,id'));
		if($validador->passes()){
			$resultado['resultado'] = true;
			$facultad = Facultad::find(Input::get('facultad'));
			$carreras['carreras'] = $facultad->carreras()->lists('carrera', 'id');
			$carreras['carreras'][0] = 'Seleccione carrera';
			$resultado['widget'] = View::make('modulo.selectCarrerasMod', $carreras)->render();
		}
		return $resultado;
	}

}
