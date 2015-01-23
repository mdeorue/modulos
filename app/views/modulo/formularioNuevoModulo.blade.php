<div class="col-xs-12 panel-header-2">
	<div class="col-xs-10">
		<h2>Nuevo Módulo</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
		<a href="#" id="crear-mod-save" class="glyphicon glyphicon-floppy-disk"></a>
	</div>
</div>
<div class="col-sm-12">
	{{ Form::open(array('url' => '/modulo/crearModulo', 'id' => 'form-crear-modulo', 'class' => 'form-horizontal', 'role' => 'form')) }}
		<div class="row">
			<div class="col-xs-4">
				Nro. Módulo:
			</div>
			<div class="col-xs-8">
				{{ Form::text('modulo', '', array('class' => 'col-md-3')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				Tutor:
			</div>
			<div class="col-xs-8">
				{{ Form::text('profesor', '', array('id' => 'profesor-nuevo-mod', 'placeholder' => 'Ingrese matrícula', 'class' => 'col-xs-12')) }}
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
					5 => 'Viernes')) }}
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
						11 	=> '20:20 - 21:20')) }}
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
						11 	=> '20:20 - 21:20')) }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				Inicio:
			</div>
			<div class="col-xs-8">
				<div class="col-sm-6">
					<input type="date" name="fInicio" value="{{ date('Y-m-d') }}">
				</div>
				<div class="col-sm-6">
					{{ Form::text('sala', '', array('placeholder' => 'Número de sala')) }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				Capacidad:
			</div>
			<div class="col-xs-8">
				<div class="col-sm-6">
					<input type="number" name="capacidad" value="4">
				</div>
				<div class="col-sm-6">
					{{ Form::checkbox('prioritario', 'prioritario', false) }}
					Prioritario
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#profesor-nuevo-mod').autocomplete({
			source:'{{ url("/modulo/sugerirProfesor") }}', 
			minLength:3
		});
	});

	$('#crear-mod-save').click(function(event) {
		event.preventDefault();
		$('#form-crear-modulo').submit();
	});

	$(function() {            
		$('#form-crear-modulo').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioCreacion,
			success: exitoCreacion,
			error: errorCreacion                               
		});                                    
	});            

	function inicioCreacion(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorCreacion(response, status, err) {
		$('#loading-div').fadeOut();
		alertify.error('Ha Ocurrido un problema, inténtelo nuevamente.');
	}

	function exitoCreacion(res){
		if(res.resultado){
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
			alertify.success('Módulo creado correctamente.');
			$('#form-crear-modulo').clearForm();
		}else{
			console.log(res);
			alertify.error(res.mensaje);
		}
		$('#loading-div').fadeOut();
	}
</script>