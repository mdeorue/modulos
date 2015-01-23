<div>
	@if(Auth::check())
		<div class="form-group">
			<div class="col-xs-12 last-input">
				{{ Form::checkbox('prioridad', 'manual', false, array('form' => 'ins-alu')) }}
				Dar Prioridad
			</div>
		</div>
	@endif
	<div class="text-center sol-button">
		{{ Form::submit('Solicitar', array('class' => 'btn btn-default btn-block', 'id' => 'btn-sol-modulo', 'form' => 'ins-alu')) }}
	</div>
</div>
<div id="result-ins" class="row text-center">
</div>
<script type="text/javascript">
	$(function() {            
		$('#ins-alu').ajaxForm({
			dataType: 'json',
			beforeSubmit: inicioInscripcion,
			success: exitoInscripcion,
			error: errorInscripcion                               
		});                                    
	});            

	function inicioInscripcion(formData, jqForm, options) {
		$('#loading-div').fadeIn();
		return true;
	}

	function errorInscripcion(response, status, err) {
		console.log(response);
		$('#loading-div').fadeOut();
		alertify.error('Ha Ocurrido un problema, inténtelo nuevamente.');
	}

	function exitoInscripcion(res) {
		$('#loading-div').fadeOut();
		$('#result-ins').html(res.widget);        
	}
</script>