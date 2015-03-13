<?php

class ModuloController extends BaseController {

	public function panelModulos(){
		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'modulos');
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('alertify', 'jqueryForm', 'jqueryUI'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$dataContainer['title'] = 'Módulos';
		$dataContainer['toolbar'][] = HTML::linkSecureAsset('#', ' ', array('class' => 'glyphicon glyphicon-plus', 'title' => 'Crear Módulo', 'id' => 'mod-crear-mod'));

		$dataContainer['widgets'][] = $this->widgetPanelModulosCompleto();

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		return View::make('template.panel', array('template' => $templateView));
	}

	private function widgetPanelModulosCompleto(){

		$facultades['facultades'] = Facultad::all()->lists('facultad', 'id');
		$facultades['facultades'][0] = 'Seleccione Facultad';
		$resultado = View::make('modulo.moduloPanel', $facultades);
		return $resultado;
	}

	public function informarTutores(){
		$resultado['resultado'] = false;
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first();
		$modulos = $ciclo->modulos()->all();
		foreach ($modulos as $modulo) {
			
		}
	}

	public function getHorarioByAsignatura(){
		$resultado['resultado'] = true;
		$idAsignatura = Input::get('asignatura');
		$horario = Template::getHorarioBasico();
		for($i = 1; $i < 12; $i++){
			for($j = 1; $j < 6; $j++){
				$horario['modulo'][$i][$j] = Form::checkbox('horarios[]', $j.'-'.$i, false, array('form' => 'ins-alu'));
				$horario['clase'][$i][$j] = 'mod-select';	
			}
		}
		if($idAsignatura != '0'){
			$resultado['widget'] = View::make('modulo.inscripcionHorarioSinModulo', $horario)->render();
			$resultado['widget2'] = View::make('modulo.incripcionModulo')->render();
		}else{
			$resultado['widget'] = '';
			$resultado['widget2'] = '';
		}
		return $resultado;
	}

