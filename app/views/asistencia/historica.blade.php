<div class="col-xs-12 panel-header-2">
	<div class="col-xs-10">
		<h2>Asistencia Histórica</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
		<a href="#" class="glyphicon glyphicon-chevron-left" title="Volver Atrás" id="back-asis-hist" data-mod="{{ $modulo }}"></a>
	</div>
</div>
<div class="col-sm-12">
	@if($asistencias->count())
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Alumno</th>
					<th>Asistencia</th>
					@if(Auth::user()->categoria == 1)
						<th>Opc.</th>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach($asistencias as $asistencia)
					<tr>
						<td>{{ $asistencia->fecha }}</td>
						<td>{{ $asistencia->alumno()->first()->matricula }} - {{ $asistencia->alumno()->first()->alumno }}</td>
						@if($asistencia->hora_clase == 0)
							<td>{{ $asistencia->hora_asis }}/{{ $asistencia->hora_clase }} - 0%</td>
						@else
							<td>{{ $asistencia->hora_asis }}/{{ $asistencia->hora_clase }} - {{ number_format(($asistencia->hora_asis*100/$asistencia->hora_clase), 0) }}%</td>
						@endif
						@if(Auth::user()->categoria == 1)
							<td><a href="#" class="glyphicon glyphicon-pencil edit-asis" title="Editar Asistencia" data-asis="{{ $asistencia->id }}"></a></td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
</div>
<script type="text/javascript">
	$('#back-asis-hist').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/profesor/detalleModulo',
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
		      $('#middle-container').html(res['widget']);
		    }else{
		    	$('#middle-container').html('');
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('.edit-asis').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/asistencia/editarAsistencia',
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
		      $('#mod-prof-funct').html(res['widget']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>