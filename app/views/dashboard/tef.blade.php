<div class="col-sm-6">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Alumnos por Facultad</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="col-xs-12">
		<table class="table">
			<thead>
				<tr>
					<th>Facultad</th>
					<th>Alumnos</th>
				</tr>
			</thead>
			<tbody>
				@if($tefs->count())
					@foreach($tefs as $tef)
						<tr>
							<td>{{ HTML::link('dashboard/facultad/'.$tef->idFacultad.'/'.$ciclo->id.'/'.$tef->facultad, $tef->facultad) }}</td>
							<td>{{ $tef->alumnos }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>