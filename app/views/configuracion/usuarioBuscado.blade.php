<div class="col-xs-12">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Usuario</th>
				<th>Categoría</th>
				<th>Email</th>
				<th>Opc.</th>
			</tr>
		</thead>
		<tbody>
			@foreach($usuarios as $usuario)
				<tr>
					<td>{{ $usuario->usuario }}</td>
					<td>{{ Template::getCategoriaUsuario($usuario->categoria) }}</td>
					<td>{{ $usuario->email }}</td>
					<td>
						@if($usuario->categoria != 1)
							<a href="#" class="glyphicon glyphicon-pencil user-edit" title="Editar Usuario" data-user="{{ $usuario->id }}"></a>
							<a href="#" class="glyphicon glyphicon-remove user-remove" title="Eliminar Usuario" data-user="{{ $usuario->id }}"></a>
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>			