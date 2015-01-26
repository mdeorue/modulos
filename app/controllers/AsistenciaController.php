<?php

class AsistenciaController extends BaseController {

	public function guardar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' 		=> 'required|exists:sb_modulo,id',
			'fAsistencia'	=> 'required',
			'asistencia'	=> 'required|array',
			'matricula'		=> 'required|array',
			'hAsistencia'	=> 'required'));
		if($validador->passes()){
			$errores = 0;
			$asistencias = Input::get('asistencia');
			$matriculas = Input::get('matricula');
			$asistenciaExiste = Asistencia::where('modulo', '=', Input::get('modulo'))
				->where('fecha', '=', Input::get('fAsistencia'))
				->count();
			$modulo = Modulo::find(Input::get('modulo'));
			if($asistenciaExiste == 0){
				foreach ($asistencias as $key => $asistencia) {
					$alumno = Alumno::where('matricula', '=', $matriculas[$key])->get();
					if($alumno->count()){
						$alumno = $alumno->first();
						$asist = new Asistencia;
						$asist->modulo = $modulo->id;
						$asist->fecha = Input::get('fAsistencia');
						$asist->hora_clase = Input::get('hAsistencia');
						$asist->matricula = $matriculas[$key];
						$asist->hora_asis = $asistencia;
						if($asist->save() == false){
							$errores ++;
						}else{
							if($asist->hora_asis == 0){
								//$this->emailConstanciaInasistencia($alumno);
								$resultado['inasistencia'][] = $this->estudiarInasistencia($modulo, $alumno, Input::get('fAsistencia'));
							}
						}
					}
				}
				if($errores == 0){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Asistencia guardada con éxito.';
				}else{
					$resultado['mensaje'] = 'Han ocurrido algunos errores en el proceso.';
				}
			}else{
				$resultado['mensaje'] = 'El módulo ya tiene una asistencia ingresada para esta fecha.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function eliminar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'asistencia' => 'required|exists:sb_asistencia,id'));
		if($validador->passes()){
			$asistencia = Asistencia::find(Input::get('asistencia'));
			if ($asistencia->delete()) {
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Asistencia eliminada correctamente.';
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un problema, intentelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}

		return $resultado;
	}

	public function editar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'fAsistencia' 	=> 'required',
			'hAsistencia' 	=> 'required|integer',
			'asistencias'  	=> 'required|array',
			'hora_asis' 	=> 'required|array'));
		if($validador->passes()){
			$asistencias = Input::get('asistencias');
			$horaAsistencia = Input::get('hora_asis');
			foreach ($asistencias as $key => $asistencia) {
				$validadorAsistencia = Validator::make($asistencias, array(
					$key => 'required|exists:sb_asistencia,id'));
				if($validadorAsistencia->passes()){
					$asistenciaEdit = Asistencia::find($asistencia);
					$asistenciaEdit->hora_clase =  Input::get('hAsistencia');
					$asistenciaEdit->hora_asis 	=  $horaAsistencia[$key];
					$asistenciaEdit->fecha  	=  Input::get('fAsistencia');
					if($asistenciaEdit->save()){
						$resultado['resultado'] = true;
						$resultado['mensaje'] = 'Edición realizada correctamente.';
					}
				}
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	private function emailConstanciaInasistencia(Alumno $alumno){
		Mailgun::send('emails.informacionInasistencia',array('alumno' => $alumno), function($message) use($alumno){
			$message->to($alumno->email, $alumno->alumno)->subject('Recuerda no ausentarte a la tutoría académica');
		});
	}
	
	public function widgetHistorica(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' 	=> 'required|exists:sb_modulo,id'
			));
		if($validador->passes()){
			$asistencias = Asistencia::where('modulo', '=', Input::get('modulo'))->orderBy('fecha', 'desc')->get();
			if($asistencias->count()){
				$resultado['resultado'] = true;
				$resultado['widget'] = View::make('asistencia.historica', ['asistencias' => $asistencias, 'modulo' => Input::get('modulo')])->render();
			}else{
				$resultado['mensaje'] = 'El módulo no posee asistencia inscrita.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function widgetEditarAsistencia(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'asistencia' => 'required|exists:sb_asistencia,id'));
		if($validador->passes()){
			$asistencia = Asistencia::find(Input::get('asistencia'));
			$asistencias = Asistencia::where('modulo', '=', $asistencia->modulo)->where('fecha', '=', $asistencia->fecha)->get();
			if($asistencias->count()){
				$resultado['resultado'] = true;
				$resultado['widget'] = View::make('asistencia.edicion', array('asistencia' => $asistencia,'asistencias' => $asistencias))->render();
			}
		}
		return $resultado;
	}

	private function estudiarInasistencia(Modulo $modulo, Alumno $alumno, $fecha){
		$resultado = 0;
		$fechasClases = Asistencia::select('fecha')
			->where('modulo', '=', $modulo->id)
			->where('fecha', '<', $fecha)
			->groupBy('fecha')
			->take(2)
			->orderBy('fecha', 'desc')
			->get();
		if($fechasClases->count() == 2){
			$resultado = 1;
			$date = $fechasClases->lists('fecha');
			$asistencia = Asistencia::where('modulo', '=', $modulo->id)
				->where('fecha', '=', head($date))
				->where('matricula', '=', $alumno->matricula)
				->take(1)
				->get();
			if($asistencia->count()){
				$asistencia = $asistencia->first();
				$resultado = 2;
				if($asistencia->hora_asis == 0){
					$resultado = 3;
					$asistencia2 = Asistencia::where('modulo', '=', $modulo->id)
						->where('fecha', '=', last($date))
						->where('matricula', '=', $alumno->matricula)
						->take(1)
						->get();
					if($asistencia2->count()){
						$resultado = 4;
						$asistencia2 = $asistencia2->first();
						if($asistencia2->hora_asis == 0){
							$resultado = 5;
							$solicitud = Solicitud::where('modulo', '=', $modulo->id)
								->where('matricula', '=', $alumno->matricula)
								->get();
							if($solicitud->count()){
								$resultado = 6;
								$solicitud = $solicitud->first();
								$solicitud->estado = 2;
								if($solicitud->save()){
									$resultado = 7;
									$eliminacion = new Eliminacion;
									$eliminacion->modulo = $solicitud->id;
									$eliminacion->motivo = 2;
									$eliminacion->usuario = Auth::user()->id;
									$eliminacion->save();
								}
							}
						}
					}
				}
			}
		}
		return $resultado;
	}

}