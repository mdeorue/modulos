<div class="col-sm-6">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Alumnos en Lista de Espera por Asignatura</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="col-xs-12">
		<table class="table">
			<thead>
				<tr>
					<th>Asignatura</th>
					<th>Alumnos</th>
				</tr>
			</thead>
			<tbody>
				@if($tleas->count())
					@foreach($tleas as $tlea)
						<tr>
							<td>{{ $tlea->asignatura }}</td>
							<td>{{ $tlea->alumnos }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>