@include('header')
@include('sidebarnew')

<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
	<div class="content">
		<!-- BEGIN: Top Bar -->
		@include('topbar',['page_name'=>'Site Setting'])
		<!-- END: Top Bar -->
		<div class="intro-y flex items-center mt-8">
			<h2 class="text-lg font-medium mr-auto">
				SiteSetting
			</h2>
		</div>
		@foreach($sitesetting as $s)
		<div class="grid grid-cols-12"	>
			
			<div class="intro-y col-span-12">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
					
					{!! Form::open(['url' => ['/site_setting', 1],'id' => 'form_sample_2', 'class' => 'form-horizontal form-row-seperated', 'files' => true ,'method'=> 'PATCH','enctype' => 'multipart/form-data']) !!}

					
	<div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-6">
            <div class="input-form">
                {!! Form::label('company_name', 'Company Name*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::text('company_name',$s['company_name'], ['required', 'class' => 'form-control w-full','placeholder' => 'Company Name']) !!}
            </div>
        </div>
	</div>	
    <div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-6">
            <div class="input-form">
                {!! Form::label('Address', 'Address*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::textarea('address',$s['address'], ['required', 'class' => 'form-control w-full','rows'=>'3','placeholder' => 'Address']) !!}
            </div>
        </div>
	</div>	
    <div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-6">
            <div class="input-form">
                {!! Form::label('pan_no', 'PAN No*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::text('pan_no',$s['pan_no'], ['required', 'class' => 'form-control w-full','placeholder' => 'PAN No']) !!}
            </div>
        </div>
	</div>	
	<div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-6">
            <div class="input-form">
                {!! Form::label('cin_no', 'CIN No*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::text('cin_no',$s['cin_no'], ['required', 'class' => 'form-control w-full','placeholder' => 'CIN No']) !!}
            </div>
        </div>
	</div>	
    <div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-6">
            <div class="input-form">
                {!! Form::label('telephone_no', 'Telephone No*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::text('telephone_no',$s['telephone_no'], ['required', 'class' => 'form-control w-full','placeholder' => 'Telephone No']) !!}
            </div>
        </div>
	</div>	
    <div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-6">
            <div class="input-form">
                {!! Form::label('website', 'Website*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::text('website',$s['website'], ['required', 'class' => 'form-control w-full','placeholder' => 'website']) !!}
            </div>
        </div>
	</div>	
    <br>
					   <div class="col-span-12 lg:col-span-12">
            <div class="input-form ">
                <button  class="btn btn-primary w-24" type="submit" > Save</button>

            </div>		

					{!! Form::close() !!}
					
				</div>
			@endforeach
				<!-- END: Form Layout -->
			</div>
		</div>
	</div>
	<!-- END: Content -->
	
@include('footer')