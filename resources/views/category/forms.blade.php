
<div class="input-form mt-3 ">
  {!! Form::label('category_name', 'Category Name*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('category_name', isset($category->category_name) ? $category->category_name : null, [ 'required','class' => 'form-control w-full','placeholder' => 'Category Name']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('category_short_info*', 'Category Short Info', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('category_short_info', isset($category->category_short_info) ? $category->category_short_info : null, [ 'class' => 'form-control w-full','placeholder' => 'Category Short Info']) !!}
</div>
<!-- <div class="input-form mt-3 ">
 <lable class='form-label w-full flex flex-col sm:flex-row'>Enable Title</lable>
  {!! Form::select('enable', ['0'=>'No','1'=>'Yes'],  isset($banner->enable) ? $banner->enable : 0,['required', 'class' => 'form-control  w-full','placeholder' => 'Enable Title']) !!}
</div> -->
<!--<div class="input-form mt-3">
  {!! Form::label('long_description', 'Long Description', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::textarea('long_description', isset($category->long_description) ? $category->long_description : null, ['class' => 'form-control w-full','rows'=>'5','placeholder' => 'Long Description']) !!}
</div>-->
<div>
@if (isset($category->category_image) && $category->category_image !="")
   <img src="{{asset($category->category_image)}}" alt="icon" class="block img-thumbnail" style='height:80px;width:150px;' >
@endif
</div>
<div class="input-form mt-3">
  {!! Form::label('category_image', 'Category Image', ['required','class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::file('category_image', ['class' => 'form-control']) !!}
</div>
<div class="input-form mt-3">
  {!! Form::label('name', 'Status*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('is_active',['1'=>'Active','2'=>'InActive'],isset($detail->is_active) ? $detail->is_active : null, ['required','class' => 'form-control']) !!}
</div>

@include ('save_btn',[''=>'']) 




