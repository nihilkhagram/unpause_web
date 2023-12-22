@extends('layouts.layout')
@section('title', 'Edit Service')
<?php $baseurl = URL::to('/'); ?>
@section('content')
		
		<div class="intro-y flex items-center">
			<h2 class="intro-y text-lg font-medium mt-10">
                    Edit Service
			</h2>
		</div>
		<div class="grid grid-cols-12 gap-6 mt-5"	>
			
			<div class="intro-y col-span-12 lg:col-span-12">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
					
					{!! Form::open(['route' => ['servicemaster.update',$service->id],'id' => 'form_sample_2', 'class' => 'form-horizontal form-row-seperated', 'files' => true ,'method'=> 'post','enctype' => 'multipart/form-data']) !!}
                    @method('put')
							@include ('servicemaster.form')

					{!! Form::close() !!}
					
				</div>
				<!-- END: Form Layout -->
			</div>
		</div>
	<!-- END: Content -->	
@endsection	
	
	
                