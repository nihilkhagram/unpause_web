@include('header')
@include('sidebarnew')

<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
	<div class="content">
		<!-- BEGIN: Top Bar -->
		@include('topbar',['page_name'=>'Module Create'])
		<!-- END: Top Bar -->
		<div class="intro-y flex items-center mt-8">
			<h2 class="text-lg font-medium mr-auto">
				Role Module
			</h2>
		</div>
		<div class="grid grid-cols-12 gap-6 mt-5"	>
			
			<div class="intro-y col-span-12 lg:col-span-6">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
					
					{!! Form::open(['route' => ['roleModule.store'],'id' => 'form_sample_2', 'class' => 'form-horizontal form-row-seperated', 'files' => true ,'method'=> 'post','enctype' => 'multipart/form-data']) !!}
                   
							@include ('roleModule.form')

					{!! Form::close() !!}
					
				</div>
				<!-- END: Form Layout -->
			</div>
		</div>
	<!-- END: Content -->		
@include('footer')	
<script>
    
    function show_parent_data(){
        var module_type = $("#module_type").val();
        if(module_type == 0)
        {
            $("#parent_module").hide();
        }else if(module_type == 1){
            $("#parent_module").show();
        }else{
            $("#parent_module").show();
        }
    }

	</script>
	
	
                