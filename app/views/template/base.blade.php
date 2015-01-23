<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Programa de Apoyo a la Adaptación Universitaria</title>
	<link rel="shortcut icon" href="{{ URL::to('favicon.ico?v=2.0') }}">
	{{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300') }}
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/modulos-style.css?v=3.0') }}
	{{ HTMl::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
</head>
<body>

	@yield('navbar')
	
	@yield('contenedor')

	@include('template.footer')

	@yield('footerScript')
	
</body>
</html>
