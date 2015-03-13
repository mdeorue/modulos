<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
		<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/modulos-pdf.css?v=2.0') }}
	</head>
	<body class="pdf-layout">
		<div class="container-fluid main-container">
			<div class="col-xs-12">
				<div>
					<div>
						<table>
							<tr>
								<td>
									<img src="{{ asset('image/ufro.jpg') }}" width="140">
									<p>
										Dirección Académica de Pregrado
										<br>
										Apoyo Académico al Estudiante 
									</p>
								</td>
								<td class="text-right">
									<h3>
										Resultados Diagnósticos Estudiantes
										<br>
										Ingreso 2015 
									</h3>	
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div>
					<br>
					<br>
					<p>Estimado/a: <strong>DE ORUE DIAZ, MIGUEL MATIAS</strong></p>
					<br>
					<p class="text-justify">
						Este informe tiene como objetivo darte a conocer tus resultados en los 
						Test de Diagnósticos aplicados a estudiantes ingreso 2015 al inicio del semestre. 
						Te invitamos a revisar tus resultados y a leer las recomendaciones en 
						post de apoyarte en el éxito académico.
					</p>
					<br>
					<p class="text-right">
						Paulina Meneses.
						<br>
						Programa de Apoyo Académico al Estudiante.
						<br>
						Universidad de la Frontera.
					</p>
					<br>
					<div>
						<div class="col-xs-12">
							<table width="100%">
								<tr>
									<td>
										<p><strong>Puntaje PSU: 650</strong></p>
									</td>
									<td>
										<p><strong>NEM: 600</strong></p>
									</td>
								</tr>
							</table>
						</div>
						<br>
					</div>
				</div> 
				<div>
					<div>
						<p><strong>Diagnóstico Ciencias Básicas:</strong></p>
						<br>
						<div class="col-xs-8 col-xs-offset-2">
							<table class="pdf-table">
								<tr>
									<td></td>
									<td></td>
									<td>Tu Puntaje</td>
									<td>Promedio Carrera</td>
									<td>Promedio Facultad</td>
								</tr>
								<tr>
									<td>Matemáticas</td>
									<td>100%</td>
									<td>100%</td>
									<td>100%</td>
								</tr>
								<tr>
									<td>Física</td>
									<td>100%</td>
									<td>100%</td>
									<td>100%</td>
								</tr>
								<tr>
									<td>Química</td>
									<td>100%</td>
									<td>100%</td>
									<td>100%</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div>
					<div>
						<p><strong>Nivel de Dominio del Idioma Inglés:</strong></p>
						<p>
							El nivel de inglés del titulado de la UFRO es ALTE 2. 
							Para alcanzar este nivel la UFRO a través de la Coordinación de Idiomas 
							cuenta con cursos de niveles: Principiante, Básico, Pre-intermedio, 
							Intermedio. Según el Examen de Suficiencia inicial aplicado tu nivel es: 
							<strong>20</strong> por lo cual <strong>20</strong>. 
							Además, te entregamos tu resultado en detalle y algunas comparaciones:
						</p>
						<br>
						<div class="col-xs-8 col-xs-offset-2">
							<table class="pdf-table">
								<tr>
									<td></td>
									<td></td>
									<td>% Test</td>
									<td>% Speaking</td>
									<td>% Total</td> 
								</tr>
								<tr>
									<td>Tu Puntaje</td>
									<td>100%</td>
									<td>100%</td>
									<td>100%</td>
								</tr>
								<tr>
									<td>Promedio Carrera</td>
									<td>100%</td>
									<td>100%</td>
									<td>100%</td>
								</tr>
								<tr>
									<td>Promedio Facultad</td>
									<td>100%</td>
									<td>100%</td>
									<td>100%</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div>
					<p><strong>Test MSLQ:</strong></p>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo eius placeat culpa quisquam, unde debitis incidunt soluta. Esse illum nesciunt iusto adipisci repudiandae nisi rerum. Itaque, doloribus facilis pariatur impedit.
					</p>
					<div class="col-xs-6 col-xs-offset-3">
						<table class="pdf-table">
							<tr>
								<td></td>
								<td>Dimensión</td>
								<td> Nivel percibido</td>
							</tr>
							<tr>
								<td>Autoeficacia</td>
								<td>100</td>
							</tr>
							<tr>
								<td>Motivación intrínseca</td>
								<td>100</td>
							</tr>
							<tr>
								<td>Ansiedad ante los exámenes</td>
								<td>100</td>
							</tr>
							<tr>
								<td>Ansiedad ante los exámenes</td>
								<td>100</td>
							</tr>
							<tr>
								<td>Uso de estrategias cognitivas</td>
								<td>100</td>
							</tr>
							<tr>
								<td>Autorregulación</td>
								<td>100</td>
							</tr>
						</table>
					</div>
				</div>

				<div>
					<h3>Recomendaciones</h3>
					<p>Según los resultados entregados te recomendamos:</p>
					<ul>
						<li>Recomendación 1</li>
						<li>Recomendación 2</li>
						<li>Recomendación 3</li>
					</ul>
				</div>
				
			</div>
		</div>
	</body>
</html>