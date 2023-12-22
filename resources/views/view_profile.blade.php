@include('header')
@include('sidebarnew')

<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
	<div class="content">
		<!-- BEGIN: Top Bar -->
		@include('topbar',['page_name'=>'Profile'])
		<!-- END: Top Bar -->
		<div class="intro-y flex items-center mt-8">
			<h2 class="text-lg font-medium mr-auto">
				Profile
			</h2>
		</div>
		<div class="grid grid-cols-12 gap-6 mt-5"	>
			
			<div class="intro-y col-span-12 lg:col-span-6">
				@include('error_block',['errors'=> $errors])
				<div class="intro-y box p-5">
				
								<!-- BEGIN FORM-->
								<form action="{{ route('admin.profile.update') }}" class="form-horizontal" id="form_sample_1" method="post" enctype="multipart/form-data">
									@csrf
									<div class="form-body">
										
										<div class="form-group" style="margin-top:50px;">
												<label class="col-md-3 control-label">Name</label>
												<div class="col-md-4">
													<input type="text" name="name" class="form-control input-circle" value="{{Auth::user()->name}}" required>
												</div>
										</div>

										<div class="form-group" style="margin-top:20px;">
												<label class="col-md-3 control-label">Email</label>
												<div class="col-md-4">
													<input type="email" name="email" class="form-control input-circle" value="{{Auth::user()->email}}" required>
												</div>
										</div>

									</div>
									<div class="form-actions" style="margin-top:20px;">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<button onclick="this.disabled=true;this.form.submit();this.value='Submiting';" class="btn btn-primary w-24" type="submit" > Save</button>
												<a href="{{ url('/') }}" class="btn btn-danger btn-circle default">Cancel</a>
											</div>
										</div>
									</div>
								</form>
								<!-- END FORM-->
				
				</div>
				<!-- END: Form Layout -->
			</div>
		</div>
	</div>
	<!-- END: Content -->
	
@include('footer')		