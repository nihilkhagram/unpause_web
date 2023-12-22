@include('header')
@include('sidebarnew')

<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
	<div class="content">
		<!-- BEGIN: Top Bar -->
		@include('topbar',['page_name'=>'Create Role'])
		<!-- END: Top Bar -->
		<div class="intro-y flex items-center mt-8">
			<h2 class="text-lg font-medium mr-auto">
				Create Role
			</h2>
		</div>
		<div class="grid grid-cols-12 gap-6 mt-5"	>
			<div class="intro-y col-span-12 lg:col-span-12">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
					
					{!! Form::open(['route' => ['rolePermission.store'],'id' => 'form_sample_2', 'class' => 'form-horizontal form-row-seperated', 'files' => true ,'method'=> 'post','enctype' => 'multipart/form-data']) !!}
                   
							@include ('rolePermission.form')

					{!! Form::close() !!}
					
				</div>
				<!-- END: Form Layout -->
			</div>
		</div>
	<!-- END: Content -->
	
@include('footer')	
    <script>
	$(document).ready(function() {
		  $('#viewall').click(function() {
			var checked = this.checked;
			$('.view_all').each(function() {
			  this.checked = checked;
			});
		  })
			
		  $('#viewown').click(function() {
			var checked = this.checked;
			$('.view_own').each(function() {
			  this.checked = checked;
			});
		  })
		  
		$('#create').click(function() {
			var checked = this.checked;
			$('.create').each(function() {
			  this.checked = checked;
			});
		})
		
		$('#editall').click(function() {
			var checked = this.checked;
			$('.edit_all').each(function() {
			  this.checked = checked;
			});
		})
		
		$('#editown').click(function() {
			var checked = this.checked;
			$('.edit_own').each(function() {
			  this.checked = checked;
			});
		})
		
		$('#delete').click(function() {
			var checked = this.checked;
			$('.delete').each(function() {
			  this.checked = checked;
			});
		})
		
		$('#deleteown').click(function() {
			var checked = this.checked;
			$('.delete_own').each(function() {
			  this.checked = checked;
			});
		})
		
	});
	</script>
	
                