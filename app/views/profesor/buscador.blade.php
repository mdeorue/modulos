<div class="col-sm-12" id="buscador-profesor">
	{{ Form::text('profesor', '', array('placeholder' => 'Ingrese matrícula de tutor/a', 'id' => 'search-txt-prof', 'class' => 'col-xs-9 col-sm-4')) }}
	{{ Form::button('Buscar', array('class' => 'btn btn-default btn-sm', 'id' => 'btn-search-prof')) }}
	<hr>
</div>
<div id="profesor-container">
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#search-txt-prof').autocomplete({
			source:'{{ url("/modulo/sugerirProfesor") }}', 
			minLength:3
		});
	});

	$('#btn-search-prof').click(function(event) {
			event.preventDefault();
			$.ajax({
			    type: "POST",
			    url: base_path+'/profesor/modulosProfesor',
			    dataType: 'JSON',
			    data: { 
			    	profesor : $('#search-txt-prof').val() 
			    },
			    beforeSend: function( xhr ) {
			      $('#loading-div').fadeIn();
			    }
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
			})
			.done(function(res) {
			    if(res['resultado']){
					$('#profesor-container').html(res['widget']);
				}else{
			    	alertify.error(res['mensaje']);
			    }
			})
			.always(function() {
				$('#loading-div').fadeOut();
			});
		});
</script>