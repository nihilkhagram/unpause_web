@if($value != "")
	@php $valueArr = (array) $value; @endphp
	<td>
	<div class="blockdata">
	@if(isset($valueArr["$feildname"]) && ($valueArr["$feildname"] == 0 || $valueArr["$feildname"] == 2))
		<button type="button" id='checkbox_{{ $value->id }}' data-id="{{ $value->id }}" data-status="1" data-token="{{ csrf_token() }}" class="flex items-center justify-center text-theme-6 tablestatuschange"><i id='i_{{ $value->id }}' data-feather="check-square" class="w-4 h-4 mr-2"></i> InActive </button>	
	@else
	
		<button type="button" id='checkbox_{{ $value->id }}' data-id="{{ $value->id }}" data-status="0" data-token="{{ csrf_token() }}" class="flex items-center justify-center text-theme-9 tablestatuschange"><i id='i_{{ $value->id }}' data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </button>	
	@endif
	</div>
	</td><br>
@endif
