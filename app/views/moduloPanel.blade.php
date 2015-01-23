<div class="col-sm-4" id="left-container">
	{{ Form::open(array('url' => 'hola', 'class' => 'form-horizontal', 'role' => 'form')) }}
		<div class="form-group">
			<div class="col-xs-12">
				{{ Form::select('facultad', $facultades, 0, array('id' => 'facu-select')) }}
			</div>
		</div>
		<div id="select-mod-carr"></div>
		<div id="select-mod-asig"></div>
	{{ Form::close() }}
	<div id="modulos-init">
	</div>
</div>
<div class="col-sm-8" id="middle-container">
</div>
<script type="text/javascript">
	$('#facu-select').change(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/carrera/carrerasByFacultadMod',
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
		      $('#select-mod-carr').html(res['widget']);
		    }else{
		    	$('#select-mod-carr').html('');
		    	$('#select-mod-asig').html('');
		    	$('#modulos-init').html('');
		    	$('#middle-container').html('');
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>