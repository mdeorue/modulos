<div class="col-xs-12 panel-header-2">
	<div class="col-xs-10">
		<h2>Bitácora Histórica</h2>
	</div>
	<div class="panel-header-2-toolbar pull-right">
		<a href="#" class="glyphicon glyphicon-chevron-left" title="Volver Atrás" id="back-bit-hist" data-mod="{{ $modulo }}"></a>
	</div>
</div>
<div class="col-sm-12">
	@if($bitacoras->count())
		@foreach($bitacoras as $bitacora)
			<div class="row">
				<div class="col-xs-3">
					{{ $bitacora->fecha }}
				</div>
				<div class="col-xs-8">
					{{ $bitacora->bitacora }}
				</div>
				<div class="col-xs-1">
					<a href="#" class="glyphicon glyphicon-pencil edit-bit" title="Editar Bitácora" data-asis="{{ $bitacora->id }}"></a>
				</div>
			</div>
		@endforeach
	@endif
</div>
<script type="text/javascript">
	$('#back-bit-hist').click(function(event) {
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