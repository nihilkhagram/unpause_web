@php
	$FlooorArr = \App\FloorM::where('Is_active',1)->get();
	$FloorArr = array();
	$FloorArr[''] = 'Select';
	if($FlooorArr != NULL){
		foreach($FlooorArr AS $res){
			$FloorArr[$res->id] = $res->Floor_title;
			
		}
	}
@endphp
<!-- <div class="input-form">
  {!! Form::label('name', 'Floor Title*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('floor_id',$FloorArr,isset($detail->floor_id) ? $detail->floor_id : null, ['required','class' => 'form-control select2']) !!}
</div> -->
<!--<div class="input-form">
  {!! Form::label('name', 'Linked Title*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('Linked_with_id', isset($detail->Linked_with_id) ? $detail->Linked_with_id : null, ['required', 'class' => 'form-control w-full','placeholder' => 'Linked_with_id']) !!}
</div>-->
<div class="input-form">
  {!! Form::label('name', 'Size*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('Size', isset($detail->Size) ? $detail->Size : null, ['required', 'class' => 'form-control w-full','placeholder' => 'Size']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('name', 'Type*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('type', isset($detail->type) ? $detail->type : null, ['required','class' => 'form-control w-full','placeholder' => 'Type']) !!}
</div>

<div class="input-form mt-3">
  {!! Form::label('name', 'Price*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('price', isset($detail->price) ? $detail->price : null, ['required','class' => 'form-control w-full','placeholder' => 'Price']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('Image', 'Image*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::file('image') !!}
  
</div>
<?php if(isset($detail->image) && $detail->image != '')
  {
	  ?>
	  <input type="hidden" name="image_hidden" value="<?php echo $detail->image; ?>" >
	  <br><image src="{{URL($detail->image)}}" height="100px" width="100px">
<?php  }
			?>

<div class="input-form mt-3">
  {!! Form::label('name', 'Status*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('Is_active',[''=>'Select','1'=>'Active','2'=>'InActive'],isset($detail->Is_active) ? $detail->Is_active : null, ['required','class' => 'form-control']) !!}
</div>


@include ('save_btn',[''=>''])