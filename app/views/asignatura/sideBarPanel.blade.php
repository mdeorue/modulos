<div class="col-sm-4" id="left-container">
	<div class="row col-sm-offset-1">
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Buscar Asignaturas</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				{{ Form::select('facultades', $facultades, 0, array('id' => 'sel-facu-search')) }}
				{{ Form::text('asignatura', '', array('id' => 'asig-search', 'class' => 'col-xs-9', 'placeholder' => 'Asignatura')) }}
				{{ Form::button('Buscar', array('id' => 'asig-search-btn', 'class' => 'btn btn-default btn-sm')) }}
			</div>
		</div>
	</div>
	<br>
	<div class="row col-sm-offset-1">
		{{ Form::open(array('url' => '/asignatura/crear', 'id' => "form-new-asign")) }}
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Crear Asignaturas</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
				<a href="#" class="glyphicon glyphicon-floppy-disk" title="Crear" id="conf-crear-facu"></a>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-4">
				Código:
			</div>
			<div class="col-xs-8">
				{{ Form::text('codigo') }}
			</div>
		</div>

		<div class="row">
			<div class="col-xs-4">
				Asignatura:
			</div>
			<div class="col-xs-8">
				{{ Form::text('asignatura') }}
			</div>
		</div>

		<div class="row">
			<div class="col-xs-4">
				Semestre:
			</div>
			<div class="col-xs-8">
				{{ Form::text('nivel') }}
			</div>
		</div>

		<div class="row">
			<div class="col-xs-4">
				Módulos:
			</div>
			<div class="col-xs-8">
				<input type="number" name="modulos">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-4">
				Facultad:
			</div>
			<div class="col-xs-8">
				{{ Form::select('facultad', $facultades, 0) }}
			</div>
		</div>
		{{ Form::close() }}
	</div>
	<br>
	<div class="row col-sm-offset-1">
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Importar Asignaturas</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
			</div>
		</div>
		<div class="row">
			{{ Form::open(array('url' => '/asignatura/importarAsignatura', 'id' => "form-import-asign")) }}
				<div class="col-xs-12 text-center">
					{{ Form::file('import') }}
					{{ Form::submit('Importar', array('class' => 'btn btn-default')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<br>
	<div class="row col-sm-offset-1">
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Plan de Estudios</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
			</div>
		</div>
		<div class="row">
			{{ Form::open(array('url' => '/asignatura/importarPlan', 'id' => "form-import-plan")) }}
				<div class="col-xs-12 text-center">
					{{ Form::file('import') }}
					{{ Form::submit('Importar', array('class' => 'btn btn-default')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<br>
	<div class="row col-sm-offset-1">
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Actualización Asignaturas</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
			</div>
		</div>
		<div class="row">
			{{ Form::open(array('url' => '/asignatura/importarNuevasAsignaturas', 'id' => "form-import-actualizacion")) }}
				<div class="col-xs-12 text-center">
					{{ Form::file('import') }}
					{{ Form::submit('Importar', array('class' => 'btn btn-default')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#sel-facu-search').change(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/asignatura/buscarPorFacultad',
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
		    	$('#middle-container').html(res['widget']);
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#asig-search-btn').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/asignatura/buscar',
		    dataType: 'JSON',
		    data: {
		    	asignatura: $('#asig-search').val()
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
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});

	$('#conf-crear-facu').click(function(event){
		event.preventDefault();
		$('#form-new-asign').submit();
	});

	$(function() {            
		$('#form-new-asign').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioImport,
			success: exitoImport,
			error: errorImport                               
		});                                    
	});

	$(function() {            
		$('#form-import-plan').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioImport,
			success: exitoImport,
			error: errorImport                               
		});                                    
	});

	$(function() {            
		$('#form-import-asign').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioImport,
			success: exitoImport,
			error: errorImport                               
		});                                    
	});       

	$(function() {            
		$('#form-import-actualizacion  ').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioImport,
			success: exitoImport,
			error: errorImport                               
		});                                    
	});   

	function inicioImport(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorImport(res, status, err) {
		console.log(res);
		alertify.error('Ha ocurrido un error, intentelo nuevamente.');
		$('#loading-div').fadeOut();
	}

	function exitoImport(res){
		alertify.success(res.mensaje);
		$('#loading-div').fadeOut();
		location.reload();
	}
</script>