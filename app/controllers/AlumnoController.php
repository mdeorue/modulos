<?php

class AlumnoController extends BaseController {

	public function getInfoInscripcion(){

		$resultado['resultado'] = false;
		$resultado['widget'] = '';
		$matricula = Input::get('matricula');
		$validador = Validator::make(Input::all(),array(
			'matricula' => 'required'));
		if($validador->passes()){
			$alumno = Alumno::where('matricula', '=', $matricula)->get();
			$resultado['resultado'] = true;
			if($alumno->count()){
				$alumno = $alumno->first();
				$asignaturas = null;
				$asignaturaCarrera = AsignaturaCarrera::where('carrera', '=', $alumno->carrera()->first()->id)->lists('asignatura');
				if(!empty($asignaturaCarrera)){
					$asignaturas = Asignatura::select(DB::raw('CONCAT(codigo," - ",asignatura) AS asignatura, id'))->whereIn('codigo', $asignaturaCarrera)->get()->lists('asignatura', 'id');
				}
				$asignaturas[0] = 'ELIJA ASIGNATURA';
				$resultado['widget'] = View::make('modulo.inscripcionPostMatricula', array('alumno' => $alumno, 'asignaturas' => $asignaturas))->render();
			}else{
				$facultades = Facultad::all()->lists('facultad', 'id');
				$facultades[0] = 'Seleccione Facultad';
				$resultado['widget'] = View::make('modulo.inscripcionSinMatricula', array('facultades' => $facultades))->render();
			}
		}

		return $resultado;
	}

	public function insertarAlumnos(){
		$facultades = Facultad::select('id', 'codigo')->lists('id', 'codigo');
		echo '<pre>', print_r($facultades), '</pre>'; 
		
		$prioridades = Prioridad::select('id', 'texto')->lists('id', 'texto');
		echo '<pre>', print_r($prioridades), '</pre>';
	}

	public function panelAlumno(){

		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'alumnos');
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('alertify', 'jqueryForm'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$dataContainer['title'] = 'Panel Alumnos';

		$dataContainer['widgets'][] = $this->widgetSideBarAlumno();

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		return View::make('template.panel', array('template' => $templateView));
	}

	private function widgetSideBarAlumno(){		
		$resultado = View::make('alumno.sideBarPanel');
		return $resultado;
	}

