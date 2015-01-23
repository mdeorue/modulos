<div class="col-sm-8" id="conf-usuario">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Lista Usuarios</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="widget-container">
		<div class="col-xs-12">
			<div class="col-xs-9">
				{{ Form::text('buscarUsuario', '', array('class' => 'col-xs-12', 'placeholder' => 'Ingresar Usuario', 'id' => 'txt-src-user')) }}
			</div>
			<div class="col-xs-3">
				{{ Form::button('Buscar', array('class' => 'btn btn-default btn-sm btn-block', 'id' => 'btn-src-user')) }}
			</div>
		</div>
		<div id="user-src-box">
			<div class="col-xs-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Usuario</th>
							<th>Categoría</th>
							<th>Email</th>
							<th>Opc.</th>
						</tr>
					</thead>
					<tbody>
						@if($usuarios->count())
							@foreach($usuarios as $usuario)
								<tr>
									<td>{{ $usuario->usuario }}</td>
									<td>{{ Template::getCategoriaUsuario($usuario->categoria) }}</td>
									<td>{{ $usuario->email }}</td>
									<td>
										@if($usuario->categoria != 1)
											<a href="#" class="glyphicon glyphicon-pencil user-edit" title="Editar Usuario" data-user="{{ $usuario->id }}"></a>
											<a href="#" class="glyphicon glyphicon-remove user-remove" title="Eliminar Usuario" data-user="{{ $usuario->id }}"></a>
										@endif
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#txt-src-user').autocomplete({
			source:'{{ url("/usuario/sugerirUsuario") }}', 
			minLength:3
		});
	});

	$('.user-remove').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/usuario/eliminarUsuario',
			type: 'POST',
			dataType: 'JSON',
			data: {
				usuario: $(this).data('user')
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

	$('#btn-src-user').click(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/usuario/buscar',
			type: 'POST',
			dataType: 'JSON',
			data: {
				usuario: $('#txt-src-user').val()
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
	      		$('#user-src-box').html(res['widget']);
	    	}else{
	    		alertify.error(res['mensaje']);
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});
	});
</script>