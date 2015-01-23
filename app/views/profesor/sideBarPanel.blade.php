<div class="col-sm-4" id="left-container">
	@if($modulos->count())
		<p>Selecciona el módulo que deseas ver</p>
		@foreach($modulos as $modulo)
			<div class="modulo-init-desc" data-mod="{{ $modulo->id }}">
				{{ $modulo->asignatura()->first()->codigo }} - {{ $modulo->modulo }} - {{ $modulo->asignatura()->first()->asignatura }}
			</div>
		@endforeach
	@endif

	@if(Auth::user()->categoria == 1)
		<div class="row">
			<div class="col-xs-12">
				<h3>Constancia</h3>
				{{ Form::open(array('url' => 'tutor/constanciaTutor', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-prof-cons')) }}
					<div class="col-xs-7">
						{{ Form::select('ciclo', $ciclo, array('id' => 'sel-cons-ciclo')) }}
						{{ Form::hidden('profesor', $profesor, array('id' => 'txt-prof-cons')) }}
					</div>
					<div class="col-xs-5">
						{{ Form::submit('Emitir', array('id' => 'btn-emit-cons', 'class' => 'btn btn-default btn-sm')) }}
					</div>
				{{ Form::close() }}
			</div>
		</div>

		<script type="text/javascript">
			var myForm = document.getElementById('form-prof-cons');
			myForm.onsubmit = function() {
			    var w = window.open('about:blank','Popup_Window','width=600,height=400,left = 312,top = 234');
			    this.target = 'Popup_Window';
			};
		</script>
	@endif
</div>
<div class="col-sm-8" id="middle-container">
</div>
<script type="text/javascript">
	$('.modulo-init-desc').click(function(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/profesor/detalleModulo',
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