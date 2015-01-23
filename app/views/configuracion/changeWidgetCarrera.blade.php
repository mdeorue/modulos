<div class="col-xs-12 panel-header-2">
	<div class="col-xs-10">
		<h2>Carrera</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
		<a href="#" class="glyphicon glyphicon-floppy-disk" title="Crear" id="conf-crear-carr"></a>
		<a href="#" class="glyphicon glyphicon-trash" title="Eliminar" id="conf-eliminar-carr"></a>
	</div>
</div>
<div class="widget-container">
	<div class="row">
		{{ Form::open(array('url' => 'crearCarrera', 'class' => 'form-horizontal', 'role' => 'form')) }}
			<div class="row">
				<div class="col-xs-offset-1 col-xs-9">
					@if(isset($facultad))
						{{ Form::select('facId', $facultades, $facultad->id, array('id' => 'facu-carr-select')) }}
					@else
						{{ Form::select('facId', $facultades, 0, array('id' => 'facu-carr-select')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-9" id="change-facu-res">
					@if(isset($carreras))
						@if(isset($carrera))
							{{ Form::select('carrId', $carreras, $carrera->id, array('id' => 'carr-select')) }}
						@else
							{{ Form::select('carrId', $carreras, 0, array('id' => 'carr-select')) }}
						@endif
					@endif
					<script type="text/javascript">
						$('#carr-select').change(function(event) {
							event.preventDefault();
							$.ajax({
								url: base_path+'/configuracion/aWidCarrera',
								type: 'POST',
								dataType: 'JSON',
								data: {
									carrera: $(this).val()
								},
								beforeSend: function( xhr ) {
						    		$('#loading-div').fadeIn();
						    	}
							})
							.fail(function(jqXHR, textStatus, errorThrown) {
						    	console.log(jqXHR);
						  	})
						  	.done(function( res ) {
						    	if(res['resultado']){
						      		$('#conf-carrera').html(res['widget']);
						    	}
						  	})
						  	.always(function() {
						    	$('#loading-div').fadeOut();
						  	});	
						});
					</script>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-3">
					Código:
				</div>
				<div class="col-xs-8">
					@if(isset($facultad))
						{{ Form::text('carreraCod', $carrera->id, array('class' => 'col-xs-3', 'id' => 'carr-cod')) }}
					@else
						{{ Form::text('carreraCod', '', array('class' => 'col-xs-3', 'id' => 'carr-cod')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-3">
					Carrera:
				</div>
				<div class="col-xs-8">
					@if(isset($carrera))
						{{ Form::text('carreraTxt', $carrera->carrera, array('class' => 'col-xs-8', 'id' => 'carr-txt')) }}
					@else
						{{ Form::text('carreraTxt', '', array('class' => 'col-xs-8', 'id' => 'carr-txt')) }}
					@endif
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#facu-carr-select').change(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/carrera/carrerasByFacultadConf',
			type: 'POST',
			dataType: 'JSON',
			data: {
				facultad: $(this).val()
			},
			beforeSend: function( xhr ) {
	    		$('#loading-div').fadeIn();
	    	}
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
	    	console.log(jqXHR);
	  	})
	  	.done(function( res ) {
	    	if(res['resultado']){
	      		$('#change-facu-res').html(res['widget']);
	    	}else{
	    		$('#change-facu-res').html('');
	    		$('#carr-cod').val('');
	    		$('#carr-txt').val('');
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});	
	});

	$('#conf-eliminar-carr').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/eliminarCarrera',
			type: 'POST',
			dataType: 'JSON',
			data: {
				carrera: $('#carr-select').val()
			},
			beforeSend: function( xhr ) {
	    		$('#loading-div').fadeIn();
	    	}
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
	    	console.log(jqXHR);
	  	})
	  	.done(function( res ) {
	    	if(res['resultado']){
	      		$('#conf-carrera').html(res['widget']);
	      		alertify.success('Carrera eliminada con éxito');
	    	}else{
	    		alertify.error('La carrera no pudo ser eliminada.');
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});	
	});

	$('#conf-crear-carr').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/editarCarrera',
			type: 'POST',
			dataType: 'JSON',
			data: {
				facultad: $('#facu-carr-select').val(),
				carrera: $('#carr-select').val(),
				codigo: $('#carr-cod').val(),
				carrTxt: $('#carr-txt').val()
			},
			beforeSend: function( xhr ) {
	    		$('#loading-div').fadeIn();
	    	}
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
	    	console.log(jqXHR);
	  	})
	  	.done(function( res ) {
	    	if(res['resultado']){
	      		$('#conf-carrera').html(res['widget']);
	      		alertify.success(res['mensaje']);
	    	}else{
	    		alertify.error(res['mensaje']);
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});	
	});
</script>