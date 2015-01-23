<?php

class UsuarioController extends BaseController {

	public function mostrarLoginAdmin(){

		if(Auth::check()){
			return Redirect::to('/configuracion');
		}else{
			$menus = Template::crearMenu();
			$templateView['navbar'] = View::make('template.header', $menus);
		
			$footerJs = Template::footerJs();
			$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

			$templateView['container'] = View::make('usuario.adminLogin');

			return View::make('template.panel', array('template' => $templateView));
		}
	
	}

	public function mostrarLoginProfesor(){

		if(Auth::check()){
			return Redirect::to('/profesor/panel');
		}else{
			$menus = Template::crearMenu();
			$templateView['navbar'] = View::make('template.header', $menus);
		
			$footerJs = Template::footerJs();
			$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

			$templateView['container'] = View::make('usuario.profesorLogin');

			return View::make('template.panel', array('template' => $templateView));
		}
	
	}

	public function validarLogin(){
		$validador = Validator::make(Input::all(), 
			array(
				'rut'		=> 'required|min:8',
				'password'	=> 'required'
			)
		);

		if($validador->passes()){
			$intentoLogin = Auth::attempt(array(
				'rut'	=> Input::get('rut'),
				'password'	=> Input::get('password')
			));
			if($intentoLogin){
				if(Auth::user()->categoria == 3){
					return Redirect::intended('/modulos');
				}else{
					return Redirect::intended('/configuracion');
				}
			}else{
				return Redirect::to('admin')
					->with('mensajeError', 'El rut y/o contraseña no son válidos.')
					->withInput();
			}
		}else{
			return Redirect::to('admin')
				->with('mensajeError', 'Los datos ingresados no son válidos.')
				->withInput();
		}
	}

	public function cerrarSesion(){
		Auth::logout();
		return Redirect::to('/');
	}

