<?php $baseurl = URL::to('/'); ?>
<!-- COMMON ALERT MESSAGES START -->
<style>
.hide{display:none !important;}
.table.dataTable tbody th, table.dataTable tbody td{text-align:center !important;}
.blockdata{margin-left: 20px !important;}
.sweet-alert .sa-icon { height: 95px !important;} 
.delete_btn{ width: 60px !important;}
.edit_btn{ color: rgba(255,255,255,var(--tw-text-opacity)) !important;width: 50px !important;}
#sample_3_filter{display:none !important;}
#load{
	margin-left: -36px;
    margin-top: -36px;
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background:url("/loader.gif") no-repeat center center rgba(0,0,0,0.25)
}
#searchFilter{
	margin-bottom : 30px;
}

.multiselectaction{
	width: 203px !important;
    margin-top: -27px !important;
    position: absolute;
    margin-left: 168px;
    height: 35px !important;
}
body {
	background-color: #fa5563 !important;
}
.side-nav>ul ul{
    background-color: #000;
}

.sweet-alert .sa-icon{
	height: 80px !important;
}
.sa-button-container{
	margin-top: 35px !important;
}
#selectchkall{
	background-color: white;
    height: 23px !important;
    width: 25px !important;
}
.error{
	color: #ec0404 !important;
}
.sweet-alert .sa-icon.sa-success .sa-placeholder { border: 4px solid #4cae4c !important; }
</style>
<div id="load"></div>
<span id="table_status_url" class="hide">{{ url('/statuschange') }}</span>
<span id="table_action_url" class="hide">{{ url('/tableaction') }}</span>
<span id="table_ajax_error" class="hide">Something went wrong!</span>
<span id="table_checkbox_del_error" class="hide">Please select atlease one checkbox</span>
<span id="table_selaction_error" class="hide">Please select action</span>
<span id="cancel_msg_error" class="hide">Cancelled</span>
<span id="delete_msg_error" class="hide">Deleted!</span>
<span id="confirm_msg_error" class="hide">Are you sure?</span>
<span id="confirm_yes_error" class="hide">Yes, I am sure!</span>
<span id="confirm_no_error" class="hide">No, cancel it!</span>
<!-- COMMON ALERT MESSAGES END -->

</div>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}"/>
	 <!-- Select2 CSS -->
    
	<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	
	    <!-- BEGIN: Dark Mode Switcher-->
       <!-- <div data-url="side-menu-dark-dashboard-overview-1.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
            <div class="dark-mode-switcher__toggle border"></div>
        </div>-->
        <!-- END: Dark Mode Switcher-->
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
       <!-- <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script> -->
        <script src="<?php echo $baseurl; ?>/assets/js/app.js"></script>
		<script src="{{ asset('js/sweetalert.min.js') }}"></script>
	<!--	<script src="{{ asset('public/js/jquery.min.js') }}"></script>-->
		<script src="{{ asset('js/ui-sweetalert.min.js') }}"></script>
		<!-- Select2 -->
		<script  src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<!--<script type="text/javascript" src="{{ asset('public/js/select2.min.js') }}"></script>-->
			<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
			
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
  
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.js"></script>
		
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
		
		


<script type="text/javascript">
			//validate form
			$("#form_sample_2").validate({
                errorElement: "em",
                errorPlacement: function ( error, element ) {
                    // Add the `help-block` class to the error element
                    error.addClass( "help-block" );

                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.insertAfter( element.parent( "label" ) );
                    } else {
                        error.insertAfter( element );
                    }
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".input-form" ).addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).parents( ".input-form" ).addClass( "has-success" ).removeClass( "has-error" );
                }
			});
		$(".select2").select2({
			placeholder:"search here",
			allowClear:true,
	});
		document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'complete') {
      setTimeout(function(){
          document.getElementById('interactive');
         document.getElementById('load').style.visibility="hidden";
      },1000);
  }
}
		</script>
        <!-- END: JS Assets-->
    </body>
</html>