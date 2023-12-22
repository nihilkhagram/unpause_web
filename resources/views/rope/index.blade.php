@include('header')
@include('sidebarnew')

<?php $baseurl = URL::to('/'); if($errors->any()){ //print_r($errors);exit;
}?>
<!-- BEGIN: Content -->
            <div class="content">
                <!-- BEGIN: Top Bar -->
                @include('topbar')
                <!-- END: Top Bar -->
                <h2 class="intro-y text-lg font-medium mt-10">
                    Rope List
					<!-- Used For Table Row Status Active/InActive -->
					<input type="hidden" name="tablename" id="tablename" value="{{$context->tablename}}">	
					<input type="hidden" name="feildname" id="feildname" value="Is_active">	
					<!-- Used For Table Row Status Active/InActive -->
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">
					
				   
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                        <a href="{{URL::to('/rope/create')}}"><button class="btn btn-primary shadow-md mr-2">Add New Rope</button></a>
                        <div class="dropdown">
                            <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                            </button>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block mx-auto text-gray-600 " id="sample_3_info_top">Showing <span id="totalIniRecords">0</span> to <span id="totalDisRecords">0</span> of <span id="totalRecords">0</span> entries</div>
                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                                <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" id="search_feild" placeholder="Search...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-auto">
                        <form method="POST" id="searchFilter" accept-charset="UTF-8" class="form-horizontal" parsley-validate="" novalidate=" "  >
										@csrf
                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="list_user_id" value="{{ request()->route('list_user_id')}}">
										<input type="hidden" name="search_input" id="search_input" value="">
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                <div class="input-group m-b" style="width:180px !important;">

                                                    <select name="created_by" class="form-control created_by hide">
                                                    <option value="">Select</option>
                                                     @if(isset($user_list) && $user_list != "")
											<?php foreach($user_list as $key=>$user){ ?>
												<option value="{{ $user->id }}" <?php if(app('request')->input('userid') == $user->id){ echo 'selected="selected" '; } ?>>{{ isset($user->firstname) ? $user->firstname : '' }}</option>
											<?php } ?>
										@endif
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                        </form>
						<!-- MULTI-ACTION MENU START -->
						@include('layouts.admin.table_action',array('column'=> 'Is_active','page_details'=>$context,'head'=>1))
						<!-- MULTI-ACTION MENU END -->
                        <table class="table table-report -mt-2 order-column" id="sample_3">
                            <thead>
                                <tr>
								<th><center><input type="checkbox" id="selectchkall" class="form-check-input flex-none allchecksel" /></center></th>
                                    <th class="text-center whitespace-nowrap">Id</th>
									<!--<th class="text-center whitespace-nowrap">Linked_with</th>-->
									<!-- <th class="text-center whitespace-nowrap">Title</th> -->
									<th class="text-center whitespace-nowrap">Type</th>
									<th class="text-center whitespace-nowrap">Size</th>
                                    <th class="text-center whitespace-nowrap">Price</th>
                                    <th class="text-center whitespace-nowrap">Image</th>
                                    <th class="text-center whitespace-nowrap">Created_dt</th>
                                    <th class="text-center whitespace-nowrap">STATUS</th>
                                    <th class="text-center whitespace-nowrap">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- END: Data List -->
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->
                <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="p-5 text-center">
                                    <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                                    <div class="text-3xl mt-5">Are you sure?</div>
                                    <div class="text-gray-600 mt-2">
                                        Do you really want to delete these records? 
                                        <br>
                                        This process cannot be undone.
                                    </div>
                                </div>
                                <div class="px-5 pb-8 text-center">
                                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                    <button type="button" class="btn btn-danger w-24">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Delete Confirmation Modal -->
            </div>
<!-- END: Content -->
@include('footer')
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="{{ asset('public/js/admin-table-view.js') }}" type="text/javascript"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">

<script>
var loaderpath = "{{ asset('public/loader.gif') }}"; 
var imgpath = '<center id="loader"><svg width="20" viewBox="0 0 58 58" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8"><g fill="none" fill-rule="evenodd">    <g transform="translate(2 1)" stroke="rgb(45, 55, 72)" stroke-width="1.5"><circle cx="42.601" cy="11.462" r="5" fill-opacity="1" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="1;0;0;0;0;0;0;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="49.063" cy="27.063" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;1;0;0;0;0;0;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="42.601" cy="42.663" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;0;1;0;0;0;0;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="27" cy="49.125" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;0;0;1;0;0;0;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="11.399" cy="42.663" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;0;0;0;1;0;0;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="4.938" cy="27.063" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;0;0;0;0;1;0;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="11.399" cy="11.462" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;0;0;0;0;0;1;0" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="27" cy="5" r="5" fill-opacity="0" fill="rgb(45, 55, 72)">    <animate attributeName="fill-opacity" begin="0s" dur="1.3s" values="0;0;0;0;0;0;0;1" calcMode="linear" repeatCount="indefinite"></animate></circle>    </g></g></svg></center>';
 function datatablefilter(){
          
            var viewid = 'rope_filter';
        
        $("#sample_3").DataTable().destroy();
            $("#sample_3").DataTable({
                "order": [[1, "desc"]],
                "pageLength": 10,
				oLanguage: {
					// sProcessing: "<center><img src='"+loaderpath+"' style='width:180px;'></center>"
					sProcessing: imgpath
				},
                'serverSide': true,
                'processing': true,
                'serverMethod': 'post',
                "ajax": {
                       'url':  viewid+'?'+$('#searchFilter').serialize(),
                       data: function( d ) {
							// console.log(d);	
                        }
                },
				"initComplete":function( settings, json){
					// console.log(json);
					// call your function here
					// if(json.iTotalDisplayRecords > 0){
						// let totalIniRecords = json.draw * 10;
						// totalIniRecords = totalIniRecords - 9;
						// $("#totalIniRecords").html(totalIniRecords);
					// }
					// $("#totalRecords").html(json.iTotalDisplayRecords);
					// $("#totalDisRecords").html(json.iTotalRecords);
					$("#sample_3_info_top").html($("#sample_3_info").html())
				},
				"columnDefs": [
					{ "orderable": false, "targets": 0 },
					{ "orderable": false, "targets": 7 }
				  ],

                "columns": [
							{ "data": "chk" },
                            { "data": "id" },
							//{ "data": "lname" },
                            //{ "data": "doorset_title" },
							{ "data": "Size" },
							{ "data": "type" },
                            { "data": "price" },
							{ "data": "image" ,render: function( data, type, full, meta ) {
								if(data == "")
								{
									return "N/A";
								}else{
								return "<img src={{URL::to('/')}}/public/" + data + " style='height:80px;width:150px;text-align:center' class='img-thumbnail'/>";
								}
							}},
                            { "data": "Created_dt" },
                            { "data": "Is_active" },
                            { "data": "action" },
                         
                        ]
            });
    }
$(document).ready(function(){   
     
    setTimeout(function(){ datatablefilter(); }, 300);
    $('.created_by').on('change', function () {
        datatablefilter();  
    }); 
	
	$('.placeholder-theme-13').on('keydown', function () {
        $("#search_input").val($('#search_feild').val());
		datatablefilter();  
    });
	
});
</script>