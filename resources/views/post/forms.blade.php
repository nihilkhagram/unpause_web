@php
	$cabintypeArr = \App\Category::where('is_active',1)->get();
	$cabinArr = array();
	$cabinArr[''] = 'Select';
	if($cabintypeArr != NULL){
		foreach($cabintypeArr AS $res){
			$cabinArr[$res->id] = $res->category_name;
			
		}
	}
@endphp
<div class="input-form">
  {!! Form::label('name', 'Category Title*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('category_id',$cabinArr,isset($detail->category_id) ? $detail->category_id : null, ['required','class' => 'form-control select2']) !!}
</div>
<div class="input-form">
  {!! Form::label('name', 'Title*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('title', isset($detail->title) ? $detail->title : null, ['required', 'class' => 'form-control w-full','placeholder' => 'title']) !!}
</div>

<div class="input-form mt-3">
						  {!! Form::label('short_desc', 'Short Desc', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::textarea('short_desc', isset($detail['short_desc']) ? $detail['short_desc'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'short_desc','placeholder' => 'Short Desc']) !!}
						</div>
            <div class="input-form mt-3">
						  {!! Form::label('long_desc', 'Long Desc', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::textarea('long_desc', isset($detail['long_desc']) ? $detail['long_desc'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'long_desc','placeholder' => 'Long Desc']) !!}
						</div>

<div>
@if (isset($detail->videos) && $detail->videos !="")
   <!-- <img src="{{asset($detail->videos)}}" alt="icon" class="block img-thumbnail" style='height:80px;width:150px;' > -->
   <iframe src="{{asset($detail->videos)}}" ></iframe>
@endif
</div>
<div class="input-form mt-3">
  {!! Form::label('videos', 'videos', ['required','class' => 'form-label w-full flex flex-col sm:flex-row videos']) !!}
  {!! Form::file('videos', ['class' => 'form-control']) !!}
</div>

<div class="input-form mt-3">
{!! Form::label('approve_status', 'Approve Status *', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
{!! Form::select('app1rove_status', ['Pending' => 'Pending','Verified' => 'Verified','Active' => 'Active','Rejected' => 'Rejected'], isset($detail->approve_status) ? $detail->approve_status : null, ['required','class' => 'form-control w-full select2','placeholder' => '']) !!}
           </div>


<div class="input-form mt-3">
  {!! Form::label('name', 'Reward Points*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::number('reward_points', isset($detail->reward_points) ? $detail->reward_points : null, ['required','class' => 'form-control w-full','placeholder' => 'Reward Points']) !!}
</div>
@if(isset($detail->videos))
<div class="input-form mt-3">
  {!! Form::label('youtube_url', 'Youtube Url', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('youtube_url', isset($detail->youtube_url) ? $detail->youtube_url : null, ['required','class' => 'form-control w-full youtube','placeholder' => 'Youtube Url']) !!}
</div>
   
        
   @endif

<div class="input-form mt-3">
  {!! Form::label('name', 'Status*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::select('is_active',['1'=>'Active','2'=>'InActive'],isset($detail->is_active) ? $detail->is_active : null, ['required','class' => 'form-control']) !!}
</div>


@include ('save_btn',[''=>'']) 
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
	CKEDITOR.replace('short_desc');
	CKEDITOR.replace('long_desc');
	
</script>
<script >
    let videos = document.querySelector(".videos");
let youtube = document.querySelector(".youtube");

youtube.disabled = true; //setting button state to disabled

videos.addEventListener("change", stateHandle);

function stateHandle() {
    if (document.querySelector(".videos").value === "") {
      youtube.disabled = true; //button remains disabled
    } else {
      youtube.disabled = false; //button is enabled
    }
}
</script>





