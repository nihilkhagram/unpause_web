
@if(Session::has('flash_message_success'))
<div class="alert alert-success alert-dismissible show flex items-center intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2" role="alert">
 {{ Session::get('flash_message_success') }} 
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
</div>
@endif
@if(Session::has('flash_message_error'))
  <div class="alert alert-outline-danger alert-dismissible show flex items-center mb-2" role="alert">
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon w-6 h-6 mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg> {{ Session::get('flash_message_error') }} 
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
 </div>
@endif 
<?php /*
@if(Session::has('flash_message_success'))
<!-- BEGIN: Success Notification Content -->
	<div id="success-notification-content" class="toastify-content flex" >
		<i class="text-theme-9" data-feather="check-circle"></i> 
		<div class="ml-4 mr-4">
			<div class="font-medium">Success!</div>
			<div class="text-gray-600 mt-1"> {{ Session::get('flash_message_error') }} </div>
		</div>
	</div>
	<!-- END: Success Notification Content -->

@endif
@if(Session::has('flash_message_error'))
	<!-- BEGIN: Failed Notification Content -->
	<div id="failed-notification-content" class="toastify-content flex" >
		<i class="text-theme-6" data-feather="x-circle"></i> 
		<div class="ml-4 mr-4">
			<div class="font-medium">Failed!</div>
			<div class="text-gray-600 mt-1"> {{ Session::get('flash_message_error') }} </div>
		</div>
	</div>
<!-- END: Failed Notification Content -->
@endif	
*/ ?>
<!-- BEGIN: Form Layout -->
 @if ($errors->any())
	<div class="alert alert-danger show flex items-center mb-2">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif