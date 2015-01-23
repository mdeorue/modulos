<?php namespace Template;

class Template {

    public static function crearMenu($tipo = null, $active = null)
    {
    	switch ($tipo) {
    		case null:
    			$resultado['menues'] = null;
    			break;
    		
    		case 'cat1':
    			$temp = new Template();
    			$resultado['menues'] = $temp->basicMenu($active);
    			break;

            case 'cat2':
                $temp = new Template();
                $resultado['menues'] = $temp->menuLaborante($active);
                break;

            case 'cat3':
                $temp = new Template();
                $resultado['menues'] = $temp->menuTutor($active);
                break;

            case 'cat4':
                $temp = new Template();
                $resultado['menues'] = $temp->menuVisita($active);
                break;

    		default:
    			$resultado['menues'] = null;
    			break;
    	}
    	return $resultado;
    }

    public static function footerJs($arrayJs = null){

        $temp = new Template();

        //Insertar Js Básico
        $resultado['footerJs'][] = $temp->agregarJs('bootstrap');

        if(!is_null($arrayJs)){
            foreach ($arrayJs as $js) {
                $resultado['footerJs'][] = $temp->agregarJs($js);
            }
        }
        
        $resultado['footerJs'][] = $temp->agregarJs('modulos');

        return $resultado;

    }

    public static function getHorarioBasico(){

        //Modulos
        $resultado['modulo'][0][0] = 'Hora/Dia';
        $resultado['modulo'][0][1] = 'Lunes';
        $resultado['modulo'][0][2] = 'Martes';
        $resultado['modulo'][0][3] = 'Miercoles';
        $resultado['modulo'][0][4] = 'Jueves';
        $resultado['modulo'][0][5] = 'Viernes';

        $resultado['modulo'][1][0] = '8:30 - 9:30';
        $resultado['modulo'][2][0] = '9:40 - 10:40';
        $resultado['modulo'][3][0] = '10:50 - 11:50';
        $resultado['modulo'][4][0] = '12:00 - 13:00';
        $resultado['modulo'][5][0] = '13:10 - 14:10';
        $resultado['modulo'][6][0] = '14:30 - 15:30';
        $resultado['modulo'][7][0] = '15:40 - 16:40';
        $resultado['modulo'][8][0] = '16:50 - 17:50';
        $resultado['modulo'][9][0] = '18:00 - 19:00';
        $resultado['modulo'][10][0] = '19:10 - 20:10';
        $resultado['modulo'][11][0] = '20:20 - 21:20';


        //Clases
        $resultado['clase'][0][0] = 'head-table';
        $resultado['clase'][0][1] = 'head-table';
        $resultado['clase'][0][2] = 'head-table';
        $resultado['clase'][0][3] = 'head-table';
        $resultado['clase'][0][4] = 'head-table';
        $resultado['clase'][0][5] = 'head-table';

        $resultado['clase'][1][0] = 'head-table';
        $resultado['clase'][2][0] = 'head-table';
        $resultado['clase'][3][0] = 'head-table';
        $resultado['clase'][4][0] = 'head-table';
        $resultado['clase'][5][0] = 'head-table';
        $resultado['clase'][6][0] = 'head-table';
        $resultado['clase'][7][0] = 'head-table';
        $resultado['clase'][8][0] = 'head-table';
        $resultado['clase'][9][0] = 'head-table';
        $resultado['clase'][10][0] = 'head-table';
        $resultado['clase'][11][0] = 'head-table';

        return $resultado;

    }

    public function agregarJs($js){
        $resultado = '';
        switch ($js) {
            case 'jquery':
                $resultado = '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js';
                break;

            case 'bootstrap':
                $resultado = 'js/bootstrap.min.js';
                break;

            case 'modulos':
                $resultado = 'js/modulos-script.js?v=1.0';
                break;

            case 'jqueryForm':
                $resultado = 'js/jquery.form.min.js';
                break;

            case 'alertify':
                $resultado = '//cdnjs.cloudflare.com/ajax/libs/alertify.js/0.3.11/alertify.min.js';
                break;

            case 'jqueryUI':
                $resultado = '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js';
                break;
            
            default:
                $resultado = '';
                break;
        }

        return $resultado;
    }   

