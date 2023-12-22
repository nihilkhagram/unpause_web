@include('header')
@include('sidebarnew')

<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
	<div class="content">
		<!-- BEGIN: Top Bar -->
		@include('topbar',['page_name'=>'OTA'])
		<!-- END: Top Bar -->
		<div class="intro-y flex items-center mt-8">
			<h2 class="text-lg font-medium mr-auto">
			Test
			</h2>
		</div>
		<div class="grid grid-cols-12 gap-6 mt-5"	>
			
			<div class="intro-y col-span-12 lg:col-span-6">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
					
					{!! Form::open(['url' => 'otas','id' => 'form_sample_2', 'class' => 'form-horizontal form-row-seperated', 'files' => true ,'method'=> 'post','enctype' => 'multipart/form-data']) !!}

                        <div class="input-form mt-3">
                            {!! Form::label('STM', 'STM', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						    {!! Form::file('stm_file') !!}
							<br><br>
							Current STM file <a class="btn" href="{{$ota->stm_file}}" target="_blank">View</a>
						</div>
                        <div class="input-form mt-3">
                            {!! Form::label('OTA', 'OTA', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
						    {!! Form::file('ota_file') !!}
							<br><br>
							Current OTA file <a class="btn" href="{{$ota->ota_file}}" target="_blank" >View</a>
						</div>
                        @include ('save_btn',[''=>'']) 
					{!! Form::close() !!}
					
				</div>
				<!-- END: Form Layout -->
			</div>
		</div>
	</div>
	<!-- END: Content -->
	
@include('footer')	
	
	
	
                