<div class="row">
	<div class="col-xs-12 panel-header-2" id="modulo-data" data-mod="{{ $modulo->id }}">
		<div class="col-xs-10">
			<h2>{{ $modulo->asignatura()->first()->codigo }} - {{ $modulo->modulo }} - {{ $modulo->asignatura()->first()->asignatura }}</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
			@if(Auth::user()->categoria < 3)
				<a href="#" class="glyphicon glyphicon-pencil mod-edit" title="Editar Módulo"></a>
				<a href="#" class="glyphicon glyphicon-floppy-disk mod-save" title="Guardar Módulo"></a>
				@if(Auth::user()->categoria == 1)
					<a href="#" class="glyphicon glyphicon-remove mod-remove" title="Eliminar Módulo" data-mod="{{ $modulo->id }}"></a>
					<a href="#" class="glyphicon glyphicon-envelope mod-send-info" title="Informar Tutor" data-mod="{{ $modulo->id }}"></a>
				@endif
			@endif
		</div>
	</div>
</div>
<div class="col-sm-12">
	{{ Form::open(array('url' => '/modulo/guardarEdicion', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-edit-mod')) }}
		<div class="row">
			<div class="col-xs-4">
				Nro. Módulo:
			</div>
			<div class="col-xs-8">
				{{ Form::hidden('mid', $modulo->id) }}
				@if(Auth::user()->categoria == 1)
					{{ Form::text('modulo', $modulo->modulo, array('disabled' => 'disabled')) }}
				@else
					{{ $modulo->modulo }}
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				Tutor:
			</div>
			<div class="col-xs-8">
				@if(Auth::user()->categoria == 1)
					{{ Form::text('profesor', $modulo->profesor()->first()->rut.'-'.$modulo->profesor()->first()->usuario, array('disabled' => 'disabled', 'id' => 'prof-mod', 'class' => 'col-xs-12')) }}
				@else
					{{ $modulo->profesor()->first()->rut }}-{{ $modulo->profesor()->first()->usuario }}
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				Horario:
			</div>
			<div class="col-xs-8">
				{{ Form::select('hDia', array(
					1 => 'Lunes', 
					2 => 'Martes', 
					3 => 'Miercoles', 
					4 => 'Jueves',
					5 => 'Viernes'), $modulo->horario_dia, array('disabled' => 'disabled') ) }}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-offset-4 col-xs-8">
				<div class="col-sm-6">
					{{ Form::select('hHora', array(
						1 	=> '8:30 - 9:30', 
						2 	=> '9:40 - 10:40', 
						3 	=> '10:50 - 11:50', 
						4 	=> '12:00 - 13:00',
						5 	=> '13:10 - 14:10',
						6 	=> '14:30 - 15:30',
						7 	=> '15:40 - 16:40',
						8 	=> '16:50 - 17:50',
						9 	=> '18:00 - 19:00',
						10 	=> '19:10 - 20:10',
						11 	=> '20:20 - 21:20'), $modulo->horario_hora, array('disabled' => 'disabled')) }}
				</div>
				<div class="col-sm-6">
					{{ Form::select('hHoraFin', array(
						1 	=> '8:30 - 9:30', 
						2 	=> '9:40 - 10:40', 
						3 	=> '10:50 - 11:50', 
						4 	=> '12:00 - 13:00',
						5 	=> '13:10 - 14:10',
						6 	=> '14:30 - 15:30',
						7 	=> '15:40 - 16:40',
						8 	=> '16:50 - 17:50',
						9 	=> '18:00 - 19:00',
						10 	=> '19:10 - 20:10',
						11 	=> '20:20 - 21:20'), $modulo->horario_hora_fin, array('disabled' => 'disabled')) }}
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-xs-4">
				Fecha Inicio:
			</div>
			<div class="col-xs-8">
				<div class="col-sm-6">
					<input type="date" name="fInicio" value="{{ $modulo->inicio }}" disabled="disabled">
				</div>
				<div class="col-sm-6">
					{{ Form::text('sala', $modulo->sala, array('disabled' => 'disabled', 'id' => 'sala-mod')) }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				Capacidad:
			</div>
			<div class="col-xs-8">
				<div class="col-sm-6">
					@if(Auth::user()->categoria == 1)
						<input type="number" name="capacidad" value="{{ $modulo->capacidad }}" disabled="disabled">
					@else
						{{ $modulo->capacidad }}
					@endif
				</div>
				<div class="col-sm-6">
					@if(Auth::user()->categoria == 1)
						{{ Form::checkbox('prioritario', 'prioritario', $modulo->prioritario, array('disabled' => 'disabled')) }}
						Prioritario
					@else
						@if($modulo->prioritario)
							Prioritario
						@endif
					@endif
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>

@if($activas->count())
	<div class="col-xs-12">
		<div class="row">
			<h3>Inscritos</h3>
			@foreach($activas as $activa)
				<div class="modulo-alu alu-ins">
					{{ $activa->matricula }} - {{ $activa->alumno()->first()->alumno }}
					<div class="modulo-ins-opt pull-right">
						@if($activa->alumno()->first()->prioridad != 99999)
							<a href="#" class="glyphicon glyphicon-asterisk" title="{{ $activa->alumno()->first()->prioridad()->first()->texto }}"></a>
						@endif
						@if(Auth::user()->categoria == 1)
							<a href="#" class="glyphicon glyphicon-remove sol-remove" data-sol="{{ $activa->id }}" title="Cancelar Inscripción"></a>
						@endif
					</div>
				</div>
			@endforeach
			
		</div>
	</div>
@endif

@if($pendientes->count())
	<div class="col-xs-12">
		<div class="row">
			<h3>Lista de Espera</h3>
			@if(isset($disponibilidad))
				<div class="row" id="form-change-mod-sol">
					<div class="col-xs-12">
						<div class="col-xs-7">
							{{ Form::select('cambioDisponible', $disponibilidad, null, array('id' => 'change-mod')) }}
						</div>
						<div class="col-xs-5">
							{{ Form::button('Cambiar de Módulo', array('class' => 'btn btn-default btn-sm', 'id' => 'change-mod-sol')) }}
						</div>
					</div>
				</div>
				<br>
			@endif
			@foreach($pendientes as $pendiente)
				<div class="modulo-alu alu-esp">
					{{ $pendiente->matricula }} - {{ $pendiente->alumno()->first()->alumno }}
					<div class="modulo-ins-opt pull-right">
						@if(Auth::user()->categoria < 3)
							<a href="#" class="glyphicon glyphicon-ok sol-asign" data-sol="{{ $pendiente->id }}" title="Aprobar Postulación"></a>
							<a href="#" class="glyphicon glyphicon-transfer sol-change" data-sol="{{ $pendiente->id }}" title="Cambiar Postulación"></a>
							@if(Auth::user()->categoria == 1)
								<a href="#" class="glyphicon glyphicon-remove sol-can" data-sol="{{ $pendiente->id }}" title="Eliminar Postulación"></a>
							@endif
						@endif
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endif

@if($canceladas->count())
	<div class="col-xs-12">
		<div class="row">
			<h3>Postulaciones Canceladas</h3>
			@foreach($canceladas as $cancelada)
				<div class="modulo-alu alu-can">
					{{ $cancelada->matricula }} - {{ $cancelada->alumno()->first()->alumno }}
					<div class="modulo-ins-opt pull-right">
						@if(isset($eliminacion[$cancelada->id]))
							<a href="#" class="glyphicon glyphicon-info-sign" title="{{ Template::getMotivosEliminacion($eliminacion[$cancelada->id]) }}"></a>
						@else
							<a href="#" class="glyphicon glyphicon-info-sign" title="{{ Template::getMotivosEliminacion(1) }}"></a>
						@endif
						@if(Auth::user()->categoria == 1)
							<a href="#" class="glyphicon glyphicon-ok sol-uncan" data-sol="{{ $cancelada->id }}" title="Recuperar Postulación"></a>
						@endif
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endif

@if(Auth::user()->categoria == 1)
	<script type="text/javascript">
		$('.sol-remove').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/modulo/cancelarSolicitud',
			    dataType: 'JSON',
			    data: { 
			    	solicitud : $(this).data('sol') 
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
					$.ajax({
						type: "POST",
						url: base_path+'/modulo/informacionModulo',
						dataType: 'JSON',
						data: { 
							modulo: $('#modulo-data').data('mod')
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
							$('#middle-container').html(res['widget']);
						}
					})
					.always(function() {
						$('#loading-div').fadeOut();
					});
			    }else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		});

		$('.sol-can').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/modulo/cancelarPostulacion',
			    dataType: 'JSON',
			    data: { 
			    	solicitud : $(this).data('sol') 
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
					$.ajax({
						type: "POST",
						url: base_path+'/modulo/informacionModulo',
						dataType: 'JSON',
						data: { 
							modulo: $('#modulo-data').data('mod')
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
							$('#middle-container').html(res['widget']);
						}
					})
					.always(function() {
						$('#loading-div').fadeOut();
					});
			    }else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		});

		$('.mod-send-info').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/modulo/informarEstadoTutoria',
			    dataType: 'JSON',
			    data: { 
			    	modulo : $(this).data('mod') 
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
			    }else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		});

		$('.sol-uncan').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/modulo/descancelarPostulacion',
			    dataType: 'JSON',
			    data: { 
			    	solicitud : $(this).data('sol') 
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
					$.ajax({
						type: "POST",
						url: base_path+'/modulo/informacionModulo',
						dataType: 'JSON',
						data: { 
							modulo: $('#modulo-data').data('mod')
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
							$('#middle-container').html(res['widget']);
						}
					})
					.always(function() {
						$('#loading-div').fadeOut();
					});
			    }else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		});

		$('.mod-remove').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/modulo/eliminar',
			    dataType: 'JSON',
			    data: { 
			    	modulo : $(this).data('mod') 
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
			    	$.ajax({
					    type: "POST",
					    url: base_path+'/modulo/modulosAsignaturaMod',
					    dataType: 'JSON',
					    data: { 
					    	asignatura : $('#asig-select').val() 
					    },
					    beforeSend: function( xhr ) {
					      $('#loading-div').fadeIn();
					    }
					  })
					  .fail(function(jqXHR, textStatus, errorThrown) {
					    console.log(jqXHR);
					  })
					  .done(function( res ) {
					  	$('#mod-crear-mod').show();
					    if(res['resultado']){
					    	$('#modulos-init').html(res['widget']);
					    	$('#middle-container').html('');
					    }else{
					    	$('#modulos-init').html('');
					    	$('#middle-container').html('');
					    }
					  })
					  .always(function() {
					    $('#loading-div').fadeOut();
					  });
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
@endif

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#prof-mod').autocomplete({
			source:'{{ url("/modulo/sugerirProfesor") }}', 
			minLength:3
		});
	});

	$('.sol-asign').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/modulo/inscripcionManual',
			    dataType: 'JSON',
			    data: { 
			    	solicitud : $(this).data('sol') 
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
					$.ajax({
						type: "POST",
						url: base_path+'/modulo/informacionModulo',
						dataType: 'JSON',
						data: { 
							modulo: $('#modulo-data').data('mod')
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
							$('#middle-container').html(res['widget']);
						}
					})
					.always(function() {
						$('#loading-div').fadeOut();
					});
			    }else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		});

	$('.mod-edit').click(function(event){
		event.preventDefault();
		$('.mod-save').show();
		$(this).hide();
		$("input").prop('disabled', false);
		$("select").prop('disabled', false);
	});

	$('.mod-save').click(function(event){
		event.preventDefault();
		$('#form-edit-mod').submit();
	});

	$(function() {            
		$('#form-edit-mod').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioEdicion,
			success: exitoEdicion,
			error: errorEdicion                               
		});                                    
	});            

	function inicioEdicion(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorEdicion(response, status, err) {
		$('#loading-div').fadeOut();
		alertify.error('Ha Ocurrido un problema, inténtelo nuevamente.');
	}

	function exitoEdicion(res){
		if(res.resultado){
			$.ajax({
				type: "POST",
			    url: base_path+'/modulo/informacionModulo',
			    dataType: 'JSON',
			    data: { 
			    	modulo: $('#modulo-data').data('mod')
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
			 		$('#middle-container').html(res['widget']);
			      	$('.mod-save').hide();
					$('.mod-edit').show();
					$("input").prop('disabled', true);
					$("select").prop('disabled', true);
			    }else{
			    	$('#middle-container').html('');
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
			alertify.success('Edición registrada correctamente.');
		}else{
			console.log(res);
			alertify.error(res.mensaje);
		}
		$('#loading-div').fadeOut();
	}

	var solicitud;

	$('.sol-change').click(function(event) {
		event.preventDefault();
		solicitud = $(this).data('sol');
		$('#form-change-mod-sol').show();
	});

	$('#change-mod-sol').click(function(event){
		$.ajax({
			type: "POST",
			url: base_path+'/modulo/cambiarModuloSolicitud',
			    dataType: 'JSON',
			    data: { 
			    	solicitud: solicitud,
			    	modulo: $('#change-mod').val()
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
			 		alertify.success('Módulo cambiado correctamente.');
					$('#middle-container').html('');
			    }else{
			    	alertify.error('Módulo cambiado correctamente.');
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
	});
</script>