<div class="form-group">
	<div class="col-xs-12">
		@if(isset($modulos))
			{{ Form::select('modulo-asig', $modulos, 0, array('id' => 'mod-asig-select', 'form' => 'ins-alu')) }}
		@endif
	</div>
</div>