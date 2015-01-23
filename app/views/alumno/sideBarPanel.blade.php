<div class="col-sm-4" id="left-container">
	<div class="row col-sm-offset-1">
		<div class="col-xs-12 panel-header-2">
			<div class="col-xs-10">
				<h2>Buscar Alumnos</h2>
			</div>
			<div class="panel-header-2-toolbar pull-right">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-12">
					{{ Form::text('alumno', '', array('id' => 'alu-search', 'class' => 'col-xs-9', 'placeholder' => 'Matrícula')) }}
					{{ Form::button('Buscar', array('id' => 'alu-search-btn', 'class' => 'btn btn-default btn-sm')) }}
				</div>
			</div>
		</div>
	</div>
	@if(Auth::user()->categoria == 1)
		<br>
		<div class="row col-sm-offset-1">
			<div class="col-xs-12 panel-header-2">
				<div class="col-xs-10">
					<h2>Importar Alumnos</h2>
				</div>
				<div class="panel-header-2-toolbar pull-right">
				</div>
			</div>
			<div class="row">
				{{ Form::open(array('url' => '/alumno/importarAlumnos', 'id' => "form-import-alu")) }}
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
					<h2>Importar Reprobación</h2>
				</div>
				<div class="panel-header-2-toolbar pull-right">
				</div>
			</div>
			<div class="row">
				{{ Form::open(array('url' => '/alumno/importarReprobacion', 'id' => "form-import-repro")) }}
					<div class="col-xs-12 text-center">
						{{ Form::file('import') }}
						{{ Form::submit('Importar', array('class' => 'btn btn-default')) }}
					</div>
				{{ Form::close() }}
			</div>
		</div>
	@endif
</div>
<div class="col-sm-8" id="middle-container"></div>
<script type="text/javascript">
	$('#alu-search-btn').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/alumnos/buscar',
		    dataType: 'JSON',
		    data: {
		    	alumno: $('#alu-search').val()
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

	$(function() {            
		$('#form-import-repro').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioImport,
			success: exitoImport,
			error: errorImport                               
		});                                    
	});

	$(function() {            
		$('#form-import-alu').ajaxForm({
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
		if(res.resultado){
			alertify.success(res.mensaje);
		}else{
			alertify.error(res.mensaje);
		}
		$('#loading-div').fadeOut();
	}
</script>