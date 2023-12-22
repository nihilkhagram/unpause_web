
<div class="input-form">
  {!! Form::label('name', 'Connected*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
  {!! Form::text('connected', isset($detail->connected) ? $detail->connected : null, ['required', 'class' => 'form-control w-full','placeholder' => 'Connected']) !!}
</div>

<div class="input-form mt-3">
						  {!! Form::label('disconnected', 'Disconnected', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('disconnected', isset($detail['disconnected']) ? $detail['disconnected'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'disconnected','placeholder' => 'Disconnected']) !!}
						</div>
            <div class="input-form mt-3">
						  {!! Form::label('firmware', 'Firmware', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('firmware', isset($detail['firmware']) ? $detail['firmware'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'firmware','placeholder' => 'Firmware']) !!}
						</div>
            <div class="input-form mt-3">
						  {!! Form::label('batteryLevel', 'Battery Level', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('batteryLevel', isset($detail['batteryLevel']) ? $detail['batteryLevel'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'batteryLevel','placeholder' => 'Battery Level']) !!}
						</div>
            <div class="input-form mt-3">
						  {!! Form::label('temperatureValue', 'Temperature Value', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('temperatureValue', isset($detail['temperatureValue']) ? $detail['temperatureValue'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'temperatureValue','placeholder' => 'Temperature Value']) !!}
						</div>

            <div class="input-form mt-3">
						  {!! Form::label('dateAndTimeValue', 'dateAndTimeValue', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('dateAndTimeValue', isset($detail['dateAndTimeValue']) ? $detail['dateAndTimeValue'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'dateAndTimeValue','placeholder' => 'dateAndTimeValue']) !!}
						</div>
            <div class="input-form mt-3">
						  {!! Form::label('alertLevel', 'alertLevel', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('alertLevel', isset($detail['alertLevel']) ? $detail['alertLevel'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'alertLevel','placeholder' => 'alertLevel']) !!}
						</div>
            
            <div class="input-form mt-3">
						  {!! Form::label('alertStatus', 'alertStatus', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('alertStatus', isset($detail['alertStatus']) ? $detail['alertStatus'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'alertLevel','placeholder' => 'alertStatus']) !!}
						</div>
            
            <div class="input-form mt-3">
						  {!! Form::label('manufacturerName', 'manufacturerName', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('manufacturerName', isset($detail['manufacturerName']) ? $detail['alertLevel'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'manufacturerName','placeholder' => 'manufacturerName']) !!}
						</div>
            
            <div class="input-form mt-3">
						  {!! Form::label('modelNumber', 'modelNumber', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('modelNumber', isset($detail['modelNumber']) ? $detail['modelNumber'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'modelNumber','placeholder' => 'modelNumber']) !!}
						</div>
            
            <div class="input-form mt-3">
						  {!! Form::label('serialNumber', 'serialNumber', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('serialNumber', isset($detail['serialNumber']) ? $detail['serialNumber'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'alertLevel','placeholder' => 'serialNumber']) !!}
						</div>
            
            <div class="input-form mt-3">
						  {!! Form::label('temperature', 'temperature', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						  {!! Form::text('temperature', isset($detail['temperature']) ? $detail['temperature'] : '', ['class' => 'form-control w-full ','rows'=>'5','id'=>'temperature','placeholder' => 'temperature']) !!}
						</div>



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





