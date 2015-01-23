<table class="table table-bordered">
	@for($i = 0; $i < 12; $i++)
		<tr >
			@for($j = 0; $j < 6; $j++)
				@if(isset($modulo[$i][$j]))
					@if(isset($clase[$i][$j]))
						<td class="{{ $clase[$i][$j] }}" data-hora="{{ $i }}" data-dia="{{ $j }}">{{ $modulo[$i][$j] }}</td>
					@else
						<td>{{ $modulo[$i][$j] }}</td>
					@endif
				@else
					<td></td>
				@endif
			@endfor
		</tr>
	@endfor
</table>
<script type="text/javascript">
	$('.mod-select').click(function(event) {
		event.preventDefault();
		var horario = $(this);
		var asig = $('#asig-select').val();
		$.ajax({
			type: "POST",
		    url: base_path+'/modulo/byHorarioAsignatura',
		    dataType: 'JSON',
		    data: { 
		    	asignatura : asig,
		    	hora: horario.data('hora'),
		    	dia: horario.data('dia') 
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
		      $('#right-container').html(res['widget']);
		    }else{
		    	$('#right-container').html('');
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>