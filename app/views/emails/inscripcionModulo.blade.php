<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>Estimado/a {{ $alumno->alumno }}, te escribimos para confirmar la 
			inscripción de la tutoría académica de la asignatura {{ $modulo->asignatura()->first()->asignatura }} en el 
			módulo {{ $modulo->modulo }} con el tutor/a {{ $modulo->profesor()->first()->usuario }} los días {{ Template::getDia($modulo->horario_dia) }} a las {{ Template::getHoraInicio($modulo->horario_hora) }}
			hasta las {{ Template::getHoraFin($modulo->horario_hora_fin) }} en la sala {{ $modulo->sala }}.</p> 
			<p>Las clases iniciarán el {{ $modulo->inicio }}.</p>
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
