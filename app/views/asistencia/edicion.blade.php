<div id="mod-prof-funct">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Editar Asistencia</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
			<a href="#" class="glyphicon glyphicon-remove" title="Eliminar Registro" data-asis="{{ $asistencia->id }}" id="del-asis"></a>
			<a href="#" class="glyphicon glyphicon-floppy-disk" title="Guardar Edición" id="save-asis-edit"></a>
		</div>
	</div>
	<div class="col-sm-12">
		{{ Form::open(array('url' => 'asistencia/editAsistencia', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-edit-asist')) }}
			<div class="row">
				<div class="col-xs-3">
					Fecha:
				</div>
				<div class="col-xs-3">
					<input type="date" name="fAsistencia" value="{{ $asistencia->fecha }}">
				</div>
				<div class="col-xs-3">
					Horas Clase:
				</div>
				<div class="col-xs-3">
					<input type="number" class="asis-val" name="hAsistencia" value="{{ $asistencia->hora_clase }}">
				</div>
			</div>
			<div class="row">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Matrícula</th>
							<th>Alumno</th>
							<th>Horas</th>
						</tr>
					</thead>
					<tbody>
						@if($asistencias->count())
							@foreach($asistencias as $asis)
								<tr>
									<td>
										{{ $asis->alumno()->first()->matricula }}
										{{ Form::hidden('asistencias[]', $asis->id) }}
									</td>
									<td>{{ $asis->alumno()->first()->alumno }}</td>
									<td>{{ Form::text('hora_asis[]', $asis->hora_asis) }}</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		{{ Form::close() }}
	</div>
</div>

<script type="text/javascript">
	$('#del-asis').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/asistencia/eliminar',
		    dataType: 'JSON',
		    data: {
		    	asistencia: $(this).data('asis')
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
				    url: base_path+'/profesor/bitacoraAsistencia',
				    dataType: 'JSON',
				    data: {
				    	modulo: $(this).data('mod')
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
				    	$('#mod-prof-funct').html(res['widget']);
				    }else{
				    	alertify.error(res['mensaje']);
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

	$('#save-asis-edit').click(function(event){
		event.preventDefault();
		$('#form-edit-asist').submit();
	});

	$(function() {            
		$('#form-edit-asist').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioEdit,
			success: exitoEdit,
			error: errorEdit                               
		});                                    
	});

	function inicioEdit(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorEdit(res, status, err) {
		console.log(res);
		alertify.error('Ha ocurrido un error, intentelo nuevamente.');
		$('#loading-div').fadeOut();
	}

	function exitoEdit(res){
		if(res.resultado){
			alertify.success(res.mensaje);
		}else{
			alertify.error(res.mensaje);
		}
		$('#loading-div').fadeOut();
	}
</script>