	public function cambiarModuloSolicitud(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'solicitud' => 'required|exists:sb_solicitud,id',
			'modulo'	=> 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$solicitud = Solicitud::find(Input::get('solicitud'));
			$solicitud->modulo = Input::get('modulo');
			if($solicitud->save()){
				$resultado['resultado'] = true;
			}
		}
		return $resultado;
	}

	public function panelInscripcion(){

		if(Auth::check()){
				$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'inscripcion');
		}else{
			$menus = Template::crearMenu();
		}

		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('jqueryForm', 'alertify'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first();
		$configuracion = Configuracion::orderBy('id', 'desc')->take(1)->first();

		if($configuracion->ins_pub){
			if($ciclo->estado == 2){
				$templateView['container'] = View::make('modulo.inscripcion');
			}else{
				$templateView['container'] = '<p class="text-center">El proceso de inscripción se encuentra temporalmente cerrado.</p>';
			}
		}else{
			if(Auth::check()){
				if(Auth::user()->categoria < 3){
					if($ciclo->count()){
						$templateView['container'] = View::make('modulo.inscripcion');
					}else{
						$templateView['container'] = '<p class="text-center">El proceso de inscripción se encuentra temporalmente cerrado.</p>';
					}
				}else{
					$templateView['container'] = '<p class="text-center">El proceso de inscripción se encuentra temporalmente cerrado.</p>';
				}
			}else{
				$templateView['container'] = '<p class="text-center">El proceso de inscripción se encuentra temporalmente cerrado.</p>';
			}
		}

		return View::make('template.panel', array('template' => $templateView));
	
	}

	public function getModulosByAsignatura(){
		$resultado['resultado'] = false;
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get();
		if($ciclo->count()){
			$ciclo = $ciclo->first();
			$idAsignatura = Input::get('asignatura');
			$horario = Template::getHorarioBasico();
			$alumno = Alumno::where('matricula', '=', Input::get('matricula'))->take(1)->get();
			if($alumno->count()){
				$alumno = $alumno->first();
				if($alumno->prioridad != 999999){
					$modulos = Modulo::where('ciclo', '=', $ciclo->id)->where('asignatura', '=', $idAsignatura)->get();
				}else{
					$modulos = Modulo::where('ciclo', '=', $ciclo->id)->where('asignatura', '=', $idAsignatura)->where('prioritario', '=', 0)->get();
				}
			}else{
				$modulos = Modulo::where('ciclo', '=', $ciclo->id)->where('asignatura', '=', $idAsignatura)->where('prioritario', '=', 0)->get();
			}
			if($modulos->count()){
				$resultado['resultado'] = true;
				$asignatura = Asignatura::find($idAsignatura);
				for ($i=1; $i<=$asignatura->modulos ; $i++) { 
					$modulosAsignatura[$i] = $i;
				}
				$modulosAsignatura[0] = 'Seleccione Módulo';
				$resultado['widgetModulos'] = View::make('modulo.modulosAsignatura', array('modulos' => $modulosAsignatura))->render();
				foreach ($modulos as $modulo) {
					$solicitudesActivas = Solicitud::where('modulo', '=', $modulo->id)->where('estado', '=', 1)->get()->count();
					if($solicitudesActivas < $modulo->capacidad){
						$horario['modulo'][$modulo->horario_hora][$modulo->horario_dia] = $modulo->asignatura()->first()->codigo.' - '.$modulo->modulo.' - '.$modulo->profesor()->first()->usuario;
						$horario['clase'][$modulo->horario_hora][$modulo->horario_dia] = 'mod-select';
					}				
				}
				if($idAsignatura != 0){
					$resultado['widget'] = View::make('modulo.inscripcionPostAsignatura', $horario)->render();
				}else{
					$resultado['widget'] = '';
				}
			}
		}
		return $resultado;
	}

	public function getModulosByAsignaturaMod(){

		$resultado['resultado'] = false;
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get()->first();
		if($ciclo->estado != 4){
			$idAsignatura = Input::get('asignatura');
			$modulos = Modulo::where('ciclo', '=', $ciclo->id)->where('asignatura', '=', $idAsignatura)->get();
			if($modulos->count()){
				$resultado['resultado'] = true;
				$resultado['widget'] = View::make('modulo.modulosPanelModulo', array('modulos' => $modulos))->render();
			}
		}
		return $resultado;
	}

	public function getModuloByHorarioAsignatura(){

		$resultado['resultado'] = false;
		$idAsignatura = Input::get('asignatura');
		$horarioDia = Input::get('dia');
		$horarioHora = Input::get('hora');
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get()->first();
		$modulos = Modulo::where('ciclo', '=', $ciclo->id)
			->where('asignatura', '=', $idAsignatura)
			->where('horario_dia', '=', $horarioDia)
			->where('horario_hora', '=', $horarioHora)
			->get();
		if($modulos->count()){
			$resultado['resultado'] = true;
			$horario = Template::getHorarioBasico();
			foreach ($modulos as $modulo) {
				$solicitudesActivas = Solicitud::where('modulo', '=', $modulo->id)->where('estado', '=', 1)->get()->count();
				if($solicitudesActivas < $modulo->capacidad){
					$mods['id'][] 				= $modulo->id;
					$mods['asignatura'][] 		= $modulo->asignatura()->first()->codigo.' - '.$modulo->modulo.' - '.$modulo->asignatura()->first()->asignatura;
					$mods['profesor'][] 		= $modulo->profesor()->first()->usuario;
					$fechaInicio 				= new DateTime($modulo->inicio);
					$mods['inicio'][] 			= $fechaInicio->format('d-m-Y');
					$mods['hora_inicio'][] 		= $horario['modulo'][$modulo->horario_hora][0];
					$mods['hora_fin'][] 		= $horario['modulo'][$modulo->horario_hora_fin][0];
					$mods['disponibilidad'][] 	= $modulo->capacidad-$solicitudesActivas;
				}				
			}
			$resultado['widget'] = View::make('modulo.inscripcionPostModulo', array('modulos' => $mods))->render();
		}else{
			$resultado['widget'] = '';
		}
		return $resultado;
	}

	public function inscribirModulo(){
		$resultado['parte'] = 0;
		$dataWidget['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'matricula' => 'required',
			'modulo'	=> 'required|exists:sb_modulo,id',
			'modAsig' 	=> 'required'));
		if($validador->passes() && Input::get('modAsig') != 0){
			$resultado['parte'] = 1;
			$input['matricula']	= Input::get('matricula');
			$input['modulo'] 		= Input::get('modulo');
			$alumno = Alumno::where('matricula', '=', $input['matricula'])->take(1)->get();
			if($alumno->count()){
				$alumno = $alumno->first();
				$alumnoExiste = true;
			}else{
				$nuevoAlumno = $this->crearAlumno(Input::all());
				if($nuevoAlumno['resultado']){
					$alumno = $nuevoAlumno['alumno'];
					$alumnoExiste = true;
				}else{
					$alumno = null;
					$alumnoExiste = false;
				}
			}
			$solicitudAlumno = Solicitud::where('matricula', '=', $input['matricula'])->where('modulo', '=', $input['modulo'])->get();
			if($solicitudAlumno->count() == 0){
				$modulo = Modulo::find($input['modulo']);
				$solicitudesAsignatura = Solicitud::join('sb_modulo', function($join) use ($modulo){
            			$join->on('sb_solicitud.modulo', '=', 'sb_modulo.id')
                 			->where('sb_modulo.asignatura', '=', $modulo->asignatura);
        			})
					->where('sb_solicitud.estado', '=', 1)
					->where('sb_solicitud.matricula', '=', Input::get('matricula'))
					->count();
				if($solicitudesAsignatura == 0){
					$solicitudesActivas = Solicitud::where('modulo', '=', $input['modulo'])->where('estado', '=', 1)->count();
					if($alumnoExiste){
						$prioridadManual = Input::get('prioridad');
						if($prioridadManual != 1){
							if($alumno->prioridad != 999999 && $solicitudesActivas < $modulo->capacidad){
								$input['estado'] = 1;
							}else{
								$asignatura = Asignatura::find($modulo->asignatura);
								$becaAsignatura = BecaAsignatura::where('matricula', '=', $alumno->matricula)
									->where('asignatura', '=', $asignatura->codigo)
									->count();
								if($becaAsignatura){
									$input['estado'] = 1;
								}else{
									$input['estado'] = 0;
								}
							}
						}else{
							$input['estado'] = 1;
						}
						$solicitud = new Solicitud;
						$solicitud->matricula 	= $input['matricula'];
						$solicitud->modulo 		= $input['modulo'];
						$solicitud->estado 		= $input['estado'];
						$solicitud->mod_asig 	= Input::get('modAsig');
						if($solicitud->save()){
							$dataWidget['resultado'] = true;
							if($input['estado'] == 1){
								$modulosAsignatura = Modulo::where('asignatura','=', $modulo->asignatura)->where('ciclo', '=', $modulo->ciclo)->lists('id');
								
								DB::table('sb_solicitud')
	            					->whereIn('modulo', $modulosAsignatura)
	            					->where('matricula', '=', $alumno->matricula)
	            					->where('estado', '=', 0)
	            					->update(array('estado' => 2));

								$this->mailInscripcionAlumno($alumno, $modulo);
								$profesor = $modulo->profesor()->first();
							}
							$dataWidget['mensaje']	= 'La solicitud fue ingresada correctamente.';
						}else{
							$dataWidget['mensaje'] = 'Ha ocurrido un error, intentelo nuevamente.';
						}
					}else{
						$dataWidget['mensaje'] = $nuevoAlumno['mensaje'];
					}
				}else{
					$dataWidget['mensaje'] = 'El alumno ya ha sido seleccionado para una tutoria de esta asignatura.';
				}
			}else{
				$dataWidget['mensaje'] = 'Usted ya posee solicitudes pendientes para este módulo.';
			}
		}else{
			$dataWidget['mensaje'] = 'Los datos ingresados no son válidos.';
		}	
		$resultado['resultado'] = $dataWidget['resultado'];
		$resultado['mensaje'] 	= $dataWidget['mensaje'];
		$resultado['widget']	= View::make('modulo.resultadoInscripcion', $dataWidget)->render();
		return $resultado;
	}

	private function crearAlumno($alumnoInfo){
		$resultado['resultado'] = false;
		$validador = Validator::make($alumnoInfo, array(
			'matricula' => 'required',
			'alumno' 	=> 'required',
			'email' 	=> 'required|email|unique:sb_alumno,email',
			'carrera'	=> 'required|exists:sb_carrera,id',
			'facultad' 	=> 'required|exists:sb_facultad,id'));
		if($validador->passes()){
			$alumno = new Alumno;
			$alumno->matricula 	= $alumnoInfo['matricula'];
			$alumno->alumno 	= strtoupper($alumnoInfo['alumno']);
			$alumno->email 		= $alumnoInfo['email'];
			$alumno->ingreso 	= date('Y');
			$alumno->prioridad 	= 999999;
			$alumno->facultad 	= $alumnoInfo['facultad'];
			$alumno->carrera 	= $alumnoInfo['carrera'];
			$alumno->grupo 		= 3;
			if($alumno->save()){
				$resultado['resultado'] = true;
				$resultado['alumno'] = $alumno;
			}else{
				$resultado['mensaje'] = 'No se pudo crear el alumno.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function getPanelInfoModulo(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' => 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$moduloInfo['modulo'] = Modulo::find(Input::get('modulo'));
			$moduloInfo['activas'] = $moduloInfo['modulo']
				->solicitudes()
				->where('estado', '=', 1)
				->get();
			$moduloInfo['pendientes'] = $moduloInfo['modulo']
				->solicitudes()
				->where('estado', '=', 0)
				->get();
			$moduloInfo['canceladas'] = $moduloInfo['modulo']
				->solicitudes()
				->where('estado', '=', 2)
				->get();
			$modulosDispobles = Modulo::where('id', '<>',$moduloInfo['modulo']->id)->where('horario_dia', '=', $moduloInfo['modulo']->horario_dia)->where('horario_hora', '=', $moduloInfo['modulo']->horario_hora)->where('asignatura', '=', $moduloInfo['modulo']->asignatura)->get();
			foreach($modulosDispobles as $disponible) {
				$solicitudesActivas = $disponible->solicitudes()->where('estado', '=', 1)->count();
				if($solicitudesActivas < $disponible->capacidad){
					$moduloInfo['disponibilidad'][$disponible->id] = $disponible->asignatura()->first()->codigo.' - '.$disponible->modulo.' - '.$disponible->profesor()->first()->usuario;
				}
			}
			//$solicitudesEliminacion = $moduloInfo['canceladas']->lists('id');
			//$moduloInfo['eliminacion'] = Eliminacion::whereIn('solicitud', $solicitudesEliminacion)->lists('motivo', 'solicitud');
			$resultado['resultado'] = true;
			$resultado['widget'] = View::make('modulo.panelInfoModulo', $moduloInfo)->render();
		}
		return $resultado;	
	}

	public function inscribirHorarioModulo(){
		$resultado['resultado'] = false;
		$resultado['parte'] = 0;
		$ciclo 	= Ciclo::orderBy('id', 'desc')->take(1)->first();
		$validador = Validator::make(Input::all(), array(
			'matricula' 	=> 'required|min:10',
			'asignatura' 	=> 'required|exists:sb_asignatura,codigo',
			'horarios' 		=> 'required|array'));
		if($validador->passes()){
			$resultado['parte'] = 1;
			$asignatura = Asignatura::where('codigo', '=', Input::get('asignatura'))->get()->first();
			$alumno = Alumno::where('matricula', '=', Input::get('matricula'))->get();
			$solicitudesActivas = SolicitudHorario::where('matricula', '=', Input::get('matricula'))
				->where('ciclo', '=', $ciclo->id)
				->where('asignatura', '=', $asignatura->id)
				->where('estado', '<>', 0)
				->get()
				->count();
			if($solicitudesActivas == 0){
				$resultado['parte'] = 2;
				if($alumno->count()){
					$resultado['parte'] = 3;
					if(empty($alumno->email)){
						$validadorEmail = Validator::make(Input::all(), array(
							'email' => 'required|email'));
						if($validadorEmail->passes()){
							$alumno->email = Input::get('email');
							$alumno->save();
						}else{
							$resultado['widget'] = 'Los datos ingresados no son válidos 1';
						}
					}
					$inscripciones = 0;
					foreach (Input::get('horarios') as $horario) {
						$horarioParte = explode('-', $horario);
						$existeSolicitud = SolicitudHorario::where('matricula', '=', Input::get('matricula'))
							->where('asignatura', '=', $asignatura->id)
							->where('horario_dia', '=', $horarioParte[0])
							->where('horario_hora', '=', $horarioParte[1])
							->get();
						if($existeSolicitud->count() == 0){
							$solicitud = new SolicitudHorario;
							$solicitud->matricula = Input::get('matricula');
							$solicitud->asignatura = $asignatura->id;
							$solicitud->horario_dia = $horarioParte[0];
							$solicitud->horario_hora = $horarioParte[1];
							$solicitud->ciclo = $ciclo->id;
							$solicitud->estado = 0;
							if($solicitud->save()){
								$inscripciones ++;
							}
						}
					}
					if($inscripciones != 0){
						$resultado['widget'] = 'Las solicitudes han sido procesadas correctamente.';
					}else{
						$resultado['widget'] = 'No se pudieron procesar las solicitudes';
					}
				}else{
					$validadorAlumno = Validator::make(Input::all(), array(
						'alumno' 	=> 'required',
						'email'		=> 'required|email|unique:sb_alumno,email',
						'facultad'	=> 'required|exists:sb_facultad,id',
						'carrera'	=> 'required|exists:sb_carrera,id'));
					if($validadorAlumno->passes()){
						$nuevoAlumno = new Alumno;
						$nuevoAlumno->matricula = Input::get('matricula');
						$nuevoAlumno->alumno 	= strtoupper(Input::get('alumno'));
						$nuevoAlumno->email 	= Input::get('email');
						$anoIngreso = substr(Input::get('matricula'), -2);
						$ingreso = '20'.$anoIngreso;
						$nuevoAlumno->ingreso 	= $ingreso;
						$nuevoAlumno->prioridad = 999999;
						$nuevoAlumno->facultad 	= Input::get('facultad');
						$nuevoAlumno->carrera 	= Input::get('carrera');
						$nuevoAlumno->save();
						$inscripciones = 0;
						foreach (Input::get('horarios') as $horario) {
							$horarioParte = explode('-', $horario);
							$solicitud = new SolicitudHorario;
							$solicitud->matricula = Input::get('matricula');
							$solicitud->asignatura = $asignatura->id;
							$solicitud->horario_dia = $horarioParte[0];
							$solicitud->horario_hora = $horarioParte[1];
							$solicitud->estado = 0;
							if($solicitud->save()){
								$inscripciones ++;
							}
						}
						if($inscripciones != 0){
							$resultado['widget'] = 'Las solicitudes han sido procesadas correctamente.';
						}else{
							$resultado['widget'] = 'No se pudieron procesar las solicitudes';
						}
					}else{
						$resultado['widget'] = 'Los datos ingresados no son válidos 2';
					}
				}
			}else{
				$resultado['widget'] = 'El alumno ya posee inscripciones activas.';
			}
		}else{
			$resultado['widget'] = 'Los datos ingresados no son válidos 3';
		}
		return $resultado;
	}

	public function getFormNuevoModulo(){
		$resultado['resultado'] = true;
		$resultado['widget'] = View::make('modulo.formularioNuevoModulo')->render();
		return $resultado;
	}

	public function sugerirProfesores(){
		if(isset($_REQUEST['term'])){
			if(Auth::check()){
				$sugeridos = User::select(DB::raw('CONCAT(rut,"-",usuario) AS profesor'))
					->where('categoria', '=', 3)
					->where(function($query){
						$query->where('usuario', 'like', '%'.$_REQUEST['term'].'%')
							->orWhere('rut', 'like', '%'.$_REQUEST['term'].'%');
					})
					->get();
				if($sugeridos->count()){
					foreach ($sugeridos as $sugerido) {
						$resultado[] = array('label' => $sugerido->profesor);
					}
					if(Request::ajax()){
						return Response::json($resultado);
					}else{
						return print_r($resultado);
					}
				}
			}
		}
	}

	public function crearModulo(){
		$resultado['resultado'] = false;
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get()->first();
		if($ciclo->estado != 4){
			$resultado['parte'] = 1;
			$validador = Validator::make(Input::all(), array(
				'asignatura' 	=> 'required|exists:sb_asignatura,id',
				'capacidad'		=> 'required',
				'fInicio'		=> 'required',
				'hDia'			=> 'required',
				'hHora'			=> 'required',
				'hHoraFin' 		=> 'required',
				'profesor'		=> 'required',
				'sala'			=> 'required'));
			if($validador->passes()){
				$resultado['parte'] = 2;
				$profesorModulo = Input::get('profesor');
				$partesProfesor = explode('-', $profesorModulo);
				$profesorFinal = User::where('rut', '=', $partesProfesor[0])
					->where('categoria', '=', 3)
					->get();
				$resultado['profesor'] = $partesProfesor;
				if($profesorFinal->count()){
					$profesor = $profesorFinal->first();
					$horarioOcupado = Modulo::where('profesor', '=', $profesor->id)
						->where('horario_dia', '=', Input::get('hDia'))
						->where('ciclo', '=',$ciclo->id)
						->where(function($query){
							$query->where('horario_hora', '=', Input::get('hHora'))
								->orWhere('horario_hora', '=', Input::get('hHoraFin'))
								->orWhere('horario_hora_fin', '=', Input::get('hHora'))
								->orWhere('horario_hora_fin', '=', Input::get('hHoraFin'));
						})
						->get();
					if($horarioOcupado->count() == 0){
						$prioritario = Input::get('prioritario');
						if($prioritario != 'prioritario'){
							$modPrioritario = 0;
						}else{
							$modPrioritario = 1;
						}
						$resultado['parte'] = 3;
						$modulo = new Modulo;
						$modulo->ciclo 				= $ciclo->id;
						$modulo->modulo 			= Input::get('modulo');
						$modulo->profesor 			= $profesor->id;
						$modulo->asignatura 		= Input::get('asignatura');
						$modulo->capacidad 			= Input::get('capacidad');
						$modulo->horario_dia 		= Input::get('hDia');
						$modulo->horario_hora		= Input::get('hHora');
						$modulo->horario_hora_fin	= Input::get('hHoraFin');
						$modulo->inicio 			= Input::get('fInicio');
						$modulo->sala 				= Input::get('sala');
						$modulo->prioritario 		= $modPrioritario;
						if($modulo->save()){
							$resultado['parte'] = 5;
							$resultado['resultado'] = true;
						}else{
							$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
						}
					}else{
						$resultado['mensaje'] = 'El tutor ya tiene un módulo asignado para el horario.';
					}
				}else{
					$resultado['mensaje'] = 'El tutor ingresado no existe.';
				}
			}else{
				$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
			}
		}else{
			$resultado['mensaje'] = 'Actualmente el ciclo se encuentra cerrado.';
		}
		return $resultado;
	}

	public function inscribirModuloManual(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'solicitud' => 'required|exists:sb_solicitud,id'));
		if($validador->passes()){
			$solicitud = Solicitud::find(Input::get('solicitud'));
			if($solicitud->estado == 0){
				$modulo = $solicitud->modulo()->first();
				$solicitudesActivas = $modulo->solicitudes()->where('estado', '=', 1)->count();
				$alumno = $solicitud->alumno()->first();
				if($modulo->capacidad > $solicitudesActivas){
					$solicitud->estado = 1;
					if($solicitud->save()){
						if($modulo->capacidad == ($solicitudesActivas+1)){
							$modulo->estado = 1;
						}
						$modulosAsignatura = Modulo::where('asignatura', '=', $modulo->asignatura)
							->where('ciclo', '=', $modulo->ciclo)
							->lists('id');

						DB::table('sb_solicitud')
	            					->whereIn('modulo', $modulosAsignatura)
	            					->where('matricula', '=', $solicitud->matricula)
	            					->where('estado', '=', 0)
	            					->update(array('estado' => 2));

						$resultado['resultado'] = true;
						$this->mailInscripcionAlumno($alumno, $modulo);
						$profesor = $modulo->profesor()->first();
						$resultado['mensaje'] = 'La solicitud ha sido procesada correctamente.';
					}else{
						$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
					}
				}else{
					$resultado['mensaje'] = 'La disponibilidad del módulo es insuficiente.';
				}
			}else{
				$resultado['mensaje'] = 'La solicitud no puede ser procesada.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function eliminarInscripcionManual(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'solicitud' => 'required|exists:sb_solicitud,id'));
		if($validador->passes()){
			$solicitud = Solicitud::find(Input::get('solicitud'));
			if($solicitud->estado == 1){
				$modulo = $solicitud->modulo()->first();
				$alumno = $solicitud->alumno()->first();
				$solicitud->estado = 0;
				if($solicitud->save()){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'La solicitud ha sido cancelada correctamente.';
				}else{
					$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
				}
			}else{
				$resultado['mensaje'] = 'La solicitud no puede ser procesada.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function eliminar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' => 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$modulo = Modulo::find(Input::get('modulo'));
			if($modulo->delete()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Módulo borrado correctamente.';
			}
			$resultado['resultado'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	private function mailInscripcionAlumno(Alumno $alumno, Modulo $modulo){
		Mailgun::send('emails.inscripcionModulo',array('alumno' => $alumno, 'modulo' => $modulo), function($message) use($alumno){
			$message->to($alumno->email, $alumno->alumno)->subject('Confirmación módulo tutoría académica');
		});
	}

	public function eliminarPostulacionManual(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'solicitud' => 'required|exists:sb_solicitud,id'));
		if($validador->passes()){
			$solicitud = Solicitud::find(Input::get('solicitud'));
			if($solicitud->estado == 0){
				$solicitud->estado = 2;
				if($solicitud->save()){
					$eliminacion = new Eliminacion;
					$eliminacion->modulo = $solicitud->id;
					$eliminacion->motivo = 3;
					$eliminacion->usuario = Auth::user()->id;
					$eliminacion->save();
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'La solicitud ha sido eliminada correctamente.';
				}else{
					$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
				}
			}else{
				$resultado['mensaje'] = 'La solicitud no puede ser procesada.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function deseliminarPostulacionManual(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'solicitud' => 'required|exists:sb_solicitud,id'));
		if($validador->passes()){
			$solicitud = Solicitud::find(Input::get('solicitud'));
			$modulo = $solicitud->modulo()->first();
			$modulosAsignatura = Modulo::where('asignatura', '=', $modulo->asignatura)->where('ciclo', '=', $modulo->ciclo)->lists('id');
			$solActivaAnterior = Solicitud::whereIn('modulo', $modulosAsignatura)
				->where('matricula', '=', $solicitud->matricula)
				->where('estado', '=', 1)
				->count();
			if($solicitud->estado == 2 && $solActivaAnterior == 0){
				$solicitud->estado = 0;
				if($solicitud->save()){
					$eliminacion = Eliminacion::where('solicitud', '=', $solicitud->id)->get();
					if($eliminacion->count()){
						$eliminacion = $eliminacion->first();
						$eliminacion->delete();
					}
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'La solicitud ha sido recuperada correctamente.';
				}else{
					$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
				}
			}else{
				$resultado['mensaje'] = 'El alumno ya posee una postulación aceptada.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function editar(){
		$resultado['resultado'] = false;
		$resultado['parte'] = 0;
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->get()->first();
		$validador = Validator::make(Input::all(), array(
			'mid' => 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$resultado['parte'] = 1;
			if(Auth::user()->categoria == 1){
				$resultado['parte'] = 1.1;
				//ADMINISTRADOR
				$validadorAdmin = Validator::make(Input::all(), array(
					'capacidad'		=> 'required',
					'fInicio'		=> 'required',
					'hDia'			=> 'required',
					'hHora'			=> 'required',
					'hHoraFin' 		=> 'required',
					'profesor'		=> 'required',
					'sala'			=> 'required'));
				if($validadorAdmin->passes()){
					$resultado['parte'] = 2.1;
					$profesorModulo = Input::get('profesor');
					$partesProfesor = explode('-', $profesorModulo);
					$profesorFinal = User::where('rut', '=', $partesProfesor[0])
						->where('categoria', '=', 3)
						->get();
					$resultado['profesor'] = $partesProfesor;
					if($profesorFinal->count()){
						$resultado['parte'] = 3.1;
						$profesor = $profesorFinal->first();
						$horarioOcupado = Modulo::where('profesor', '=', $profesor->id)
							->where('horario_dia', '=', Input::get('hDia'))
							->where('id', '<>', Input::get('mid'))
							->where('ciclo', '=', $ciclo->id)
							->where(function($query){
								$query->where('horario_hora', '=', Input::get('hHora'))
									->orWhere('horario_hora', '=', Input::get('hHoraFin'))
									->orWhere('horario_hora_fin', '=', Input::get('hHora'))
									->orWhere('horario_hora_fin', '=', Input::get('hHoraFin'));
							})
							->get();
						if($horarioOcupado->count() == 0){
							$resultado['parte'] = 4.1;
							$prioritario = Input::get('prioritario');
							if($prioritario != 'prioritario'){
								$modPrioritario = 0;
							}else{
								$modPrioritario = 1;
							}
							$modulo = Modulo::find(Input::get('mid'));
							$modulo->modulo 			= Input::get('modulo');
							$modulo->profesor 			= $profesor->id;
							$modulo->capacidad 			= Input::get('capacidad');
							$modulo->horario_dia 		= Input::get('hDia');
							$modulo->horario_hora		= Input::get('hHora');
							$modulo->horario_hora_fin	= Input::get('hHoraFin');
							$modulo->inicio 			= Input::get('fInicio');
							$modulo->sala 				= Input::get('sala');
							$modulo->prioritario 		= $modPrioritario;
							if($modulo->save()){
								$resultado['parte'] = 5.1;
								$resultado['resultado'] = true;
							}else{
								$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
							}
						}else{
							$resultado['mensaje'] = 'El tutor ya tiene un módulo asignado para el horario.';
						}
					}else{
						$resultado['mensaje'] = 'El tutor ingresado no existe.';
					}
				}else{
					$resultado['mensaje'] = 'Los datos ingresados no son válidos. 1';
				}
			}else{
				$resultado['parte'] = 1.2;
				//LABORANTE
				$validadorLaborante = Validator::make(Input::all(), array(
					'fInicio'		=> 'required',
					'hDia'			=> 'required',
					'hHora'			=> 'required',
					'hHoraFin' 		=> 'required',
					'sala'			=> 'required'));
				if($validadorLaborante->passes()){
					$resultado['parte'] = 2.2;
					$modulo = Modulo::find(Input::get('mid'));
					$horarioOcupado = Modulo::where('profesor', '=', $modulo->profesor)
						->where('horario_dia', '=', Input::get('hDia'))
						->where('id', '<>', $modulo->id)
						->where('ciclo', '=', $ciclo->id)
						->where(function($query){
							$query->where('horario_hora', '=', Input::get('hHora'))
								->orWhere('horario_hora', '=', Input::get('hHoraFin'))
								->orWhere('horario_hora_fin', '=', Input::get('hHora'))
								->orWhere('horario_hora_fin', '=', Input::get('hHoraFin'));
						})
						->get();
					if($horarioOcupado->count() == 0){
						$resultado['parte'] = 3.2;
						$modulo->horario_dia 		= Input::get('hDia');
						$modulo->horario_hora		= Input::get('hHora');
						$modulo->horario_hora_fin	= Input::get('hHoraFin');
						$modulo->inicio 			= Input::get('fInicio');
						$modulo->sala 				= Input::get('sala');
						if($modulo->save()){
							$resultado['parte'] = 4.2;
							$resultado['resultado'] = true;
						}else{
							$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
						}
					}else{
						$resultado['mensaje'] = 'El tutor ya tiene un módulo asignado para el horario.';
					}
				}else{
					$resultado['mensaje'] = 'Los datos ingresados no son válidos. 2';
				}
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos. 1';
		}
		return $resultado;
	}

}