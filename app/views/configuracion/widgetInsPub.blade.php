<div class="col-sm-4">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Inscripciones</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
			<a href="#" id="conf-ins-pub" class="glyphicon glyphicon-floppy-disk"></a>
		</div>
	</div>
	<div class="widget-container">
		{{ Form::open(array('url' => 'configuracion/setInscripcionesPublicas', 'id' => 'form-ins-pub')) }}
			<div class="row col-xs-offset-1">
				<div class="row">
					<div class="col-xs-12">
						@if(isset($config))
							@if($config->ins_pub)
								{{ Form::checkbox('publica', 1, true) }}	
							@else
								{{ Form::checkbox('publica', 1, false) }}
							@endif
						@else
							{{ Form::checkbox('publica', 1, false) }}
						@endif
						Las inscripciones son públicas (Cualquier usuario puede solicitar un horario)
					</div>
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#conf-ins-pub').click(function(event) {
		event.preventDefault();
		$('#form-ins-pub').submit();
	});

	$(function() {            
		$('#form-ins-pub').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioInsPub,
			success: exitoInicioInsPub,
			error: errorInicioInsPub                               
		});                                    
	});            

	function inicioInsPub(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorInicioInsPub(response, status, err) {
		$('#loading-div').fadeOut();
		alertify.error('Ha Ocurrido un problema, inténtelo nuevamente.');
	}

	function exitoInicioInsPub(res) {
		$('#loading-div').fadeOut();
		if(res.resultado){
			alertify.success('Se cambiaron las inscripciones éxitosamente.');
		}else{
			alertify.error('No se pudo cambiar las inscripciones.');
		}
	}
</script>