<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>Estimado/a tutor/a te escribimos para confirmar el inicio de tutoría académica 
			de la asignatura {{ $modulo->asignatura()->first()->asignatura }}, módulo {{ $modulo->modulo }}. 
			La fecha de inicio es {{ $modulo->inicio }}. 
			Todos los {{ Template::getDia($modulo->horario_dia) }} a las {{ Template::getHoraInicio($modulo->horario_hora) }} - {{ Template::getHoraFin($modulo->horario_hora_fin) }}. En la sala {{ $modulo->sala }}.
		</p>
		<p>
			Los estudiantes inscritos son los siguientes:
		</p>
		{{-- */$i=1;/* --}}
		@foreach($activas as $activa)
			<p>{{ $i }}.- {{ $activa->alumno()->first()->alumno }} / {{ $activa->alumno()->first()->carrera()->first()->carrera }}/ {{ $activa->alumno()->first()->email }}</p>
			{{-- */$i++;/* --}}
		@endforeach
		<br>
		<p>
			Si tienes alguna duda y/o sugerencia acércate a nuestras dependencias.
			<br>
			Saludos cordiales
			<br>
			Equipo Programa de Apoyo a la Adaptación Universitaria (PAAU)
		</p>
	</body>
</html>
