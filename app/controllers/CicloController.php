<?php

class CicloController extends BaseController {

	public function abrirCiclo(){
		$resultado['resultado'] = false;
		
		$ciclos = Ciclo::where('estado', '<>', 4)->get();
		foreach ($ciclos as $ciclo) {
			$ciclo->estado = 4;
			$ciclo->save();
		}

		$cicloNuevo = new Ciclo;
		$cicloNuevo->estado = 1;
		$cicloNuevo->semestre = $this->getSemestreMes();
		$cicloNuevo->ano = date('Y');
		if($cicloNuevo->save()){
			$resultado['resultado'] = true;
			$resultado['mensaje'] = 'El ciclo fue creado correctamente.';
		}else{
			$resultado['mensaje'] = 'No se pudo crear un ciclo.';
		}
		return $resultado;
	}

	private function getSemestreMes($mes = null){
		if(is_null($mes)){
			$mes = date('m');
		}
		if($mes < 7){
			$semestre = 1;
		}else{
			$semestre = 2;
		}
		return $semestre;
	}

	public function abrirInscripciones(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'Las inscripciones no se han podido abrir.';
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			$ciclo->estado = 2;
			if($ciclo->save()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Las inscripciones han sido abiertas correctamente.';
			}
		}
		return $resultado;
	}

	public function cerrarInscripciones(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'Las inscripciones no se han podido cerrar.';
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			$ciclo->estado = 3;
			if($ciclo->save()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Las inscripciones han sido cerradas correctamente.';
			}
		}
		return $resultado;
	}

	public function cerrarCiclo(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'El ciclo no pudo ser cerrado';
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			$ciclo->estado = 4;
			if($ciclo->save()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Ciclo '.$ciclo->id.' cerrado correctamente.';
			}
		}
		return $resultado;
	}

	public function panelCiclos(){
		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'ciclo');
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('alertify', 'jqueryForm', 'jqueryUI'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$dataContainer['title'] = 'Ciclos';

		$dataContainer['widgets'][] = $this->widgetNavBarCiclos();

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		return View::make('template.panel', array('template' => $templateView));
	}

	private function widgetNavBarCiclos(){
		$ciclo['ciclo'] 	= Ciclo::orderBy('id', 'desc')->take(1)->first();
		$fecha = new DateTime($ciclo['ciclo']->inicio);
		$ciclo['ciclo']['fecha_inicio'] = $fecha->format('d-m-Y');
		$fecha = new DateTime($ciclo['ciclo']->final);
		$ciclo['ciclo']['fecha_final'] = $fecha->format('d-m-Y');

		$ciclo['boton'][] 	= 'Abrir Ciclo';
		$ciclo['boton'][] 	= 'Abrir Inscripciones';
		$ciclo['boton'][] 	= 'Cerrar Inscripciones';
		$ciclo['boton'][]	= 'Selección Alumnos';
		$ciclo['boton'][]	= 'Cerrar Ciclo'; 

		$ciclo['id'][]	= 'abrir-ciclo';
		$ciclo['id'][]	= 'abrir-insc';
		$ciclo['id'][]	= 'cerrar-insc';
		$ciclo['id'][]	= 'sel-alu';
		$ciclo['id'][]	= 'cerrar-ciclo';

		switch ($ciclo['ciclo']->estado) {
			case 1:
				//Ciclo Abierto
				$ciclo['disabled'][0] = true;
				$ciclo['disabled'][2] = true;
				$ciclo['disabled'][3] = true;
				break;

			case 2:
				//Abrir Inscripciones
				$ciclo['disabled'][0] = true;
				$ciclo['disabled'][1] = true;
				$ciclo['disabled'][3] = true;
				break;

			case 3:
				//Cerrar Inscripciones
				$ciclo['disabled'][0] = true;
				$ciclo['disabled'][2] = true;
				break;

			case 4:
				//Selección Alumnos
				$ciclo['disabled'][1] = true;
				$ciclo['disabled'][2] = true;
				$ciclo['disabled'][3] = true;
				$ciclo['disabled'][4] = true;
				break;
		}

		$resultado = View::make('ciclo.panelCiclos', $ciclo);
		return $resultado;
	}

	public function inscribirAlumnos(){
		$resultado['resultado'] = false;
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			if($ciclo->estado != 4){
				$resultado['resultado'] = true;
				$modulosSolicitados = Solicitud::select('sb_solicitud.modulo')
					->join('sb_modulo', function($join) use($ciclo){
	            		$join->on('sb_solicitud.modulo', '=', 'sb_modulo.id')
	                 		->where('sb_modulo.ciclo', '=', $ciclo->id);
	           		})
	           		->where('sb_solicitud.estado', '=', 0)
	           		->groupBy('sb_solicitud.modulo')
	           		->get();
	           	if($modulosSolicitados->count()){
	           		foreach ($modulosSolicitados as $moduloSolicitado) {
	           			//Información Módulo Solicitado
	           			$modulo = Modulo::find($moduloSolicitado->modulo);
	           			//Obtener todos los módulos que tienen la misma asignatura para una próxima actualización
	           			$modulosAsignatura = Modulo::select('id')->where('asignatura', '=', $modulo->asignatura)->where('ciclo', '=', $ciclo->id)->lists('id');
	           			//Solicitudes que por el momento han sido seleccionadas
	           			$solicitudesActivas = $modulo->solicitudes()->where('estado', '=', 1)->count();
	           			//Se obtiene disponibilidad del módulo
	           			$disponibilidad = $modulo->capacidad - $solicitudesActivas;
	           			if($disponibilidad > 0){
	           				//Obtiene solicitudes pendientes dependendiendo de la situación
	           				$solicitudesPendientes = Solicitud::select('sb_solicitud.id', 'sb_solicitud.matricula','sb_alumno.prioridad', 'sb_solicitud.created_at')
	           					->join('sb_alumno', 'sb_solicitud.matricula', '=', 'sb_alumno.matricula')
	           					->where('sb_solicitud.estado', '=', 0)
	           					->where('sb_solicitud.modulo', '=', $modulo->id)
	           					->orderBy('sb_alumno.prioridad', 'asc')
	           					->orderBy('sb_solicitud.created_at', 'asc')
	           					->take($disponibilidad)
	           					->get();
	           				if($solicitudesPendientes->count()){
	           					$pendientes = $solicitudesPendientes->lists('id');
	           					DB::table('sb_solicitud')
	            					->whereIn('id', $pendientes)
	            					->update(array('estado' => 1));
	            				$matriculas = $solicitudesPendientes->lists('matricula');
	            				DB::table('sb_solicitud')
	            					->whereIn('modulo', $modulosAsignatura)
	            					->whereIn('matricula', $matriculas)
	            					->where('estado', '=', 0)
	            					->update(array('estado' => 2));
	           				}
	           			}
	           		}
	           	}
	           	$this->confirmacionProfesores($ciclo);
	           	$modulos = Modulo::where('ciclo', '=', $ciclo->id)->orderBy('asignatura')->get();
	           	$resultado['widget'] = View::make('ciclo.resultadoInscripcion', array('modulos' => $modulos))->render();
			}else{
				$resultado['widget'] = '<p class="text-center">El ciclo se encuentra cerrado.</p>';
			}
		}else{
			$resultado['widget'] = '<p class="text-center">No existe ciclo disponible.</p>';
		}
		return $resultado;
	}

	private function confirmacionProfesores(Ciclo $ciclo){
		$modulos = Modulo::select('sb_modulo.id')
			->join('sb_solicitud', function($join){
				$join->on('sb_modulo.id', '=', 'sb_solicitud.modulo')
					->where('sb_solicitud.estado', '=', 1);
			})
			->where('sb_modulo.ciclo', '=', $ciclo->id)
			->groupBy('sb_modulo.id')
			->get();

		if($modulos->count()){
			foreach ($modulos as $modulo) {
				$moduloInfo = Modulo::find($modulo->id);
				$this->mailInscripcionProfesores($moduloInfo);
			}
		}

	}

	public function informarTutores(){
		$resultado['resultado'] = true;
		$resultado['mensaje'] = 'Se ha informado a los tutores.';
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first();
		$modulos = $ciclo->modulos()->get();
		foreach ($modulos as $modulo) {
			$solicitudesActivas = $modulo->solicitudes()->where('estado', '=', 1)->count();
			if($solicitudesActivas != 0){
				$this->mailInscripcionProfesores($modulo);
			}
		}

		return $resultado;
	}

	public function informarTutor(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' => 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$resultado['resultado'] = true;
			$resultado['mensaje'] = 'Se ha informado al tutor correctamente.';
			$modulo = Modulo::find(Input::get('modulo'));
			$this->mailInscripcionProfesores($modulo);
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
			
		return $resultado;
	}

	private function mailInscripcionProfesores(Modulo $modulo){
		$profesor = User::find($modulo->profesor);
		$activas = Solicitud::where('modulo', '=', $modulo->id)->where('estado', '=', 1)->get();
		Mailgun::send('emails.inscripcionModuloProf', array('modulo' => $modulo, 'activas' => $activas), function($message) use($profesor){
			$message->to($profesor->email, $profesor->usuario)
				->subject('Confirmación módulo tutoría académica');
		});
	}

	private function widgetResultadoInscripcion(Ciclo $ciclo){
		$widget['completos'] = Modulo::where('ciclo', '=', $ciclo->id)
			->where('estado', '=', 1)
			->get();
		$widget['pendientes'] = Modulo::where('ciclo', '=', $ciclo->id)
			->where('estado', '<>', 1)
			->get();
		if($widget['pendientes']->count()){
			foreach ($widget['pendientes'] as $pendiente) {
				$pendiente->solicitudes = $pendiente->solicitudes()->where('estado', '=', 1)->count();
			}
		}
		$widget['solPendientes'] = SolicitudHorario::where('ciclo', '=', $ciclo->id)
			->where('estado', '=', 0)
			->groupBy('asignatura', 'matricula')
			->get();
		$widget['cantidadPendientes'] = $widget['solPendientes']->count();
		$resultado = View::make('modulo.resultadoInscripciones', $widget)->render();
		return $resultado;
	}

	public function exportarReporteSolicitudes($inicio, $fin){
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			$modulos = $ciclo->modulos()->get();
			if($modulos->count()){
				$valores = 0;
				foreach ($modulos as $modulo) {
					$solicitudes = $modulo->solicitudes()->where('estado', '<>', 0)->get();
					if($solicitudes->count()){
						foreach ($solicitudes as $solicitud) {
							$alumno = $solicitud->alumno()->first();
							$horaAsistencia = Asistencia::where('modulo', '=', $modulo->id)->where('matricula', '=', $alumno->matricula)->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)->sum('hora_asis');
							$horaClase = Asistencia::where('modulo', '=', $modulo->id)->where('matricula', '=', $alumno->matricula)->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)->sum('hora_clase');
							$fechas = Asistencia::select(DB::raw('MIN(DATE_FORMAT(fecha,"%d-%m-%Y")) AS inicial, MAX(DATE_FORMAT(fecha,"%d-%m-%Y")) AS final'))->where('modulo', '=', $modulo->id)->where('matricula', '=', $alumno->matricula)->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)->first();
							if($solicitud->estado == 1){
								$estado = 'Activo';
							}else{
								$estado = 'Eliminado';
							}
							if($horaClase == 0){
								$porcentajeAsistencia = 0;
							}else{
								$porcentajeAsistencia = $horaAsistencia/$horaClase;
							}
							$array[] = array(
								'alumno.matricula' 				=> $alumno->matricula,
								'alumno.nombre'					=> $alumno->alumno,
								'alumno.facultad'				=> $alumno->facultad()->first()->facultad,
								'alumno.codigo_carrera'			=> $alumno->carrera()->first()->id,
								'alumno.carrera'				=> $alumno->carrera()->first()->carrera,
								'modulo.codigo_asignatura'		=> $modulo->asignatura()->first()->codigo,
								'modulo.asignatura'				=> $modulo->asignatura()->first()->asignatura,
								'modulo.modulo_asignatura'		=> $solicitud->mod_asig,
								'alumno.estado'					=> $estado,
								'modulo.matricula_tutor'		=> $modulo->profesor()->first()->rut,
								'modulo.tutor'					=> $modulo->profesor()->first()->usuario,
								'modulo.numero_tutoria'			=> $modulo->modulo,
								'alumno.asistencia'				=> $horaAsistencia,
								'alumno.porcentaje_asistencia'	=> $porcentajeAsistencia,
								'alumno.fecha_inicio'			=> $fechas->inicial,
								'alumno.fecha_final'			=> $fechas->final
								);
							$valores++;
						}
					}
				}
				if($valores){
					Excel::create('Reporte Estudiantes Participantes', function($excel) use($array) {
					    $excel->sheet('Reporte', function($sheet) use($array) {
					    	$sheet->fromArray($array);
					    });
					})->download('xls');
				}else{
					echo 'No existen valores para generar el reporte.';
				}
			}else{
				echo 'El ciclo no posee módulos creados.';	
			}
		}else{
			echo 'No existe ciclo';
		}
	}

	public function exportarReporteTutores($inicio, $fin){
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			$modulos = $ciclo->modulos()->get();
			if($modulos->count()){
				foreach ($modulos as $modulo) {
					$asistencia = Asistencia::select('fecha', 'hora_clase')
						->where('modulo', '=', $modulo->id)
						->where('fecha', '>=', $inicio)
						->where('fecha', '<=', $fin)
						->groupBy('fecha')
						->lists('hora_clase');
					$horasClases = array_sum($asistencia);
					$fechas = Asistencia::select(DB::raw('MIN(DATE_FORMAT(fecha,"%d-%m-%Y")) AS inicial, MAX(DATE_FORMAT(fecha,"%d-%m-%Y")) AS final'))->where('modulo', '=', $modulo->id)->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)->first();
					$array[] = array(
						'tutor.matricula' 				=> $modulo->profesor()->first()->rut,
						'tutor.nombre'					=> $modulo->profesor()->first()->usuario,
						'modulo.modulo'					=> $modulo->modulo,
						'modulo.hora_clase'				=> $horasClases,
						'modulo.fecha_inicio'			=> $fechas->inicial,
						'modulo.fecha_final'			=> $fechas->final
					);
				}
				Excel::create('Reporte Tutores', function($excel) use($array) {
				    $excel->sheet('Reporte', function($sheet) use($array) {
				    	$sheet->fromArray($array);
				    });
				})->download('xls');
			}else{
				echo 'No existen módulos activos para el ciclo.';
			}
		}else{
			echo 'No existe ciclo activo.';
		}
	}

}
