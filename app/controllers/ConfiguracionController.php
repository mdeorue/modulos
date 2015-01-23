<?php

class ConfiguracionController extends BaseController {

	public function panelConfiguracion(){
		$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'configuracion');
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('alertify', 'jqueryForm', 'jqueryUI'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$dataContainer['title'] = 'Configuración';

		$dataContainer['widgets'][] = $this->widgetInsPub();
		$dataContainer['widgets'][] = $this->widgetFacultad();
		$dataContainer['widgets'][] = $this->widgetCarrera();
		$dataContainer['widgets'][] = $this->widgetUsuario();
		$dataContainer['widgets'][] = $this->widgetListaUsuarios();

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		return View::make('template.panel', array('template' => $templateView));
	}

	private function widgetFacultad(){

		$facultades['facultades'] = Facultad::all()->lists('facultad', 'id');
		$facultades['facultades'][0] = 'Seleccione Facultad';
		$resultado = View::make('configuracion.widgetFacultad', $facultades);
		return $resultado;

	}

	private function widgetUsuario(){
		$carreras['carreras'] = Carrera::all()->lists('carrera', 'id');
		$carreras['carreras'][0] = 'Seleccione una carrera';
		$resultado = View::make('configuracion.widgetUsuario', $carreras);
		return $resultado;

	}

	private function widgetListaUsuarios(){

		$usuarios = User::take(5)->orderBy('id', 'desc')->get();
		$resultado = View::make('configuracion.widgetListaUsuarios', array('usuarios' => $usuarios));
		return $resultado;

	}

	private function widgetCiclo(){
		$ciclo['ciclo'] = Ciclo::orderBy('id', 'desc')->take(1)->first();
		if($ciclo['ciclo']->count()){
			$resultado = View::make('configuracion.widgetCiclo', $ciclo);
		}
		return $resultado;

	}

	private function widgetInsPub(){
		$configuracion['config'] = Configuracion::orderBy('id', 'desc')->take(1)->first();
		$resultado = View::make('configuracion.widgetInsPub', $configuracion);
		return $resultado;

	}

	private function widgetCarrera(){

		$carreras['facultades'] = Facultad::all()->lists('facultad', 'id');
		$carreras['facultades'][0] = 'Seleccione Facultad';
		$resultado = View::make('configuracion.widgetCarrera', $carreras);
		return $resultado;

	}

