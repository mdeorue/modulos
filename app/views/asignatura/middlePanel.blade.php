<div class="col-sm-8" id="middle-container">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Código</th>
				<th>Asignatura</th>
				<th>Semestre</th>
				<th>Opc.</th>
			</tr>
		</thead>
		<tbody>
			@if($asignaturas->count())
				@foreach($asignaturas as $asignatura)
					<tr>
						<td>{{ $asignatura->id }}</td>
						<td>{{ $asignatura->codigo }}</td>
						<td>{{ $asignatura->asignatura }}</td>
						<td>{{ $asignatura->nivel }}</td>
						<td><a href="#" class="glyphicon glyphicon-remove asig-remove" title="Eliminar Asignatura" data-asig="{{ $asignatura->id }}"></a></td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$('.asig-remove').click(function(event){
		event.preventDefault();
		$.ajax({
			type: "POST",
		    url: base_path+'/asignatura/eliminar',
		    dataType: 'JSON',
		    data: {
		    	asignatura: $(this).data('asig')
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
		    	alertify.success(res['mensaje']);
		    	location.reload();
		    }else{
		    	alertify.error(res['mensaje']);
		    }
		})
		.always(function() {
			$('#loading-div').fadeOut();
		});
	});
</script>