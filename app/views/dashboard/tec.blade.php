<div class="col-sm-6">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Alumnos por Carrera</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="col-xs-12">
		<table class="table">
			<thead>
				<tr>
					<th>Carrera</th>
					<th>Alumnos</th>
				</tr>
			</thead>
			<tbody>
				@if($tecs->count())
					@foreach($tecs as $tec)
						<tr>
							<td>{{ HTML::link('dashboard/carrera/'.$tec->idCarrera.'/'.$ciclo->id.'/'.$tec->carrera, $tec->carrera) }}</td>
							<td>{{ $tec->alumnos }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>