	public function changeWidgetFacultad(){

		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'facultad' => 'required|integer'));
		if($validador->passes()){
			if(Input::get('facultad') != 0){
				$facultades['facultad'] = Facultad::find(Input::get('facultad'));
				if($facultades['facultad']->count()){
					$resultado['resultado'] 		= true;
					$facultades['facultades'] 		= Facultad::all()->lists('facultad', 'id');
					$facultades['facultades'][0] 	= 'Seleccione Facultad';
					$resultado['widget'] 			= View::make('configuracion.changeWidgetFacultad', $facultades)->render();
				}
			}else{
				$resultado['resultado'] 		= true;
				$facultades['facultades'] 		= Facultad::all()->lists('facultad', 'id');
				$facultades['facultades'][0] 	= 'Seleccione Facultad';
				$resultado['widget'] 			= View::make('configuracion.changeWidgetFacultad', $facultades)->render();
			}
		}
		return $resultado;

	}

	public function changeWidgetCarrera(){

		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'carrera' => 'required|integer'));
		if($validador->passes()){
			if(Input::get('carrera') != 0){
				$carreras['carrera'] = Carrera::find(Input::get('carrera'));
				if($carreras['carrera']->count()){
					$resultado['resultado'] 	= true;
					$carreras['facultad']		= Facultad::find($carreras['carrera']->facultad);
					$carreras['facultades']		= Facultad::all()->lists('facultad', 'id');
					$carreras['facultades'][0] 	= 'Seleccione facultad';
					$carreras['carreras'] 		= Carrera::all()->lists('carrera', 'id');
					$carreras['carreras'][0]	= 'Seleccione carrera';
					$resultado['widget'] 		= View::make('configuracion.changeWidgetCarrera', $carreras)->render();
				}
			}else{
				$resultado['resultado'] 		= true;
				$carreras['facultades'] 		= Facultad::all()->lists('facultad', 'id');
				$carreras['facultades'][0] 		= 'Seleccione Facultad';
				$resultado['widget'] = View::make('configuracion.changeWidgetCarrera', $carreras)->render();
			}
		}
		return $resultado;

	}

	public function eliminarFacultad(){

		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), 
			array(
				'facultad' => 'required|exists:sb_facultad,id'
			)
		);
		if($validador->passes()){
			$facultad = Facultad::find(Input::get('facultad'));
			if($facultad->count()){
				if($facultad->delete()){
					$resultado['resultado'] = true;
					$facultades['facultades'] = Facultad::all()->lists('facultad', 'id');
					$facultades['facultades'][0] 	= 'Seleccione Facultad';
					$resultado['widget'] 			= View::make('configuracion.changeWidgetFacultad', $facultades)->render();
				}
			}
		}
		return $resultado;	
	}

	public function eliminarCarrera(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), 
			array(
				'carrera' => 'required|exists:sb_carrera,id'
			)
		);
		if($validador->passes()){
			$carrera = Carrera::find(Input::get('carrera'));
			if($carrera->count()){
				if($carrera->delete()){
					$resultado['resultado'] = true;
					$carreras['facultades'] 		= Facultad::all()->lists('facultad', 'id');
					$carreras['facultades'][0] 		= 'Seleccione Facultad';
					$resultado['widget'] = View::make('configuracion.changeWidgetCarrera', $carreras)->render();
				}
			}
		}
		return $resultado;	
	}

	public function cambiarFormaInscripciones(){
		$resultado['resultado'] = false;
		$configuracion = Configuracion::orderBy('id', 'desc')->take(1)->first();
		$insPublico = Input::get('publica');
		$insPub = 0;
		if(isset($insPublico)){
			$insPub = 1;
		}
		$configuracion->ins_pub = $insPub;
		if($configuracion->save()){
			$resultado['resultado'] = true;
		}
		$resultado['insPublico'] = $insPublico;
		return $resultado;
	}

	public function editarFacultad(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'facultad' 	=> 'required',
			'codigo' 	=> 'required',
			'facuTxt'	=> 'required'
		));

		if($validador->passes()){
			if(Input::get('facultad') != 0){
				$facultad = Facultad::find(Input::get('facultad'));
				if($facultad->count()){
					$facultad->codigo = strtoupper(Input::get('codigo'));
					$facultad->facultad = strtoupper(Input::get('facuTxt'));
					if($facultad->save()){
						$resultado['resultado'] = true;
						$resultado['mensaje'] = 'Facultad editada correctamente';
						$facultades['facultades'] = Facultad::all()->lists('facultad', 'id');
						$facultades['facultades'][0] 	= 'Seleccione Facultad';
						$resultado['widget'] 			= View::make('configuracion.changeWidgetFacultad', $facultades)->render();
					}else{
						$resultado['mensaje'] = 'La facultad no ha podido ser editada.';
					}
				}else{
					$resultado['mensaje'] = 'La facultad no ha podido ser editada.';
				}
			}else{
				$facultad = new Facultad;
				$facultad->codigo = strtoupper(Input::get('codigo'));
				$facultad->facultad = strtoupper(Input::get('facuTxt'));
				if($facultad->save()){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Facultad creada correctamente.';
					$facultades['facultades'] = Facultad::all()->lists('facultad', 'id');
					$facultades['facultades'][0] 	= 'Seleccione Facultad';
					$resultado['widget'] 			= View::make('configuracion.changeWidgetFacultad', $facultades)->render();
				}else{
					$resultado['mensaje'] = 'La facultad no ha podido ser creada.';
				}
			}
		}else{
			$resultado['mensaje'] = 'La transacción no pude ser realizada.';
		}
		return $resultado;
	}

	public function editarCarrera(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'facultad'	=> 'required|exists:sb_facultad,id',
			'carrera' 	=> 'required',
			'codigo' 	=> 'required|integer',
			'carrTxt'	=> 'required'
		));

		if($validador->passes()){
			if(Input::get('carrera') != 0){
				$carrera = Carrera::find(Input::get('carrera'));
				if($carrera->count()){
					$carrera->id = Input::get('codigo');
					$carrera->carrera = strtoupper(Input::get('carrTxt'));
					if($carrera->save()){
						$resultado['resultado'] = true;
						$resultado['mensaje'] = 'Carrera editada correctamente';
						$carreras['facultades'] 		= Facultad::all()->lists('facultad', 'id');
						$carreras['facultades'][0] 		= 'Seleccione Facultad';
						$resultado['widget'] = View::make('configuracion.changeWidgetCarrera', $carreras)->render();
					}else{
						$resultado['mensaje'] = 'La carrera no ha podido ser editada.';
					}
				}else{
					$resultado['mensaje'] = 'La carrera no ha podido ser editada.';
				}
			}else{
				$carrera = new Carrera;
				$carrera->id = Input::get('codigo');
				$carrera->carrera = strtoupper(Input::get('carrTxt'));
				$carrera->facultad = Input::get('facultad');
				if($carrera->save()){
					$resultado['resultado'] = true;
					$resultado['mensaje'] = 'Carrera creada correctamente.';
					$carreras['facultades'] 		= Facultad::all()->lists('facultad', 'id');
					$carreras['facultades'][0] 		= 'Seleccione Facultad';
					$resultado['widget'] = View::make('configuracion.changeWidgetCarrera', $carreras)->render();
				}else{
					$resultado['mensaje'] = 'La carrera no ha podido ser creada.';
				}
			}
		}else{
			$resultado['mensaje'] = 'La transacción no pude ser realizada.';
		}
		return $resultado;
	}

}