    public function basicMenu($active = null){
        $menu[] = array(
            'active'    => '',
            'url'       => url('/inscripcion'),
            'menu'      => 'Inscripción');
        $menuNombre[] = 'inscripcion';

        $menu[]    = array(
            'active'    => '',
            'url'       => url('/dashboard'),
            'menu'      => 'Dashboard');
        $menuNombre[] = 'dashboard';

        $menu[]    = array(
            'active'    => '',
            'url'       => url('/tutores'),
            'menu'      => 'Tutores');
        $menuNombre[] = 'tutores';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/alumnos'),
            'menu'      => 'Alumnos');
        $menuNombre[] = 'alumnos';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/asignatura'),
            'menu'      => 'Asignaturas');
        $menuNombre[] = 'asignatura';

        $menu[]	= array(
    		'active'	=> '',
    		'url'		=> url('/modulo'),
    		'menu'		=> 'Módulos');
        $menuNombre[] = 'modulos';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/ciclo'),
            'menu'      => 'Ciclos');
        $menuNombre[] = 'ciclo';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/configuracion'),
            'menu'      => 'Configuración');
        $menuNombre[] = 'configuracion';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/usuario/salir'),
            'menu'      => 'Salir');
        $menuNombre[] = 'salir';

    	if(!is_null($active)){
    		$key = array_search(strtolower($active), $menuNombre);
            $menu[$key]['active'] = 'class="active"';
    	}

    	return $menu;
    }

    public function menuLaborante($active = null){

        $menu[] = array(
            'active'    => '',
            'url'       => url('/tutores'),
            'menu'      => 'Tutores');
        $menuNombre[] = 'tutores';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/inscripcion'),
            'menu'      => 'Inscripción');
        $menuNombre[] = 'inscripcion';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/alumnos'),
            'menu'      => 'Alumnos');
        $menuNombre[] = 'alumnos';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/modulo'),
            'menu'      => 'Módulos');
        $menuNombre[] = 'modulos';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/usuario/salir'),
            'menu'      => 'Salir');
        $menuNombre[] = 'salir';

        if(!is_null($active)){
            $key = array_search(strtolower($active), $menuNombre);
            $menu[$key]['active'] = 'class="active"';
        }

        return $menu;
    }

    public function menuTutor($active = null){

        $menu[] = array(
            'active'    => '',
            'url'       => url('/modulos'),
            'menu'      => 'Mis Módulos');
        $menuNombre[] = 'modulos';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/usuario/salir'),
            'menu'      => 'Salir');
        $menuNombre[] = 'salir';

        if(!is_null($active)){
            $key = array_search(strtolower($active), $menuNombre);
            $menu[$key]['active'] = 'class="active"';
        }

        return $menu;
    }

    public function menuVisita($active = null){

        $menu[]    = array(
            'active'    => '',
            'url'       => url('/dashboard'),
            'menu'      => 'Dashboard');
        $menuNombre[] = 'dashboard';

        $menu[] = array(
            'active'    => '',
            'url'       => url('/usuario/salir'),
            'menu'      => 'Salir');
        $menuNombre[] = 'salir';

        if(!is_null($active)){
            $key = array_search(strtolower($active), $menuNombre);
            $menu[$key]['active'] = 'class="active"';
        }

        return $menu;
    }

    public static function getMes($mes = null){
        if(is_null($mes)){
            $mes = date('m');
        }
        $textoMeses = array(
            '01'   => 'Enero',
            '02'   => 'Febrero',
            '03'   => 'Marzo', 
            '04'   => 'Abril',
            '05'   => 'Mayo',
            '06'   => 'Junio',
            '07'   => 'Julio',
            '08'   => 'Agosto',
            '09'   => 'Septiembre',
            '10'  => 'Octubre',
            '11'  => 'Noviembre',
            '12'  => 'Diciembre'
            ); 
        return $textoMeses[$mes];
    }

    public static function getDia($dia = null){
        $diasSemana = array(
            1   => 'Lunes',
            2   => 'Martes',
            3   => 'Miercoles',
            4   => 'Jueves',
            5   => 'Viernes',
            6   => 'Sabado',
            7   => 'Domingo');

        if(is_null($dia) || !isset($diasSemana[$dia])){
            return '';
        }else{
            return $diasSemana[$dia];
        }
    }

    public static function getHoraInicio($horaHorario = null){
        $horario[1]     = '8:30';
        $horario[2]     = '9:40';
        $horario[3]     = '10:50';
        $horario[4]     = '12:00';
        $horario[5]     = '13:10';
        $horario[6]     = '14:30';
        $horario[7]     = '15:40';
        $horario[8]     = '16:50';
        $horario[9]     = '18:00';
        $horario[10]    = '19:10';
        $horario[11]    = '20:20';
        if(is_null($horaHorario) || !isset($horario[$horaHorario])){
            return '';
        }else{
            return $horario[$horaHorario];
        }
    }


    public static function getHoraFin($horaHorario = null){
        $horario[1]     = '9:30';
        $horario[2]     = '10:40';
        $horario[3]     = '11:50';
        $horario[4]     = '13:00';
        $horario[5]     = '14:10';
        $horario[6]     = '15:30';
        $horario[7]     = '16:40';
        $horario[8]     = '17:50';
        $horario[9]     = '19:00';
        $horario[10]    = '20:10';
        $horario[11]    = '21:20';
        if(is_null($horaHorario) || !isset($horario[$horaHorario])){
            return '';
        }else{
            return $horario[$horaHorario];
        }
    }

    public static function getCategoriaUsuario($idCategoria = null){
        $arrayCategoria = array(
            1 => 'ADMINISTRADOR',
            2 => 'LABORANTE',
            3 => 'TUTOR',
            4 => 'VISITA');
        if(is_null($idCategoria) || !isset($arrayCategoria[$idCategoria])){
            return '';
        }else{
            return $arrayCategoria[$idCategoria];
        }
    }

    public static function getMotivosEliminacion($tipoEliminacion = null){
        $arrayEliminacion = array(
            1 => 'El alumno ya posee postulaciones aceptadas en el actual ciclo, para la asignatura seleccionada.',
            2 => 'El alumno ha sido eliminado tras 3 inasistencias seguidas.',
            3 => 'Alumno eliminado manualmente.');
        if(is_null($tipoEliminacion) || !isset($arrayEliminacion[$tipoEliminacion])){
            return '';
        }else{
            return $arrayEliminacion[$tipoEliminacion];
        }
    }
}