<div class="col-sm-4" id="conf-usuario">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Usuarios</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
			<a href="#" class="glyphicon glyphicon-floppy-disk" title="Crear" id="conf-crear-user"></a>
		</div>
	</div>
	<div class="widget-container">
		<div class="row">
			{{ Form::open(array('url' => 'configuracion/crearUsuario', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-crear-user')) }}
				<div class="row">
					<div class="col-xs-offset-1 col-xs-3">
						Categoria:
					</div>
					<div class="col-xs-8">
						{{ Form::select('catUsuario', array(
							1 => 'ADMINISTRADOR',
							2 => 'LABORANTE',
							3 => 'TUTOR',
							4 => 'VISITA'), 3, array('id' => 'user-cat', 'class' => 'col-xs-8')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-xs-3">
						Rut o Matrícula:
					</div>
					<div class="col-xs-8">
						{{ Form::text('rutUsuario', '', array('id' => 'user-rut')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-xs-3">
						Nombre:
					</div>
					<div class="col-xs-8">
						{{ Form::text('nombreUsuario', '', array('id' => 'user-nom')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-xs-3">
						Email:
					</div>
					<div class="col-xs-8">
						{{ Form::email('emailUsuario', '', array('id' => 'user-email')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-xs-3">
						Email:
					</div>
					<div class="col-xs-8">
						{{ Form::select('carrera', $carreras, 0, array('id' => 'user-carrera')) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#conf-crear-user').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/usuario/crearUsuario',
			type: 'POST',
			dataType: 'JSON',
			data: {
				rut: $('#user-rut').val(),
				usuario: $('#user-nom').val(),
				email: $('#user-email').val(),
				categoria: $('#user-cat').val(),
				carrera: $('#user-carrera').val()
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
</script>