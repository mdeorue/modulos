<div class="col-sm-6">
	<div class="col-xs-12 panel-header-2">
		<div class="col-xs-10">
			<h2>Indicadores básicos</h2>
		</div>
		<div class="panel-header-2-toolbar pull-right">
		</div>
	</div>
	<div class="col-xs-12">
		<table class="table">
			<tbody>
				@if(isset($indicadores))
					@foreach($indicadores as $kpi)
						<tr>
							<td>{{ $kpi['indicador'] }}</td>
							<td>{{ $kpi['valor'] }}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>