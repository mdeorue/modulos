<div class="form-group">
	<div class="col-xs-12">
		{{ Form::select('asignatura', $asignaturas, 0, array('id' => 'asig-select', 'form' => 'ins-alu')) }}
	</div>
</div>
<script type="text/javascript">
	$('#asig-select').change(function(event) {
	  event.preventDefault();
	  var input = $(this);
	  $.ajax({
	    type: "POST",
	    url: base_path+'/modulo/modulosAsignatura',
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
	    if(res['resultado']){
	      $('#middle-container').html(res['widget']);
	      $('#modu-asig').html(res['widgetModulos']);
	    }else{
	    	$('#middle-container').html('');
	    	$('#right-container').html('');
	    }
	  })
	  .always(function() {
	    $('#loading-div').fadeOut();
	  });
	});
</script>