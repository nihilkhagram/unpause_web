<style>
    .chkown{
      height: 22px;
      width: 20px;
    }
    table th,td{
        padding: 10px;
        border: 1px solid black;
        border-collapse: collapse;
      }
</style>
<div class="input-form">
  {!! Form::label('name', 'Role Name*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('role_name', isset($role_name) ? $role_name->role_name : null, ['required', 'class' => 'form-control w-full','placeholder' => 'Role Name']) !!}
</div>
<div class="table-responsive mb-4 mt-4">
								<table border="1" style="width:100%">
								
										<tr>
                      <th rowspan="2">Modules</th>
											<th colspan="7">Permission</th>
										</tr>
										<tr>
											<td style="text-align:center">View all<br><input type="checkbox" style="text-align:center" id="viewall" class="chkown" ></td>
											<td style="text-align:center">View own<br><input type="checkbox" id="viewown" class="chkown" ></td>
											<td style="text-align:center">create<br><input type="checkbox" id="create" class="chkown" ></td>
											<td style="text-align:center">Edit all<br><input type="checkbox" id="editall" class="chkown" ></td>
											<td style="text-align:center">Edit own<br><input type="checkbox" id="editown" class="chkown" ></td>
											<td style="text-align:center">Delete<br><input type="checkbox" id="delete" class="chkown" ></td>
											<td style="text-align:center">Delete own<br><input type="checkbox" id="deleteown" class="chkown" ></td>
                      
										</tr>
								
								
										@php $previous_parent = '';@endphp
										@foreach($module_details as $key => $value)
										 @php $is_parent = $value['is_parent'];@endphp
											<tr>
												@if($value->is_parent == 0)
												<th>{{$value->module_name}}</th>
												@else
													<th>{{$value->module_name}}</th>
												@endif
												<input type="hidden" name="module_id[]" value="{{$value->id}}">
												<td style="text-align:center"><input type="checkbox" @if($value->viewall == 1) checked @endif class="chkown control-label view_all" id="view_all" name="view_all{{$key}}" value="viewall"></td>
												<td style="text-align:center"><input type="checkbox" @if($value->viewown == 1) checked @endif class="chkown control-label view_own" name="view_own{{$key}}" value="viewown"></td>
												<td style="text-align:center"><input type="checkbox" @if($value->create == 1) checked @endif class="chkown control-label create" name="create{{$key}}" value="create"></td>
												<td style="text-align:center"><input type="checkbox" @if($value->editall == 1) checked @endif class="chkown control-label edit_all" name="edit_all{{$key}}" value="editall"></td>
												<td style="text-align:center"><input type="checkbox" @if($value->editown == 1) checked @endif class="chkown control-label edit_own" name="edit_own{{$key}}" value="editown"></td>
												<td style="text-align:center"><input type="checkbox" @if($value->delete == 1) checked @endif class="chkown control-label delete" name="delete{{$key}}" value="delete"></td>
												<td style="text-align:center"><input type="checkbox" @if($value->deleteown == 1) checked @endif class="chkown control-label delete_own" name="delete_own{{$key}}" value="deleteown"></td>
												
											</tr>
										@endforeach
									
								</table>
							</div>
							
							@include ('save_btn',[''=>''])