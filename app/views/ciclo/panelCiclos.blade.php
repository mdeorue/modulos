<div class="col-sm-3" id="left-container">
	<div class="row">
		<div class="col-sm-offset-1 col-xs-4 text-center">
			Ciclo:
		</div>
		<div class="col-xs-7">
			{{ $ciclo->id }}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-1 col-xs-4 text-center">
			Inicio:
		</div>
		<div class="col-xs-7">
			{{ $ciclo['fecha_inicio'] }}
		</div>
	</div>
	@if($ciclo->estado == 4)
	<div class="row">
		<div class="col-sm-offset-1 col-xs-4 text-center">
			Final:
		</div>
		<div class="col-xs-7">
			{{ $ciclo['fecha_final'] }}
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-xs-12 text-center">
			<b>{{ $ciclo->estados()->first()->estado }}</b>
		</div>
	</div>
	<hr>
	{{ Form::open(array('url' => 'hola', 'class' => 'form-horizontal', 'role' => 'form')) }}
		<div class="form-group">
			<div class="col-xs-12">
				@foreach($boton as $key => $btn)
					@if(isset($disabled[$key]))
						{{ Form::button($boton[$key], array('class' => 'btn btn-default btn-block', 'id' => $id[$key], 'disabled' => 'disabled')) }}
					@else
						{{ Form::button($boton[$key], array('class' => 'btn btn-default btn-block', 'id' => $id[$key])) }}
					@endif
				@endforeach
			</div>
		</div>
	{{ Form::close() }}
	<hr>
	<div class="form-group">
		<div class="col-xs-12">
			{{ Form::button('Informar a Tutores', array('class' => 'btn btn-default btn-block', 'id' => 'btn-mail-tutores')) }}
		</div>
	</div>
</div>
<div class="col-sm-9">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Reportes</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7">
			<div class="col-xs-6">
				Fecha Inicio: 
				<input type="date" id="inicio-repo" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
			</div>
			<div class="col-xs-6">
				Fecha Fin: 
				<input type="date" id="fin-repo" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
			</div>
		</div>
		<div class="col-sm-5 text-center">
			{{ Form::button('Estudiantes Participantes', array('class' => 'btn btn-default', 'id' => 'repo-part')) }}
			{{ Form::button('Tutores Participantes', array('class' => 'btn btn-default', 'id' => 'repo-tut')) }}
		</div>
	</div>
</div>
<div class="col-sm-9" id="middle-container">
</div>
<script type="text/javascript">
	$('#abrir-ciclo').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/ciclo/abrirCiclo',
		    dataType: 'JSON',
		    beforeSend: function( xhr ) {
		      $('#loading-div').fadeIn();
		    }
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		})
		.done(function( res ) {
		    if(res['resultado']){
		      alertify.success(res['mensaje']);
		      location.reload();
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#btn-mail-tutores').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/tutores/mailInscripcion',
		    dataType: 'JSON',
		    beforeSend: function( xhr ) {
		      $('#loading-div').fadeIn();
		    }
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		})
		.done(function( res ) {
		    if(res['resultado']){
		      alertify.success(res['mensaje']);
		      location.reload();
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#abrir-insc').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/ciclo/abrirInscripciones',
		    dataType: 'JSON',
		    beforeSend: function( xhr ) {
		      $('#loading-div').fadeIn();
		    }
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		})
		.done(function( res ) {
		    if(res['resultado']){
		      alertify.success(res['mensaje']);
		      location.reload();
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#cerrar-insc').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/ciclo/cerrarInscripciones',
		    dataType: 'JSON',
		    beforeSend: function( xhr ) {
		      $('#loading-div').fadeIn();
		    }
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		})
		.done(function( res ) {
		    if(res['resultado']){
		      alertify.success(res['mensaje']);
		      location.reload();
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#sel-alu').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/ciclo/seleccionarAlumnos',
		    dataType: 'JSON',
		    beforeSend: function( xhr ) {
		      $('#loading-div').fadeIn();
		    }
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		})
		.done(function( res ) {
			console.log(res);
		    $('#middle-container').html(res['widget']);
		    alertify.success('Selección realizada correctamente.');
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#cerrar-ciclo').click(function(event) {
		event.preventDefault();
		var res = confirm("¿Está seguro de cerrar el ciclo?");
		if(res){
			$.ajax({
				type: "POST",
			    url: base_path+'/ciclo/cerrarCiclo',
			    dataType: 'JSON',
			    beforeSend: function( xhr ) {
			      $('#loading-div').fadeIn();
			    }
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
			})
			.done(function( res ) {
			    if(res['resultado']){
			      alertify.success(res['mensaje']);
			      location.reload();
			    }else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		}
	});

	$('#repo-part').click(function(event) {
		event.preventDefault();
		var inicio = $('#inicio-repo').val();
		var fin = $('#fin-repo').val();
		window.open(base_path+"/reportes/participacion/"+inicio+"/"+fin, "_blank", "width=300, height=100");
	});

	$('#repo-tut').click(function(event) {
		event.preventDefault();
		var inicio = $('#inicio-repo').val();
		var fin = $('#fin-repo').val();
		window.open(base_path+"/reportes/tutores/"+inicio+"/"+fin, "_blank", "width=300, height=100");
	});
</script>