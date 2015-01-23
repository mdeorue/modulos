<div class="row">
	<div class="col-sm-4">
		<h3>Solicitudes Totales</h3>
		<div class="text-center">
			<b>{{ $cantidadPendientes }}</b>
		</div>
	</div>
	<div class="col-sm-4">
		<h3>Solicitudes Completas</h3>
		<div class="text-center">
			<b>{{ $cantidadPendientes }}</b>
		</div>		
	</div>
	<div class="col-sm-4">		
		<h3>Solicitudes Pendientes</h3>
		<div class="text-center">
			<b>{{ $cantidadPendientes }}</b>
		</div>
	</div>
</div>
<div class="row">
	@if($completos->count())
		@foreach($completos as $completo)
			<p class="completo">{{ $completo->id }} |  {{ $completo->asignatura }}</p>
		@endforeach
	@endif
	@if($pendientes->count())
		@foreach($pendientes as $pendiente)
			<p class="pendiente">{{ $pendiente->solicitudes }}</p>
		@endforeach
	@endif
</div>