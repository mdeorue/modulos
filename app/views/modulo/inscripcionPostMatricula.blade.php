<div class="form-group">
	<div class="col-xs-12">
		<span class="glyphicon glyphicon-user"></span> {{ $alumno->alumno }}
	</div>
</div>
<div class="form-group">
	<div class="col-xs-12">
		@if(!empty($alumno->email))
			<span class="glyphicon glyphicon-envelope"></span> {{ $alumno->email }}
		@else
			{{ Form::email('email', '', array('id' => 'email-al', 'form' => 'ins-alu', 'placeholder' => 'Ingrese su email', 'class' => 'col-xs-12', 'required' => 'required')) }}
		@endif
	</div>
</div>				
<div class="form-group">
	<div class="col-xs-12">
		<span class="glyphicon glyphicon-briefcase"></span> {{ $alumno->facultad()->first()->facultad }}
	</div>
</div>
<div class="form-group">
	<div class="col-xs-12">
		<span class="glyphicon glyphicon-book"></span> {{ $alumno->carrera()->first()->carrera }}
	</div>
</div>
<div class="form-group">
	<div class="col-xs-12">
		@if(!is_null($asignaturas))
			{{ Form::select('asignatura', $asignaturas, 0, array('id' => 'asig-select', 'form' => 'ins-alu')) }}
		@endif
	</div>
</div>
<div id="modu-asig">
</div>

<script type="text/javascript">
	$('#asig-select').change(function(event) {
	  event.preventDefault();
	  var input = $(this);
	  $.ajax({
	    type: "POST",
	    url: base_path+'/modulo/modulosAsignatura',
	    dataType: 'JSON',
	    data: { 
	    	matricula : $('#ins-mat-al').val(),
	    	asignatura : input.val() 
	    },
	    beforeSend: function( xhr ) {
	      $('#loading-div').fadeIn();
	    }
	  })
	  .fail(function(jqXHR, textStatus, errorThrown) {
	    console.log(jqXHR);
	  })
	  .done(function( res ) {
	    console.log(res);
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