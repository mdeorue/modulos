<div class="form-group">
	<div class="col-xs-12">
		{{ Form::select('carrera', $carreras, 0, array('id' => 'carr-select', 'form' => 'ins-alu')) }}
	</div>
</div>
<script type="text/javascript">
	$('#carr-select').change(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/asignatura/AsignaturasByCarrera',
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
		      $('#asig-ins-select').html(res['widget']);
		    }else{
		    	$('#asig-ins-select').html('');
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>