	public function widgetBusqueda(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'alumno' => 'required|exists:sb_alumno,matricula'));
		if($validador->passes()){
			$widgetData['alumno'] = Alumno::where('matricula', '=', Input::get('alumno'))->first();
			$widgetData['activas'] = $widgetData['alumno']->solicitud()->where('estado', '=', 1)->get();
			$widgetData['pendientes'] = $widgetData['alumno']->solicitud()->where('estado', '=', 0)->get();
			$widgetData['canceladas'] = $widgetData['alumno']->solicitud()->where('estado', '=', 2)->get();
			//$solicitudesEliminacion = $widgetData['canceladas']->lists('id');
			//$moduloInfo['eliminacion'] = Eliminacion::whereIn('solicitud', $solicitudesEliminacion)->lists('motivo', 'solicitud');
			$widgetData['ciclos'] = Ciclo::select(DB::raw('CONCAT(semestre,"-",ano) AS periodo, id'))->lists('periodo', 'id');
			$widgetData['ciclos'][0] = 'Seleccione Ciclo';
			$resultado['resultado'] = true;
			$resultado['widget'] = View::make('alumno.panelDetalle', $widgetData)->render();
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function pdfConstanciaInscripcion(){
		$validador = Validator::make(Input::all(), array(
			'matricula' => 'required|exists:sb_alumno,matricula',
			'modulo' => 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$viewData['alumno'] = Alumno::where('matricula', '=', Input::get('matricula'))->first();
			$solicitud = Solicitud::where('matricula', '=', Input::get('matricula'))
				->where('modulo', '=', Input::get('modulo'))
				->get();
			if($solicitud->count()){
				$viewData['tutoria'] = Modulo::find(Input::get('modulo'));
				$viewData['horas'] = Asistencia::where('matricula', '=', Input::get('matricula'))->where('modulo', '=', Input::get('modulo'))->sum('hora_asis');
				$fechas = Asistencia::select(DB::raw('MIN(DATE_FORMAT(fecha,"%d-%m-%Y")) AS inicio, MAX(DATE_FORMAT(fecha,"%d-%m-%Y")) AS final'))->where('matricula', '=', Input::get('matricula'))->where('modulo', '=', Input::get('modulo'))->first();
				$viewData['fechaInicio'] = $fechas->inicio;
				$viewData['fechaFinal'] = $fechas->final;
				$viewData['mes'] = Template::getMes(date('m'));
				$pdf = PDF::loadView('pdf.certInsModulo', $viewData);
				return $pdf->stream();
			}else{
				View::make('alumno.errorCertificado', array('mensaje' => 'El alumno no tiene inscripciones para el módulo seleccionado.'));
			}
		}else{
			View::make('alumno.errorCertificado', array('mensaje' => 'Los datos ingresados no son válidos.'));
		}
	}

	public function getModulosByCiclo(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'matricula' => 'required|exists:sb_alumno,matricula',
			'ciclo'		=> 'required|exists:sb_ciclo,id'));
		if($validador->passes()){
			$modulos = Modulo::select(DB::raw('CONCAT(sb_asignatura.codigo, "-", sb_asignatura.asignatura) AS asignatura, sb_modulo.id'))
				->join('sb_asignatura', 'sb_modulo.asignatura', '=', 'sb_asignatura.id')
				->join('sb_solicitud', function($join){
            		$join->on('sb_modulo.id', '=', 'sb_solicitud.modulo')
                		->where('sb_solicitud.matricula', '=', Input::get('matricula'));
        		})
				->where('sb_modulo.ciclo', '=', Input::get('ciclo'))
				->lists('asignatura', 'id');
			$modulos[0] = 'Seleccione un módulo';
			$resultado['resultado'] = true;
			$resultado['widget'] = View::make('alumno.certModulos', array('modulos' => $modulos))->render();
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function eliminar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'alumno' => 'required|exists:sb_alumno,id'));
		if($validador->passes()){
			$alumno = Alumno::find(Input::get('alumno'));
			if($alumno->delete()){
				$resultado['resultado']	= true;
				$resultado['mensaje'] 	= 'Alumno eliminado con éxito.'; 
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un problema, inténtelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function importarAlumnosXLS(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'No se han registrado alumnos.';
		if (Input::hasFile('import')) {
			$nombre = Input::file('import')->getClientOriginalName();
			$extension = Input::file('import')->getClientOriginalExtension();
			$destino = 'import/alumno';
			$extPermitidas = array('csv', 'xls', 'xlsx');
			if(in_array($extension, $extPermitidas)){
				$upload = Input::file('import')->move($destino, $nombre);
				if($upload){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Alumnos registrados correctamente.';
					Excel::load('import/alumno/'.$nombre, function($reader) {
						$columnas = $reader->toArray();
						$respuesta['guardadas'] = 0;
						$respuesta['errores'] = array();
						if(count($columnas)){
							$facultades = Facultad::lists('id', 'codigo');
							$prioridades = Prioridad::lists('id', 'texto');
							foreach ($columnas as $key => $columna) {
								$validador = Validator::make($columna, array(
									'matricula' 	=> 'required|unique:sb_alumno,matricula',
									'cod_facult'	=> 'required|exists:sb_facultad,codigo',
									'cod_carrer'	=> 'required|exists:sb_carrera,id',
									'email'			=> 'required|email'));
								if($validador->passes()){
									if(isset($prioridades[$columna['participacion']])){
										$prioridadCod = $prioridades[$columna['participacion']];
									}else{
										$prioridadCod = 999999;
									}
									$alumno = new Alumno;
									$alumno->matricula 	= strtoupper($columna['matricula']);
									$alumno->alumno 	= strtoupper($columna['nombre']);
									$alumno->ingreso 	= $columna['ano_ingreso'];
									$alumno->email 		= $columna['email'];
									$alumno->prioridad 	= $prioridadCod;
									$alumno->facultad 	= $facultades[$columna['cod_facult']];
									$alumno->carrera 	= $columna['cod_carrer'];
									$alumno->grupo		= str_replace('Grupo ','',$columna['grupo']);
									if($alumno->save()){
										$respuesta['guardadas'] ++;
									}
								}
							}
						}
					});
				}else{
					$resultado['mensaje'] = 'El archivo no pude ser subido de manera correcta.';
				}
			}else{
				$resultado['mensaje'] = 'La extensión del archivo no es válida.';
			}
		}else{
			$resultado['mensaje'] = 'Lo que intenta subir no es un archivo válido.';
		}
		return $resultado;
	}

	public function importarReprobacionXLS(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'No se han registrado la reprobación de alumnos.';
		if (Input::hasFile('import')) {
			$nombre = Input::file('import')->getClientOriginalName();
			$extension = Input::file('import')->getClientOriginalExtension();
			$destino = 'import/alumno';
			$extPermitidas = array('csv', 'xls', 'xlsx');
			if(in_array($extension, $extPermitidas)){
				$upload = Input::file('import')->move($destino, $nombre);
				if($upload){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Reprobación registrada correctamente.';
					Excel::load('import/alumno/'.$nombre, function($reader) {
						$columnas = $reader->toArray();
						$respuesta['guardadas'] = 0;
						$respuesta['errores'] = array();
						if(count($columnas)){
							foreach ($columnas as $key => $columna) {
								$validador = Validator::make($columna, array(
									'matricula' 	=> 'required|unique:sb_alumno,matricula',
									'cod_asigna'	=> 'required|exists:sb_asignatura,codigo'));
								if($validador->passes()){
									$becaAsignatura = new becaAsignatura;
									$becaAsignatura->matricula = $columna['matricula'];
									$becaAsignatura->asignatura = $columna['cod_asigna']; 
									if($becaAsignatura->save()){
										$respuesta['guardadas'] ++;
									}
								}
							}
						}
					});
				}else{
					$resultado['mensaje'] = 'El archivo no pude ser subido de manera correcta.';
				}
			}else{
				$resultado['mensaje'] = 'La extensión del archivo no es válida.';
			}
		}else{
			$resultado['mensaje'] = 'Lo que intenta subir no es un archivo válido.';
		}
		return $resultado;
	}
}