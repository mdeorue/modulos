@if(isset($modulos))
	<p>Selecciona el módulo que deseas ver</p>
	@foreach($modulos as $modulo)
		<div class="modulo-init-desc" data-mod="{{ $modulo->id }}">{{ $modulo->asignatura()->first()->codigo }} - {{ $modulo->modulo }} - {{ $modulo->profesor()->first()->usuario }}</div>
	@endforeach
@endif
<script type="text/javascript">
	$('.modulo-init-desc').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/modulo/informacionModulo',
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
</script>