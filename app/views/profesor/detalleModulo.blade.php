<div class="col-xs-12 panel-header-2" id="modulo-data" data-mod="{{ $modulo->id }}">
	<div class="col-xs-10">
		<h2>{{ $modulo->asignatura()->first()->codigo }} - {{ $modulo->modulo }} - {{ $modulo->asignatura()->first()->asignatura }}</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
	</div>
</div>
<div class="col-sm-12">
	{{ Form::open(array('url' => 'hola3', 'class' => 'form-horizontal', 'role' => 'form')) }}
		<div class="row">
			<div class="col-xs-4">
				Nro Módulo:
			</div>
			<div class="col-xs-8">
				{{ $modulo->modulo }}
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
				<div class="col-xs-6">
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
				<div class="col-xs-6">
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
			<div class="col-xs-4">
				<input type="date" name="fInicio" value="{{ $modulo->inicio }}" disabled="disabled">
			</div>
			<div class="col-xs-4">
				{{ $modulo->sala }}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3">
				Capacidad:
			</div>
			<div class="col-xs-3">
				{{ $modulo->capacidad }}
			</div>
			<div class="col-xs-3">
				Disponibilidad:
			</div>
			<div class="col-xs-3">
				{{ ($modulo->capacidad-$activas->count()) }}
			</div>
		</div>
	{{ Form::close() }}
</div>

@if(Auth::user()->categoria != 2)
	<div id="mod-prof-funct">
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Asistencia</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
				<a href="#" class="glyphicon glyphicon-calendar" title="Ver Histórico" id="view-asis-hist" data-mod="{{ $modulo->id }}"></a>
				<a href="#" class="glyphicon glyphicon-floppy-disk" title="Guardar Asistencia" id="save-asis-mod"></a>
			</div>
		</div>
		<div class="col-sm-12">
			{{ Form::open(array('url' => 'profesor/guardarAsistencia', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-save-asist')) }}
				<div class="row">
					<div class="col-xs-3">
						Fecha:
					</div>
					<div class="col-xs-3">
						<input type="date" name="fAsistencia" value="{{ date('Y-m-d') }}">
						{{ Form::hidden('modulo', $modulo->id) }}
					</div>
					<div class="col-xs-3">
						Horas Clase:
					</div>
					<div class="col-xs-3">
						<input type="number" class="asis-val" name="hAsistencia" value="{{ ($modulo->horario_hora_fin-$modulo->horario_hora+1) }}">
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
							@if($activas->count())
								@foreach($activas as $activa)
									<tr>
										<td>
											{{ $activa->alumno()->first()->matricula }}
											{{ Form::hidden('matricula[]', $activa->alumno()->first()->matricula) }}
										</td>
										<td>{{ $activa->alumno()->first()->alumno }}</td>
										<td>{{ Form::text('asistencia[]') }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			{{ Form::close() }}
		</div>

		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Bitácora</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
				<a href="#" class="glyphicon glyphicon-calendar" title="Ver Histórico" id="view-bit-hist" data-mod="{{ $modulo->id }}"></a>
				<a href="#" class="glyphicon glyphicon-floppy-disk" title="Guardar Bitácora" data-mod="{{ $modulo->id }}" id="save-bit-mod"></a>
			</div>
		</div>
		<div class="col-sm-12">
			{{ Form::open(array('url' => 'hola3', 'class' => 'form-horizontal', 'role' => 'form')) }}
				<div class="row">
					<div class="col-xs-3">
						Fecha:
					</div>
					<div class="col-xs-9">
						<input type="date" name="fVitacora" id="f-bit" value="{{ date('Y-m-d') }}">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						{{ Form::textarea('bitacora', '', array('class' => 'form-control', 'rows' => '3', 'id' => 'txt-bit')) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endif
<script type="text/javascript">
	$('#save-bit-mod').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/profesor/guardarBitacora',
		    dataType: 'JSON',
		    data: {
		    	modulo: $(this).data('mod'),
		    	bitacora: $('#txt-bit').val(),
		    	fecha: $('#f-bit').val()
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
		    	$('#txt-bit').val('');
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#view-bit-hist').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/profesor/bitacoraHistorica',
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
	});
	
	$(function() {            
		$('#form-save-asist').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioAsistencia,
			success: exitoAsistencia,
			error: errorAsistencia                               
		});                                    
	});            

	function inicioAsistencia(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorAsistencia(res, status, err) {
		console.log(res);
		alertify.error('Ha ocurrido un error, intentelo nuevamente.');
		$('#loading-div').fadeOut();
	}

	function exitoAsistencia(res){
		console.log(res);
		if(res.resultado){
			alertify.success(res.mensaje);
		}else{
			alertify.error(res.mensaje);
		}
		$('#loading-div').fadeOut();
	}

	$('#save-asis-mod').click(function(event){
		event.preventDefault();
		$('#form-save-asist').submit();
	});

	$('#view-asis-hist').click(function(event){
		event.preventDefault();
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
	});
</script>