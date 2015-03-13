<?php

class AdministracionController extends BaseController {

	public function sendTestResults(){
		$resultado['resultado'] = false;
		if (Input::hasFile('import')) {
			$nombre = Input::file('import')->getClientOriginalName();
			$extension = Input::file('import')->getClientOriginalExtension();
			$destino = 'import/alumno';
			$extPermitidas = array('csv', 'xls', 'xlsx');
			if(in_array($extension, $extPermitidas)){
				$upload = Input::file('import')->move($destino, $nombre);
				if($upload){
					$resultado['resultado'] = true;
					Excel::load('import/alumno/'.$nombre, function($reader) {
						$columnas = $reader->toArray();
						if(count($columnas)){
							foreach ($columnas as $key => $columna) {
								$pdf = PDF::loadView('pdf.informeResultadosDiagnostico', ['data' => $columna]);
								Mailgun::send('emails.resultadoDiagnostico',['data' => $columna], function($message) use($columna, $pdf){
									$message->to($columna['email'], $columna['alumno'])
										->cc('emailPau@ufro.cl', 'Rodrigo Puchi')
										->subject('Resultados Diagnósticos')
										->attachData($pdf->output(), 'ResultadosDiagnostico'.$columna['matricula'].'.pdf');;
								});
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

	public function showTestResultPDF(){
		$pdf = PDF::loadView('pdf.resultadoDiagnostico');
		return $pdf->stream();
		//return View::make('pdf.resultadoDiagnostico');
	}

}