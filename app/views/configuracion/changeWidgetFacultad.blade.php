<div class="col-xs-12 panel-header-2">
	<div class="col-xs-10">
		<h2>Facultad</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
		<a href="#" class="glyphicon glyphicon-floppy-disk" title="Crear" id="conf-crear-facu"></a>
		<a href="#" class="glyphicon glyphicon-trash" title="Eliminar" id="conf-eliminar-facu"></a>
	</div>
</div>
<div class="widget-container">
	<div class="row">
		{{ Form::open(array('url' => 'crearFacultad', 'class' => 'form-horizontal', 'role' => 'form')) }}
			<div class="row">
				<div class="col-xs-offset-1 col-xs-9">
					@if(isset($facultad))
						{{ Form::select('facId', $facultades, $facultad->id, array('id' => 'facu-select')) }}
					@else
						{{ Form::select('facId', $facultades, 0, array('id' => 'facu-select')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-3">
					Código:
				</div>
				<div class="col-xs-8">
					@if(isset($facultad))
						{{ Form::text('facultadCod', $facultad->codigo, array('class' => 'col-xs-3', 'id' => 'facu-cod')) }}
					@else
						{{ Form::text('facultadCod', '', array('class' => 'col-xs-3', 'id' => 'facu-cod')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-3">
					Facultad:
				</div>
				<div class="col-xs-8">
					@if(isset($facultad))
						{{ Form::text('facultadTxt', $facultad->facultad, array('class' => 'col-xs-8', 'id' => 'facu-txt')) }}
					@else
						{{ Form::text('facultadTxt', '', array('class' => 'col-xs-8', 'id' => 'facu-txt')) }}
					@endif
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#facu-select').change(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/aWidFacultad',
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
	      		$('#conf-facultad').html(res['widget']);
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});	
	});

	$('#conf-eliminar-facu').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/eliminarFacultad',
			type: 'POST',
			dataType: 'JSON',
			data: {
				facultad: $('#facu-select').val()
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
	      		$('#conf-facultad').html(res['widget']);
	      		alertify.success('Facultad eliminada con éxito');
	    	}else{
	    		alertify.error('La facultad no pudo ser eliminada.');
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});	
	});

	$('#conf-crear-facu').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/editarFacultad',
			type: 'POST',
			dataType: 'JSON',
			data: {
				facultad: $('#facu-select').val(),
				codigo: $('#facu-cod').val(),
				facuTxt: $('#facu-txt').val()
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
	      		$('#conf-facultad').html(res['widget']);
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