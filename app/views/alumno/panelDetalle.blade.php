<div class="col-xs-12 panel-header-2" id="alumno-data" data-mod="{{ $alumno->id }}">
	<div class="col-xs-10">
		<h2>{{ $alumno->alumno }}</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
		@if(Auth::user()->categoria == 1)
			<a href="#" class="glyphicon glyphicon-remove alu-remove" title="Eliminar Alumno" data-alu="{{ $alumno->id }}"></a>
		@endif
	</div>
</div>
<div class="col-xs-12">
	{{ Form::open(array('url' => 'hola3', 'class' => 'form-horizontal', 'role' => 'form')) }}
		<div class="row">
			<div class="col-sm-6">
				<div class="col-xs-6">
					<b>Matrícula:</b>
				</div>
				<div class="col-xs-6">
					{{ $alumno->matricula }}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="col-xs-6">
					<b>Prioridad:</b>
				</div>
				<div class="col-xs-6">
					{{ $alumno->prioridad()->first()->texto }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="col-xs-6">
					<b>Email:</b>
				</div>
				<div class="col-xs-6">
					{{ $alumno->email }}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="col-xs-6">
					<b>Año Ingreso:</b>
				</div>
				<div class="col-xs-6">
					{{ $alumno->ingreso }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-3">
					<b>Carrera:</b>
				</div>
				<div class="col-xs-9">
					{{ $alumno->carrera()->first()->id }} - {{ $alumno->carrera()->first()->carrera }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>

@if(Auth::user()->categoria == 1)
	<div class="col-xs-12">
		{{ Form::open(array('url' => 'alumno/certificadoInscripcion', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-ins-cert')) }}
			<div class="row">
				<h3>Constancia Inscripción</h3>
			</div>
			<div class="row">
				<div class="col-xs-4">
					{{ Form::select('ciclo', $ciclos, 0, array('id' => 'sel-ciclo-cert')) }}
					{{ Form::hidden('matricula', $alumno->matricula, array('id' => 'txt-mat-cert')) }}
				</div>
				<div id="mod-cert-alu"></div>
			</div>
		{{ Form::close() }}
	</div>
@endif

@if($activas->count())
<div class="col-xs-12">
	<div class="row">
		<h3>Módulos Inscritos</h3>
		@foreach($activas as $activa)
			<div class="modulo-alu alu-ins">
				{{ $activa->modulo()->first()->asignatura()->first()->codigo }} - {{ $activa->modulo }} - {{ $activa->modulo()->first()->asignatura()->first()->asignatura }} - {{ $activa->modulo()->first()->profesor()->first()->usuario }}
			</div>
		@endforeach
	</div>
</div>
@endif

@if($pendientes->count())
<div class="col-xs-12">
	<div class="row">
		<h3>Lista de Espera</h3>
		@foreach($pendientes as $pendiente)
			<div class="modulo-alu alu-esp">
				{{ $pendiente->modulo()->first()->asignatura()->first()->codigo }} - {{ $pendiente->modulo }} - {{ $pendiente->modulo()->first()->asignatura()->first()->asignatura }} - {{ $pendiente->modulo()->first()->profesor()->first()->usuario }}
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
					{{ $cancelada->modulo()->first()->asignatura()->first()->codigo }} - {{ $cancelada->modulo }} - {{ $cancelada->modulo()->first()->asignatura()->first()->asignatura }} - {{ $cancelada->modulo()->first()->profesor()->first()->usuario }}
					<div class="modulo-ins-opt pull-right">
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
	var myForm = document.getElementById('form-ins-cert');
	myForm.onsubmit = function() {
    	var w = window.open('about:blank','Popup_Window','width=600,height=400,left = 312,top = 234');
    	this.target = 'Popup_Window';
	};

	$('.alu-remove').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/alumno/eliminar',
		    dataType: 'JSON',
		    data:{
		    	alumno: $(this).data('alu'),
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
@endif

<script type="text/javascript">
	$('#sel-ciclo-cert').change(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/alumno/obtenerModulosByCiclo',
		    dataType: 'JSON',
		    data:{
		    	ciclo: $(this).val(),
		    	matricula: $('#txt-mat-cert').val()
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
		    	$('#mod-cert-alu').html(res['widget']);
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>