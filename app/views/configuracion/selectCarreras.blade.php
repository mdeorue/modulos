{{ Form::select('carrId', $carreras, 0, array('id' => 'carr-select')) }}
<script type="text/javascript">
	$('#carr-select').change(function(event) {
		event.preventDefault();
		$.ajax({
			url: base_path+'/configuracion/aWidCarrera',
			type: 'POST',
			dataType: 'JSON',
			data: {
				carrera: $(this).val()
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
	      		$('#conf-carrera').html(res['widget']);
	    	}
	  	})
	  	.always(function() {
	    	$('#loading-div').fadeOut();
	  	});	
	});
</script>