@php
	$liftTypeArr = \App\Role::get();
	$liftArr = array();
	$liftArr[''] = 'Select';
	if($liftTypeArr != NULL){
		foreach($liftTypeArr AS $res){
			$liftArr[$res->id] = $res->role_name;
		}
	}
@endphp
<div class="input-form">
  {!! Form::label('name', 'Role Title*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('role',$liftArr,isset($detail->role) ? $detail->role : null, ['required','class' => 'form-control select2']) !!}
</div>


<div class="input-form" style="margin-top:20px;">
  {!! Form::label('name', 'Name*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('name', isset($detail->name) ? $detail->name : null, ['required', 'class' => 'form-control w-full','placeholder' => 'name']) !!}
</div>
<!--<div class="input-form mt-3">
  {!! Form::label('name', 'role*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('role', isset($detail->role) ? $detail->role : null, ['required','class' => 'form-control w-full','placeholder' => 'role']) !!}
</div>-->
<div class="input-form mt-3">
  {!! Form::label('name', 'Email*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('email', isset($detail->email) ? $detail->email : null, ['required','class' => 'form-control w-full','placeholder' => 'Email']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('name', 'Password*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::password('password', isset($detail->null) ? $detail->password : null, ['required','class' => 'form-control w-full','placeholder' => 'Password']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('name', 'Status*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('Is_active',[''=>'Select','1'=>'Active','2'=>'InActive'],isset($detail->Is_active) ? $detail->Is_active : null, ['required','class' => 'form-control']) !!}
</div>



@include ('save_btn',[''=>'']) 




