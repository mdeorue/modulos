<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Asignatura</th>
			<th>Tutor</th>
			<th>Disp.</th>
		</tr>
	</thead>
	<tbody>
		@if($modulos->count())
			@foreach($modulos as $modulo)
				<tr>
					<td>{{ $modulo->id }}</td>
					<td>{{ $modulo->asignatura()->first()->codigo }} - {{ $modulo->modulo }} - {{ $modulo->asignatura()->first()->asignatura }}</td>
					<td>{{ $modulo->profesor()->first()->usuario }}</td>
					<td>{{ ($modulo->capacidad - $modulo->solicitudes()->where('estado', '=', 1)->count()) }}</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>