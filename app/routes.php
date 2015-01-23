<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function(){

	Route::group(array('before' => 'admin'), function(){

		Route::get('/reportes/tutores/{inicio}/{fin}', 'CicloController@exportarReporteTutores');

		Route::get('/reportes/participacion/{inicio}/{fin}', 'CicloController@exportarReporteSolicitudes');

		/*****RUTAS DE CONFIGURACION*****/

		Route::get('/configuracion', 'ConfiguracionController@panelConfiguracion');

		Route::post('/configuracion/aWidFacultad', 'ConfiguracionController@changeWidgetFacultad');

		Route::post('/configuracion/eliminarFacultad', 'ConfiguracionController@eliminarFacultad');

		Route::post('/configuracion/editarFacultad', 'ConfiguracionController@editarFacultad');

		Route::post('/configuracion/aWidCarrera', 'ConfiguracionController@changeWidgetCarrera');

		Route::post('/configuracion/eliminarCarrera', 'ConfiguracionController@eliminarCarrera');

		Route::post('/configuracion/editarCarrera', 'ConfiguracionController@editarCarrera');

		Route::post('/usuario/crearUsuario', 'UsuarioController@crearUsuario');

		Route::post('/configuracion/setInscripcionesPublicas', 'ConfiguracionController@cambiarFormaInscripciones');

		Route::post('/carrera/carrerasByFacultadConf', 'CarreraController@getCarrerasByFacultadConf');
		
		/*****RUTAS DE CICLOS*****/

		Route::get('/ciclo', 'CicloController@panelCiclos');

		Route::post('/ciclo/abrirCiclo', 'CicloController@abrirCiclo');

		Route::post('/ciclo/cerrarCiclo', 'CicloController@cerrarCiclo');

		Route::post('/ciclo/abrirInscripciones', 'CicloController@abrirInscripciones');

		Route::post('/ciclo/cerrarInscripciones', 'CicloController@cerrarInscripciones');

		Route::post('/ciclo/seleccionarAlumnos', 'CicloController@inscribirAlumnos');

		Route::post('/configuracion/iniciarCiclo', 'CicloController@iniciarCiclo');

		Route::post('/tutores/mailInscripcion', 'CicloController@informarTutores');

		/*****RUTAS DE MODULOS*****/

		Route::post('/modulo/eliminar', 'ModuloController@eliminar');

		Route::post('/modulo/cancelarSolicitud', 'ModuloController@eliminarInscripcionManual');

		Route::post('/modulo/cancelarPostulacion', 'ModuloController@eliminarPostulacionManual');

		Route::post('/modulo/descancelarPostulacion', 'ModuloController@deseliminarPostulacionManual');

		Route::post('modulo/informarEstadoTutoria', 'CicloController@informarTutor');

		/*****RUTAS DE ASISTENCIA*****/

		Route::post('/asistencia/editarAsistencia', 'AsistenciaController@widgetEditarAsistencia');

		Route::post('/asistencia/eliminar', 'AsistenciaController@eliminar');

		Route::post('/asistencia/editAsistencia', 'AsistenciaController@editar');

		/*****RUTAS DE ALUMNO*****/

		Route::post('/alumno/certificadoInscripcion', 'AlumnoController@pdfConstanciaInscripcion');

		Route::post('/alumno/eliminar', 'AlumnoController@eliminar');

		Route::post('/alumno/importarAlumnos', 'AlumnoController@importarAlumnosXLS');

		Route::post('/alumno/importarReprobacion', 'AlumnoController@importarReprobacionXLS');

		/*****RUTAS DE ASIGNATURAS*****/

		Route::post('/asignatura/importarAsignatura', 'AsignaturaController@importarAsignaturasXLS');

		Route::post('/asignatura/buscar', 'AsignaturaController@widgetBusquedaAsignatura');

		Route::post('/asignatura/buscarPorFacultad', 'AsignaturaController@widgetBusquedaAsignaturaFacultad');

		Route::get('/asignatura', 'AsignaturaController@panelAsignaturas');

		Route::post('/asignatura/eliminar', 'AsignaturaController@eliminar');

		Route::post('/asignatura/importarPlan', 'AsignaturaController@importarPlanDeEstudiosXLS');

		Route::post('/asignatura/importarNuevasAsignaturas', 'AsignaturaController@importarActualizacionXLS');

		Route::post('/asignatura/crear', 'AsignaturaController@crear');

		/*****RUTAS DE TUTORES*****/

		Route::post('/tutor/constanciaTutor', 'UsuarioController@pdfConstanciaTutor');

		/*****RUTAS DE USUARIOS*****/

		Route::post('/usuario/eliminarUsuario', 'UsuarioController@eliminar');

		Route::get('/usuario/sugerirUsuario', 'UsuarioController@sugerirUsuario');

		Route::post('/usuario/buscar', 'UsuarioController@buscar');

	});

	Route::group(array('before' => 'tutor'), function(){

		Route::get('/modulos', 'UsuarioController@modulosProfesor');

	});

	Route::group(array('before' => 'adminTutor'), function(){

		Route::post('/profesor/guardarBitacora', 'BitacoraController@guardar');

		Route::post('/profesor/bitacoraHistorica', 'BitacoraController@widgetHistorica');

		Route::post('profesor/guardarAsistencia', 'AsistenciaController@guardar');

		Route::post('/profesor/bitacoraAsistencia', 'AsistenciaController@widgetHistorica');
		
	});

	Route::group(array('before' => 'adminLabTutor'), function(){

		Route::post('/profesor/detalleModulo', 'UsuarioController@detalleModulo');
	
	});

	Route::group(array('before' => 'minlaborante'), function(){

		Route::get('/modulo', 'ModuloController@panelModulos');

		Route::post('/modulo/modulosAsignaturaMod', 'ModuloController@getModulosByAsignaturaMod');

		Route::post('/modulo/informacionModulo', 'ModuloController@getPanelInfoModulo');

		Route::post('/modulo/formNuevoModulo', 'ModuloController@getFormNuevoModulo');

		Route::get('/modulo/sugerirProfesor', 'ModuloController@sugerirProfesores');

		Route::post('/carrera/carrerasByFacultadMod', 'CarreraController@getCarrerasByFacultadModulo');

		Route::get('/alumnos', 'AlumnoController@panelAlumno');	

		Route::post('/alumnos/buscar', 'AlumnoController@widgetBusqueda');	

		Route::post('/alumno/obtenerModulosByCiclo', 'AlumnoController@getModulosByCiclo');

		Route::post('/modulo/crearModulo', 'ModuloController@crearModulo');

		Route::post('/asignatura/asignaturasByFacultad', 'AsignaturaController@getAsignaturasByFacultad');

		Route::get('/inscripcion', 'ModuloController@panelInscripcion');

		Route::post('/modulo/guardarEdicion', 'ModuloController@editar');

		Route::post('/modulo/inscripcionManual', 'ModuloController@inscribirModuloManual');

		Route::post('/modulo/cambiarModuloSolicitud', 'ModuloController@cambiarModuloSolicitud');

		Route::get('/tutores', 'UsuarioController@modulosProfesor');

		Route::post('/profesor/modulosProfesor', 'UsuarioController@widgetSideBarModProfesor');

	});

	Route::group(array('before' => 'adminVisita'), function(){
		
		Route::get('/dashboard/{ciclo?}', 'DashboardController@panelIndicadores');

		Route::get('/dashboard/facultad/{idFacultad}/{ciclo?}/{facultad?}', 'DashboardController@panelIndicadoresFacultad');

		Route::get('/dashboard/carrera/{idCarrera}/{ciclo?}/{carrera?}', 'DashboardController@panelIndicadoresCarrera');
	
	});

	Route::get('/usuario/salir', 'UsuarioController@cerrarSesion');

});

Route::get('/', 'ModuloController@panelInscripcion');

Route::get('/admin', 'UsuarioController@mostrarLoginAdmin');

Route::post('/usuario/login', 'UsuarioController@validarLogin');

Route::post('/alumno/getInsInfoAlu', 'AlumnoController@getInfoInscripcion');

Route::post('/modulo/modulosAsignatura', 'ModuloController@getModulosByAsignatura');

Route::post('/modulo/inscribirAluHorario', 'ModuloController@inscribirHorarioModulo');

Route::post('/modulo/horarioAsignatura', 'ModuloController@getHorarioByAsignatura');

Route::post('/modulo/byHorarioAsignatura', 'ModuloController@getModuloByHorarioAsignatura');

Route::post('/modulo/inscribirAlu', 'ModuloController@inscribirModulo');

Route::post('/carrera/carrerasByFacultad', 'CarreraController@getCarrerasByFacultadMod');

Route::post('/asignatura/AsignaturasByCarrera', 'AsignaturaController@getAsignaturasByCarrera');

Route::get('/config', function(){
	return View::make('configuracionPanel');
});

Route::get('/insertarAlumnos', 'AlumnoController@insertarAlumnos');