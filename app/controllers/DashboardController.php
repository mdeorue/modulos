<?php

class DashboardController extends BaseController {

	private $ciclo = null;
	private $modulos = null;

	public function panelIndicadores($ciclo = null){
		if(is_null($ciclo)){
			$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first()->id;
		}

		$this->setCiclo($ciclo);

		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'dashboard');
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs();
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$dataContainer['title'] = 'Panel de Indicadores';

		if(count($this->modulos)){

			$dataContainer['widgets'][] = $this->panelIndicadoresBasicos();
			$dataContainer['widgets'][] = $this->tefKPI();
			$dataContainer['widgets'][] = $this->tecKPI();
			$dataContainer['widgets'][] = $this->tleaKPI();

		}else{

			$dataContainer['widgets'][] = View::make('template.msgError', array(
				'mensaje' => 'No existen módulos para el ciclo seleccionado.'));

		}

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);
	
		return View::make('template.panel', array('template' => $templateView));
	}

	public function panelIndicadoresFacultad($idFacultad, $ciclo = null, $facultad = null){
		if(is_null($ciclo)){
			$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first()->id;
		}

		$validador = Validator::make(array(
			'facultad' => 'idFacultad'), 
			array('
				facultad' => 'exists:sb_facultad,id')
		);

		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'dashboard');
		$templateView['navbar'] = View::make('template.header', $menus);
			
		$footerJs = Template::footerJs();
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		if($validador->passes()){

			$facultadData = Facultad::find($idFacultad);
			$this->setCicloFacultad($ciclo, $facultadData);

			$dataContainer['title'] = $facultadData->facultad;

			if(count($this->modulos)){

				$dataContainer['widgets'][] = $this->panelIndicadoresBasicos();
				$dataContainer['widgets'][] = $this->tecKPI();
				$dataContainer['widgets'][] = $this->tleaKPI();

			}else{

				$dataContainer['widgets'][] = View::make('template.msgError', array(
					'mensaje' => 'No existen módulos para el ciclo seleccionado.'));

			}

			$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		}	

		return View::make('template.panel', array('template' => $templateView));	
	}

	public function panelIndicadoresCarrera($idCarrera, $ciclo = null, $carrera = null){
		if(is_null($ciclo)){
			$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first()->id;
		}

		$validador = Validator::make(array(
			'carrera' => 'idCarrera'), 
			array('
				carrera' => 'exists:sb_carrera,id')
		);

		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'dashboard');
		$templateView['navbar'] = View::make('template.header', $menus);
			
		$footerJs = Template::footerJs();
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		if($validador->passes()){

			$carreraData = Carrera::find($idCarrera);
			$this->setCicloCarrera($ciclo, $carreraData);

			$dataContainer['title'] = $carreraData->carrera;

			if(count($this->modulos)){

				$dataContainer['widgets'][] = $this->panelIndicadoresBasicos();
				$dataContainer['widgets'][] = $this->tefKPI();
				$dataContainer['widgets'][] = $this->tleaKPI();

			}else{

				$dataContainer['widgets'][] = View::make('template.msgError', array(
					'mensaje' => 'No existen módulos para el ciclo seleccionado.'));

			}

			$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		}	

		return View::make('template.panel', array('template' => $templateView));	
	}

	public function setCiclo($idCiclo){
		$this->ciclo = Ciclo::find($idCiclo);
		$this->modulos = $this->ciclo->modulos()->lists('id');
	}

	public function setCicloFacultad($idCiclo, Facultad $facultad){
		$asignaturas = $facultad->asignaturas->lists('id');
		$this->ciclo = Ciclo::find($idCiclo);
		if(count($asignaturas)){
			$this->modulos = $this->ciclo->modulos()->whereIn('asignatura', $asignaturas)->lists('id');
		}
	}

	public function setCicloCarrera($idCiclo, Carrera $carrera){
		$asignaturas = $carrera->asignaturas->lists('id');
		$this->ciclo = Ciclo::find($idCiclo);
		if(count($asignaturas)){
			$this->modulos = $this->ciclo->modulos()->whereIn('asignatura', $asignaturas)->lists('id');
		}
	}

	private function panelIndicadoresBasicos(){
		$indicadores[] = $this->tmaKPI();
		$indicadores[] = $this->nbnaKPI();
		$indicadores[] = $this->bnaKPI();
		$indicadores[] = $this->tleKPI();
		$indicadores[] = $this->unaHoraKPI();
		$indicadores[] = $this->tamKPI();
		$indicadores[] = $this->teiKPI();
		$resultado = View::make('dashboard.indicadoresBasicos', array('indicadores' => $indicadores));
		return $resultado;
	}

	private function tmaKPI(){
		$resultado['indicador'] = 'Estudiantes con módulo asignado';
		$tma = Solicitud::whereIn('modulo', $this->modulos)
			->where('estado', '=', 1)
			->groupBy('matricula')
			->get();
		$resultado['valor'] = $tma->count();
		return $resultado;
	}

	private function nbnaKPI(){
		$resultado['indicador'] = 'Estudiantes sin beca BNA';
		$nbna = Solicitud::join('sb_alumno', function($join){
				$join->on('sb_solicitud.matricula', '=', 'sb_alumno.matricula')
					->where('sb_alumno.prioridad', '<>', 1);
			})
			->whereIn('sb_solicitud.modulo', $this->modulos)
			->where('sb_solicitud.estado', '=', 1)
			->groupBy('sb_solicitud.matricula')
			->get();
		$resultado['valor'] = $nbna->count();
		return $resultado;
	}

	private function bnaKPI(){
		$resultado['indicador'] = 'Estudiantes con beca BNA';
		$bna = Solicitud::join('sb_alumno', function($join){
				$join->on('sb_solicitud.matricula', '=', 'sb_alumno.matricula')
					->where('sb_alumno.prioridad', '=', 1);
			})
			->whereIn('sb_solicitud.modulo', $this->modulos)
			->where('sb_solicitud.estado', '=', 1)
			->groupBy('sb_solicitud.matricula')
			->get();
		$resultado['valor'] = $bna->count();
		return $resultado;
	}

	private function tefKPI(){
		$tefs = Solicitud::select(DB::raw('COUNT(sb_alumno.matricula) AS alumnos, sb_facultad.facultad, sb_facultad.id AS idFacultad'))
			->join('sb_alumno', 'sb_solicitud.matricula', '=', 'sb_alumno.matricula')
			->join('sb_facultad', 'sb_alumno.facultad', '=', 'sb_facultad.id')
			->whereIn('sb_solicitud.modulo', $this->modulos)
			->where('sb_solicitud.estado', '=', 1)
			->groupBy('sb_alumno.facultad')
			->get();
		$resultado = View::make('dashboard.tef', array('tefs' => $tefs, 'ciclo' => $this->ciclo));
		return $resultado;
	}	

	private function tecKPI(){
		$tecs = Solicitud::select(DB::raw('COUNT(sb_alumno.matricula) AS alumnos, sb_carrera.carrera, sb_carrera.id AS idCarrera'))
			->join('sb_alumno', 'sb_solicitud.matricula', '=', 'sb_alumno.matricula')
			->join('sb_carrera', 'sb_alumno.carrera', '=', 'sb_carrera.id')
			->whereIn('sb_solicitud.modulo', $this->modulos)
			->where('sb_solicitud.estado', '=', 1)
			->groupBy('sb_alumno.carrera')
			->get();
		$resultado = View::make('dashboard.tec', array('tecs' => $tecs, 'ciclo' => $this->ciclo));
		return $resultado;
	}

	private function tleKPI(){
		$resultado['indicador'] = 'Estudiantes en lista de espera';
		$tle = Solicitud::join('sb_modulo', function($join){
				$join->on('sb_solicitud.modulo', '=', 'sb_modulo.id')
					->where('sb_modulo.ciclo', '=', $this->ciclo->id);
			})
			->where('sb_solicitud.estado', '=', 0)
			->groupBy('sb_solicitud.matricula')
			->get();
		$resultado['valor'] = $tle->count();
		return $resultado;
	}	

	private function tleaKPI(){
		$tleas = Solicitud::select(DB::raw('COUNT(sb_solicitud.id) AS alumnos, sb_asignatura.asignatura'))
			->join('sb_modulo', 'sb_solicitud.modulo', '=', 'sb_modulo.id')
			->join('sb_asignatura', 'sb_modulo.asignatura', '=', 'sb_asignatura.id')
			->whereIn('sb_solicitud.modulo', $this->modulos)
			->where('sb_solicitud.estado', '=', 0)
			->groupBy('sb_asignatura.codigo')
			->get();
		$resultado = View::make('dashboard.tlea', array('tleas' => $tleas));
		return $resultado;
	}

	private function tamKPI(){
		$resultado['indicador'] = 'Asignaturas con módulo';
		$tam = Modulo::where('ciclo', '=', $this->ciclo->id)
			->groupBy('asignatura')
			->get();
		$resultado['valor'] = $tam->count();
		return $resultado;
	}

	private function teiKPI(){
		$resultado['indicador'] = 'Alumnos eliminados por inasistencia';
		$tei = Modulo::select('sb_eliminacion.id')
			->join('sb_solicitud', 'sb_modulo.id', '=', 'sb_solicitud.modulo')
			->join('sb_eliminacion', 'sb_solicitud.id', '=', 'sb_eliminacion.solicitud')
			->whereIn('sb_modulo.id', $this->modulos)
			->count();
		$resultado['valor'] = $tei;
		return $resultado;
	}

	private function unaHoraKPI(){
		$resultado['indicador'] = 'Estudiantes con al menos una hora de tutoria';
		$unaHora = Asistencia::select(DB::raw('sb_asistencia.matricula, SUM(sb_asistencia.hora_asis) AS asistencia'))
			->whereIn('modulo', $this->modulos)
			->groupBy('matricula')
			->having('asistencia', '>', 1)
			->get();
		$unaHora = $unaHora->count();
		$resultado['valor'] = $unaHora;
		return $resultado;
	}

}
