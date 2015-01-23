<div class="container-fluid main-container">
	<br>
	{{ Form::open(array('url' => '/modulo/inscribirAluHorario', 'class' => 'form-horizontal', 'role' => 'form', 'id' => "ins-alu")) }}
		<div class="col-sm-2" id="left-container">
			<div class="row">
				<div class="form-group">
					<div class="col-xs-12">
						{{ Form::text('matricula', '', array('id' => 'ins-mat-al', 'form' => 'ins-alu', 'placeholder' => 'Ingrese su matrícula', 'class' => 'col-xs-12', 'autofocus' => 'autofocus')) }}
					</div>
				</div>
				<div id="info-alu-sol">
				</div>	
			</div>
		</div>
		<div class="col-sm-7" id="middle-container">
		</div>
		<div class="col-sm-3" id="right-container">
		</div>
	{{ Form::close() }}
</div>