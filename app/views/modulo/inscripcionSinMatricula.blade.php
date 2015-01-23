<div class="form-group">
	<div class="col-xs-12">
		{{ Form::text('alumno', '', array('id' => 'alu-al', 'form' => 'ins-alu', 'placeholder' => 'Ingrese su nombre', 'class' => 'col-xs-12', 'required' => 'required')) }}
	</div>
</div>
<div class="form-group">
	<div class="col-xs-12">
		{{ Form::email('email', '', array('id' => 'email-al', 'form' => 'ins-alu', 'placeholder' => 'Ingrese su email', 'class' => 'col-xs-12', 'required' => 'required')) }}
	</div>
</div>
<div class="form-group">
	<div class="col-xs-12">
		{{ Form::select('facultad', $facultades, 0, array('id' => 'facu-select', 'form' => 'ins-alu')) }}
	</div>
</div>
<div id="carr-ins-select"></div>
<div id="asig-ins-select"></div>
<div id="modu-asig"></div>
<script type="text/javascript">
	$('#facu-select').change(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/carrera/carrerasByFacultad',
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
		      $('#carr-ins-select').html(res['widget']);
		    }else{
		    	$('#carr-ins-select').html('');
		    	$('#asig-ins-select').html('');
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>