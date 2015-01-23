@foreach($modulos['id'] as $key => $modulo)
	<div class="modulo-asig">
		<p>{{ Form::radio('modulo', $modulos['id'][$key], false, array('form' => 'ins-alu')) }} <b>{{ $modulos['asignatura'][$key] }}</b></p>
		<p>{{ $modulos['profesor'][$key] }}</p>
		<p>Horario Inicio: {{ $modulos['hora_inicio'][$key] }} / {{ $modulos['hora_fin'][$key] }}</p>
		<p>Fecha Inicio: {{ $modulos['inicio'][$key] }}</p>
		<p>Disponibilidad: {{ $modulos['disponibilidad'][$key] }}</p>
	</div>
@endforeach
<hr>

<div id="al-data">
	@if(Auth::check())
		<div class="form-group">
			<div class="col-xs-12 last-input">
				{{ Form::checkbox('obligar', 1, false,array('id' => 'prioridad-ins')) }}
				Dar prioridad
			</div>
		</div>
	@endif
	<div class="text-center sol-button">
		{{ Form::button('Postular', array('class' => 'btn btn-default btn-block', 'id' => 'btn-sol-modulo')) }}
	</div>
</div>
<div id="result-ins" class="row text-center">
</div>
<script type="text/javascript">
	$('.modulo-asig').click(function(event) {
		event.preventDefault();
		$(this).find('input:radio')[0].checked = true;
		$('#al-data').show();
	});

	$('#btn-sol-modulo').click(function(event) {
		event.preventDefault();
		var selected = $("input[type='radio'][name='modulo']:checked");
		var prior = 0;
		if($('#prioridad-ins').is(':checked')){
			prior = 1;
		}
		$.ajax({
		    type: "POST",
		    url: base_path+'/modulo/inscribirAlu',
		    dataType: 'JSON',
		    data: { 
		    	matricula : $('#ins-mat-al').val(),
		    	email: $('#email-al').val(),
		    	modulo: selected.val(),
		    	alumno: $('#alu-al').val(),
		    	facultad: $('#facu-select').val(),
		    	carrera: $('#carr-select').val(),
		    	prioridad: prior,
		    	modAsig: $('#mod-asig-select').val()
		    },
		    beforeSend: function( xhr ) {
				$('#loading-div').fadeIn();
		    }
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		})
		.done(function( res ) {
			console.log(res);
			if(res['resultado']){
				alertify.success(res['mensaje']);
			}else{
				alertify.error(res['mensaje']);
			}
			$('#result-ins').html(res['widget']);
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>