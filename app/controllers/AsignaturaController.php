<?php

class AsignaturaController extends BaseController {

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

	public function crear(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'codigo'		=> 'required|unique:sb_asignatura,codigo',
			'asignatura'	=> 'required',
			'nivel'			=> 'required',
			'modulos'		=> 'required|integer',
			'facultad'		=> 'required|exists:sb_facultad,id'));
		if($validador->passes()){
			$asignatura = new Asignatura;
			$asignatura->codigo = strtoupper(Input::get('codigo'));
			$asignatura->asignatura = strtoupper(Input::get('asignatura'));
			$asignatura->nivel = Input::get('nivel');
			$asignatura->facultad = Input::get('facultad');
			$asignatura->modulos = Input::get('modulos');
 			if($asignatura->save()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Asignatura creada correctamente.';
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un problema, inténtelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function getAsignaturasByFacultad(){
		
		$resultado['resultado'] = false;
		$idFacultad = Input::get('facultad');
		if($idFacultad != 0){
			$facultad = Facultad::find($idFacultad);
			if($facultad->count()){
				$asignaturasList = $facultad->asignaturas()->select(DB::raw('CONCAT(codigo," - ",asignatura) AS asignatura, id'))->get();
				if($asignaturasList->count()){
					$resultado['resultado'] = true;
					$asignaturas = $asignaturasList->lists('asignatura', 'id');
					$asignaturas[0] = 'Seleccionar Asignatura';
					$resultado['widget'] = View::make('modulo.selectAsignaturasMod', array('asignaturas' => $asignaturas))->render();
				}
			}
		}
		return $resultado;
	}

	public function eliminar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'asignatura' => 'required|exists:sb_asignatura,id'));
		if($validador->passes()){
			$asignatura = Asignatura::find(Input::get('asignatura'));
			if($asignatura->delete()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'Asignatura eliminada con éxito.';
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un problema, inténtelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function importarAsignaturasXLS(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'No se han registrado asignaturas.';
		if (Input::hasFile('import')) {
			$nombre = Input::file('import')->getClientOriginalName();
			$extension = Input::file('import')->getClientOriginalExtension();
			$destino = 'import/asignatura';
			$extPermitidas = array('csv', 'xls', 'xlsx');
			if(in_array($extension, $extPermitidas)){
				$upload = Input::file('import')->move($destino, $nombre);
				if($upload){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Se han registrado correctamente las asignaturas.';
					Excel::load('import/asignatura/'.$nombre, function($reader) {
						$columnas = $reader->toArray();
						$respuesta['guardadas'] = 0;
						$respuesta['errores'] = array();
						if(count($columnas)){
							$facultad = Facultad::lists('id', 'codigo');
							foreach ($columnas as $key => $columna) {
								$validador = Validator::make($columna, array(
									'cod_asigna' => 'required|unique:sb_asignatura,codigo'));
								if($validador->passes()){
									$asignatura = new Asignatura;
									$asignatura->codigo = strtoupper($columna['cod_asigna']);
									$asignatura->asignatura = strtoupper($columna['nom_asigna']);
									$asignatura->nivel = $columna['semestre'];
									$asignatura->facultad = $facultad[$columna['cod_facult']];
									$asignatura->modulos = $columna['modulos'];
									if($asignatura->save()){
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

	public function importarActualizacionXLS(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'No se han actualizado asignaturas.';
		if (Input::hasFile('import')) {
			$nombre = Input::file('import')->getClientOriginalName();
			$extension = Input::file('import')->getClientOriginalExtension();
			$destino = 'import/asignatura';
			$extPermitidas = array('csv', 'xls', 'xlsx');
			if(in_array($extension, $extPermitidas)){
				$upload = Input::file('import')->move($destino, $nombre);
				if($upload){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Se han actualizado correctamente las asignaturas.';
					Excel::load('import/asignatura/'.$nombre, function($reader) {
						$columnas = $reader->toArray();
						$respuesta['guardadas'] = 0;
						$respuesta['errores'] = array();
						if(count($columnas)){
							foreach ($columnas as $key => $columna) {
								$validador = Validator::make($columna, array(
									'cod_asigna' => 'required|exists:sb_asignatura,codigo'));
								if($validador->passes()){
									$asignatura = Asignatura::where('codigo', '=', $columna['cod_asigna'])->first();
									$asignatura->modulos = $columna['modulos'];
									if($asignatura->save()){
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

	public function panelAsignaturas(){
		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'asignatura');
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('alertify', 'jqueryForm', 'jqueryUI'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$dataContainer['title'] = 'Asignaturas';

		$dataContainer['widgets'][] = $this->widgetSideBarAsignatura();
		$dataContainer['widgets'][] = $this->widgetMiddleAsignatura();

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		return View::make('template.panel', array('template' => $templateView));
	}

	private function widgetSideBarAsignatura(){
		$facultades = Facultad::lists('facultad', 'id');
		$facultades[0] = 'Seleccione Facultad';
		$resultado = View::make('asignatura.sideBarPanel', array('facultades' => $facultades));
		return $resultado;
	}

	private function widgetMiddleAsignatura(){
		$asignaturas = Asignatura::orderBy('codigo', 'asc')->take(10)->get();
		$resultado = View::make('asignatura.middlePanel', array('asignaturas' => $asignaturas));
		return $resultado;
	}

	public function widgetBusquedaAsignatura(){
		$resultado['resultado'] = false;
		$asignatura = Input::get('asignatura');
		if(!empty($asignatura)){
			$asignaturas = Asignatura::where(function($query){
					$query->where('asignatura', 'like', '%'.Input::get('asignatura').'%')
						->orWhere('codigo', 'like', '%'.Input::get('asignatura').'%');
				})
				->get();
		}else{
			$asignaturas = Asignatura::all();
		}
		if($asignaturas->count()){
			$resultado['resultado'] = true;
			$resultado['widget'] = View::make('asignatura.middlePanel2', array('asignaturas' => $asignaturas))->render();
		}else{
			$resultado['mensaje'] = 'No se encontraron resultados para su búsqueda.';
		}
		return $resultado;
	}

	public function widgetBusquedaAsignaturaFacultad(){
		$resultado['resultado'] = false;
		$facultad = Input::get('facultad');
		if($facultad != 0){
			$asignaturas = Asignatura::where('facultad', '=', $facultad)->get();
		}else{
			$asignaturas = Asignatura::all();
		}
		if($asignaturas->count()){
			$resultado['resultado'] = true;
			$resultado['widget'] = View::make('asignatura.middlePanel2', array('asignaturas' => $asignaturas))->render();
		}else{
			$resultado['mensaje'] = 'No se encontraron resultados para su búsqueda.';
		}
		return $resultado;
	}

	public function importarPlanDeEstudiosXLS(){
		$resultado['resultado'] = false;
		$resultado['mensaje'] = 'No se han registrado asignaturas a carreras.';
		if (Input::hasFile('import')) {
			$nombre = Input::file('import')->getClientOriginalName();
			$extension = Input::file('import')->getClientOriginalExtension();
			$destino = 'import/asignatura';
			$extPermitidas = array('csv', 'xls', 'xlsx');
			if(in_array($extension, $extPermitidas)){
				$upload = Input::file('import')->move($destino, $nombre);
				if($upload){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Se ha registrado correctamente el plan de estudio.';
					Excel::load('import/asignatura/'.$nombre, function($reader) {
						$columnas = $reader->toArray();
						$respuesta['guardadas'] = 0;
						$respuesta['errores'] = array();
						if(count($columnas)){
							AsignaturaCarrera::truncate();
							foreach ($columnas as $key => $columna) {
								$validador = Validator::make($columna, array(
									'cod_carrer' => 'required|exists:sb_carrera,id',
									'cod_asigna' => 'required|exists:sb_asignatura,codigo'));
								if($validador->passes()){
									$asignatura 			= new AsignaturaCarrera;
									$asignatura->asignatura = $columna['cod_asigna'];
									$asignatura->carrera 	= $columna['cod_carrer'];
									if($asignatura->save()){
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
