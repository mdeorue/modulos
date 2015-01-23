<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SmartB University - Be Smart</title>
		<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/modulos-pdf.css?v=2.0') }}
	</head>
	<body class="pdf-layout">
		<div class="container-fluid main-container">
			<div class="row text-center">
				<br>
				<br>
				<img src="{{ asset('image/logo-pdf.jpg'); }}" width="200">
				<br>
				<br>
				<br>
				<h1>CONSTANCIA</h1>
				<br>
			</div>
			<br>
			<br>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-10">
					<p class="indent">Sindy Alicia González Reyes, Trabajador Social, 
						Encargada del Programa de Apoyo a la Adaptación Universitaria (PAAU), 
						deja constancia que el Sr/a. {{ $alumno->alumno }}, Matrícula: {{ $alumno->matricula }}
						de la carrera {{ $alumno->carrera()->first()->carrera }}, participa en tutoría académica de la asignatura de 
						{{ $tutoria->asignatura()->first()->asignatura }} durante el  {{ $tutoria->ciclo()->first()->semestre }}° semestre del año {{ $tutoria->ciclo()->first()->ano }}, 
						contabilizando entre {{ $fechaInicio }} y {{ $fechaFinal }} un total de 
						{{ $horas }} horas cronológicas.</p>
					<p>Se entrega la siguiente constancia para efectos que la persona estime conveniente.</p>
					<br>
					<br>
					<p>Temuco, {{ $mes }} de {{ date('Y') }}</p>
				</div>	
			</div>
		</div>
	</body>
</html>
