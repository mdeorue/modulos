<div class="col-sm-4">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Ciclos</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="widget-container">
		<div class="row col-xs-offset-1">
			@if($ciclo->count())
				<div class="row">
					<div class="col-xs-4">
						Código:
					</div>
					<div class="col-xs-7">
						{{ $ciclo->id }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						Estado:
					</div>
					<div class="col-xs-7">
						{{ $ciclo->estado()->first()->estado }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						Inicio:
					</div>
					<div class="col-xs-7">
						{{ $ciclo->inicio }}
					</div>
				</div>
			@endif
			<div class="row">
				<div class="col-xs-12 text-center">
					{{ Form::button('Nuevo Ciclo', array('class' => 'btn btn-default', 'id' => 'conf-new-ciclo')) }}
					{{ Form::button('Cerrar Ciclo', array('class' => 'btn btn-default')) }}
					{{ Form::button('Cerrar Repechaje', array('class' => 'btn btn-default')) }}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#conf-new-ciclo').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/iniciarCiclo',
			type: 'POST',
			dataType: 'JSON',
			beforeSend: function( xhr ) {
	    		var con = confirm("Al abrir un nuevo ciclo, cerrará todos los abiertos.");
				return con;
	    	}
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
	    	console.log(jqXHR);
	  	})
	  	.done(function( res ) {
	    	if(res['resultado']){
	      		alertify.success('Ciclo iniciado con éxito');
	    	}else{
	    		alertify.error('El ciclo no pudo ser iniciado');
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});
	});
</script>