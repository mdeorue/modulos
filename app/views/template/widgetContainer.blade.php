<div class="container-fluid main-container">
	@if(isset($title))
	<div class="row">
		<div id="panel-header" class="col-xs-12">
			<div class="col-xs-10">
				<h1>{{ $title }}</h1>
			</div>
			@if(isset($toolbar))
				<div class="col-xs-2 panel-header-toolbar">
					@foreach($toolbar as $bar)
						{{ $bar }}
					@endforeach
				</div>
			@endif
		</div>
	</div>
	@endif
	<div class="row">
		@if(isset($widgets))
			@foreach($widgets as $widget)
				{{ $widget }}
			@endforeach
		@endif
	</div>
</div>