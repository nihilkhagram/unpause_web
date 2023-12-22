@include('header')
@include('sidebarnew')
 <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
	<div class="content">
		<!-- BEGIN: Top Bar -->
		@include('topbar',['page_name'=>'Template'])
		<!-- END: Top Bar -->
		<div class="intro-y flex items-center mt-8">
			<h2 class="text-lg font-medium mr-auto">
				Template
			</h2>
		</div>
		@foreach($template as $s)
		<div class="grid grid-cols-12"	>
			
			<div class="intro-y col-span-12">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
					
					{!! Form::open(['url' => ['/pdf_template', $s['id']],'id' => 'form_sample_2', 'class' => 'form-horizontal form-row-seperated', 'files' => true ,'method'=> 'PATCH','enctype' => 'multipart/form-data']) !!}

					
	<div class="grid grid-cols-12  gap-4 ">
        <div class="col-span-12 md:col-span-10">
            <div class="input-form">
                {!! Form::label('template', 'Template *', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                <textarea name="content"><?php echo $s['content'] ?></textarea>
              </div>
        </div>
	</div>	
    <br>
	<div class="col-span-12 lg:col-span-12">
        <div class="input-form ">
            <button  class="btn btn-primary w-24" type="submit" > Save</button>
         </div>		
	</div>	 

					{!! Form::close() !!}
					
				</div>
			@endforeach
				<!-- END: Form Layout -->
			</div>
		</div>
	</div>
	<!-- END: Content -->
  <script>
            CKEDITOR.replace( 'content' );
        </script>
    	
@include('footer')