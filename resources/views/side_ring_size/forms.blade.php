<div class="input-form">
  {!! Form::label('side_ring_size', 'sidering size*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('side_ring_size', isset($detail->side_ring_size) ? $detail->side_ring_size : null, ['required', 'class' => 'form-control w-full','placeholder' => 'side ring size']) !!}
</div>

  

<div class="input-form mt-3">
  {!! Form::label('name', 'Status*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('Is_active',[''=>'Select','1'=>'Active','2'=>'InActive'],isset($detail->Is_active) ? $detail->Is_active : null, ['required','class' => 'form-control']) !!}
</div>


@include ('save_btn',[''=>'']) 




