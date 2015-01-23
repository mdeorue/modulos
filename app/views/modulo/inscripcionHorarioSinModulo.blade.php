<table class="table table-bordered">
	@for($i = 0; $i < 12; $i++)
		<tr >
			@for($j = 0; $j < 6; $j++)
				@if(isset($modulo[$i][$j]))
					@if(isset($clase[$i][$j]))
						<td class="{{ $clase[$i][$j] }}">{{ $modulo[$i][$j] }}</td>
					@else
						<td>{{ $modulo[$i][$j] }}</td>
					@endif
				@else
					<td></td>
				@endif
			@endfor
		</tr>
	@endfor
</table>
<script type="text/javascript">
	$('.mod-select').click(function(event) {
		event.preventDefault();
		if($(this).find('input:checkbox').is(":checked")) {
			$(this).find('input:checkbox').attr("checked", false);
  		}else{
      		$(this).find('input:checkbox').prop("checked", true);
  		}
	});
</script>