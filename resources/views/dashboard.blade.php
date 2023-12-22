@include('header')
@include('sidebarnew')
<?php $baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
            <div class="content">
                <!-- BEGIN: Top Bar -->
                @include('topbar')
                <!-- END: Top Bar -->
                 <div class="intro-y flex items-center mt-8">
					<h2 class="text-lg font-medium mr-auto">
							Dashboard Management
					</h2>
				</div>
				<div class="grid grid-cols-12 gap-6 mt-5"	>

        <div class="intro-y col-span-12 lg:col-span-12 ">
            @include('error_block',['errors'=> $errors])
            <div class="intro-y p-5">

                {{-- individual dashboard links start --}}
                <div class="grid grid-cols-12 gap-6 mt-5">
                    {{-- Users manager start --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <a href="<?php echo $baseurl; ?>/users">
                                <div class="box p-5">
                                    {{-- <div class="flex"> --}}
                                        {{-- <i data-feather="command"  style='font-size:500px;color:rgb(241, 201, 67)'></i> --}}
                                        <i class='fa fa-users' style='font-size:30px;color:rgb(241, 201, 67)'></i>                                        {{-- <div class="ml-auto">
                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                        </div> --}}
                                    {{-- </div> --}}
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$dashboard_count['users_count']}}</div>
                                    <div class="text-base text-gray-600 mt-1">Users Management</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Users manager end --}}

                    {{-- Test count start --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <a href="<?php echo $baseurl; ?>/test">
                                <div class="box p-5">
                                    {{-- <div class="flex"> --}}
                                        <i class='fa fa-file-image' style='font-size:30px;color:rgb(133, 182, 238)'></i>                                        {{-- <div class="ml-auto">
                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                        </div> --}}
                                    {{-- </div> --}}
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$dashboard_count['test_count']}}</div>
                                    <div class="text-base text-gray-600 mt-1">Test Management</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Test count end --}}

                    {{-- Report start --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                           <a href="<?php echo $baseurl; ?>/reports">
                                <div class="box p-5">
                                    {{-- <div class="flex"> --}}
                                        <i class='fa fa-file' style='font-size:30px;color:rgb(136, 250, 108)'></i>                                        {{-- <div class="ml-auto">
                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                        </div> --}}
                                    {{-- </div> --}}
                                    <div class="text-3xl font-bold leading-8 mt-6"> {{$dashboard_count['report_count']}} </div>
                                    <div class="text-base text-gray-600 mt-1">Report</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Report end --}}
                    {{-- symptom start --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                           <a href="<?php echo $baseurl; ?>/symptom">
                                <div class="box p-5">
                                    {{-- <div class="flex"> --}}
                                        <i class='fa fa-clipboard' style='font-size:30px;color:rgb(136, 250, 108)'></i>                                        {{-- <div class="ml-auto">
                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                        </div> --}}
                                    {{-- </div> --}}
                                    <div class="text-3xl font-bold leading-8 mt-6"> {{$dashboard_count['symptom_count']}} </div>
                                    <div class="text-base text-gray-600 mt-1">Symptom</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Report end --}}

                                    </div>



            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
            </div>
<!-- END: Content -->
@include('footer')