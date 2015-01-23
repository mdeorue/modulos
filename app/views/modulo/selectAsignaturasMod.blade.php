<div class="form-group">
	<div class="col-xs-12">
		{{ Form::select('asignatura', $asignaturas, 0, array('id' => 'asig-select', 'form' => 'form-crear-modulo')) }}
	</div>
</div>
<script type="text/javascript">
	$('#asig-select').change(function(event) {
	  event.preventDefault();
	  var input = $(this);
	  $.ajax({
	    type: "POST",
	    url: base_path+'/modulo/modulosAsignaturaMod',
	    dataType: 'JSON',
	    data: { asignatura : input.val() },
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
	});
</script>