	public function crearUsuario(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'rut' => 'required|unique:sb_usuario,rut',
			'usuario' =>'required',
			'categoria' => 'required',
			'email' => 'required|email'));
		if($validador->passes()){
			$usuario = new User;
			$usuario->rut 		= strtoupper(Input::get('rut'));
			$usuario->usuario 	= strtoupper(Input::get('usuario'));
			$usuario->categoria	= Input::get('categoria');
			$usuario->password 	= Hash::make(Input::get('rut'));
			$usuario->email 	= Input::get('email');
			$usuario->carrera 	= 0;
			if(Input::get('categoria') == 3){
				$validadorDos = Validator::make(Input::all(), array(
					'carrera' => 'required|exists:sb_carrera,id'));
				if($validadorDos->passes()){
					$usuario->carrera 	= Input::get('carrera');
				}
			}
			
			if($usuario->save()){
				$resultado['resultado'] = true;
				$resultado['mensaje'] = 'El usuario fue creado correctamente.';
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un error, inténtelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function modulosProfesor(){

		if(Auth::user()->categoria == 3){
			$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'modulos');	
			$dataContainer['title'] = 'Mis Módulos';
			$dataContainer['widgets'][] = $this->widgetSideBarModProfesor();
		}elseif(Auth::user()->categoria == 1 || Auth::user()->categoria == 2){
			$menus = Template::crearMenu('cat'.Auth::user()->categoria, 'tutores');
			$dataContainer['title'] = 'Panel Tutores';
			$dataContainer['widgets'][] = $this->widgetBuscadorProfesor();
		}else{
			$menus = Template::crearMenu();
		}
		
		$templateView['navbar'] = View::make('template.header', $menus);
		
		$footerJs = Template::footerJs(array('alertify', 'jqueryForm', 'jqueryUI'));
		$templateView['jsScript'] = View::make('template.footerScript', $footerJs);

		$templateView['container'] = View::make('template.widgetContainer', $dataContainer);

		return View::make('template.panel', array('template' => $templateView));
	}

	public function widgetSideBarModProfesor(){
		$ciclo = Ciclo::orderBy('id', 'desc')->take(1)->first();
		if(Auth::user()->categoria == 1 || Auth::user()->categoria == 2){
			$resultado['resultado'] = false;
			if(Input::has('profesor')){
				$prof = Input::get('profesor');
				$profesorArray = explode('-', $prof);
				$profesor = User::where('rut', '=', $profesorArray[0])->take(1)->get();
				if($profesor->count()){
					$profesor = $profesor->first();
					$modulos = Modulo::where('profesor', '=', $profesor->id)->where('ciclo', '=', $ciclo->id)->get();
					$ciclos = Ciclo::select(DB::raw('CONCAT(sb_ciclo.semestre,"-",sb_ciclo.ano) as periodo, sb_ciclo.id'))
						->join('sb_modulo', function($join) use($profesor){
							$join->on('sb_ciclo.id', '=', 'sb_modulo.ciclo')
								->where('sb_modulo.profesor', '=', $profesor->id);
						})
						->lists('periodo', 'id');
					if($modulos->count()){
						$resultado['resultado'] = true;
						$resultado['widget'] = View::make('profesor.sideBarPanel', array('modulos' => $modulos, 'profesor' => $profesor->id, 'ciclo' => $ciclos))->render();
					}else{
						$resultado['mensaje'] = 'El tutor no posee módulos asignados.';
					}
				}else{
					$resultado['mensaje'] = 'El profesor seleccionado no es válido.';
				}
			}else{
				$resultado['mensaje'] = 'Los valores ingresados no son válidos.';
			}
		}else{
			$modulos = Modulo::where('profesor', '=', Auth::user()->id)->where('ciclo', '=', $ciclo->id)->get();
			$resultado = View::make('profesor.sideBarPanel', array('modulos' => $modulos));
		}
		return $resultado;
	}

	private function widgetBuscadorProfesor(){
		$resultado = View::make('profesor.buscador');
		return $resultado;
	}

	public function detalleModulo(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'modulo' => 'required|exists:sb_modulo,id'));
		if($validador->passes()){
			$moduloInfo['modulo'] = Modulo::find(Input::get('modulo'));
			$moduloInfo['activas'] = $moduloInfo['modulo']
				->solicitudes()
				->where('estado', '=', 1)
				->get();
			$resultado['resultado'] = true;
			$resultado['widget'] = View::make('profesor.detalleModulo', $moduloInfo)->render();
		}
		return $resultado;	
	}

	public function pdfConstanciaTutor(){
		$validador = Validator::make(Input::all(), array(
			'ciclo' => 'required|exists:sb_ciclo,id',
			'profesor' => 'required|exists:sb_usuario,id'));
		if($validador->passes()){
			$viewData['profesor'] = User::find(Input::get('profesor'));
			$viewData['ciclo'] = Ciclo::find(Input::get('ciclo'));
			$pdf = PDF::loadView('pdf.constanciaTutor', $viewData);
			return $pdf->stream();
		}else{
			View::make('alumno.errorCertificado', array('mensaje' => 'Los datos ingresados no son válidos.'));
		}
	}

	public function eliminar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'usuario' => 'required|exists:sb_usuario,id'));
		if($validador->passes()){
			$usuario = User::find(Input::get('usuario'));
			if($usuario->delete()){
				$resultado['resultado']	= true;
				$resultado['mensaje'] 	= 'Usuario eliminado con éxito.'; 
			}else{
				$resultado['mensaje'] = 'Ha ocurrido un problema, inténtelo nuevamente.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}

	public function sugerirUsuario(){
		if(isset($_REQUEST['term'])){
			if(Auth::check()){
				$sugeridos = User::select(DB::raw('CONCAT(rut,"-",usuario) AS usuario'))
					->where('usuario', 'like', '%'.$_REQUEST['term'].'%')
					->orWhere('rut', 'like', '%'.$_REQUEST['term'].'%')
					->get();
				if($sugeridos->count()){
					foreach ($sugeridos as $sugerido) {
						$resultado[] = array('label' => $sugerido->usuario);
					}
					if(Request::ajax()){
						return Response::json($resultado);
					}else{
						return var_dump($resultado);
					}
				}
			}
		}
	}

	public function buscar(){
		$resultado['resultado'] = false;
		$validador = Validator::make(Input::all(), array(
			'usuario' => 'required'));
		if($validador->passes()){
			$usuario = Input::get('usuario');
			$parteUsuario = explode('-', $usuario);
			$usuarios = User::where('rut', '=', $parteUsuario[0])->get();
			if($usuarios->count()){
				$resultado['widget'] = View::make('configuracion.usuarioBuscado', array('usuarios' => $usuarios))->render();
				$resultado['resultado'] = true;
			}else{
				$resultado['mensaje'] = 'No se obtuvieron resultados.';
			}
		}else{
			$resultado['mensaje'] = 'Los datos ingresados no son válidos.';
		}
		return $resultado;
	}
}