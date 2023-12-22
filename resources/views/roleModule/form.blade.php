@if(sizeof($module_details)>0)
<div class="input-form">
  {!! Form::label('name', 'Module Type', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('is_parent',[''=>'SelectType','0'=>'Parent','1'=>'Chield'],null,['required','id'=>'module_type','class' => 'form-control js-example-basic-single','onchange'=>'show_parent_data();']) !!}
</div>
@endif
<div class="input-form mt-3" id="parent_module" style="display:none">
  {!! Form::label('name', 'Parent Module', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('parent_module',$module_details,  null,['required','class' => 'form-control w-full js-example-basic-single']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('name', 'Module Name*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('module_name',null,['required','class' => 'form-control w-full']) !!}
</div>

@include ('save_btn',[''=>''])