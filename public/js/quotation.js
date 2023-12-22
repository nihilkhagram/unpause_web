$(document).ready(function(){
//console.log(2);
var sum = 0;	

$("#customer").change(function(){

$("#calculation").empty();			
var customer_id  = $("#customer").val();

	$.get('/lifterpapp/getInquiryData/',{customer_id:customer_id} , function(data) {
			//console.log(data);
			var dt = JSON.parse(data);
			console.log(dt);
			$("#no_of_lift").val(dt.number_of_lifts);
			$("#inquiry_id").val(dt.inquiry_id);
			$("#floor").val(dt.floor);
			$("#lift").val(dt.lift_type);
			
			$("#no_of_floor").val(dt.no_of_floor);
			$("#customer_mobile").val(dt.customer_mobile);
			$("#customer_email").val(dt.customer_email);
			$("#machine").val(dt.machine);
			$("#machine_qty").val(1);
			$("#machine_type").val(dt.machine_type);
			$("#machine_size").val(dt.machine_size);
			$("#machine_price").val(dt.machine_price);
			$("#lifttype").val(dt.lifttype);
			
			
			
			var name = '<p class="ptag"> Name - ' + dt.customer_name + '</p><br>';
			
			var machine = '<div id = "machine_p" ><p  class="ptag"> Machine <span class="total" style="float:right">' + dt.machine_price +'</span></p>  </div><br/>';
			
			var html = name + machine ;
			
			$("#calculation").append(html);	
			total_price();
			
			

			
			
			//lift 
			
			$("#lift").ready(function(){
				
			var lift_id  = $("#lift").val();	
			
			$.get('/lifterpapp/getCarframe/',{lift_id:lift_id} , function(data) {
			$('#carframe').empty();
			var select_a = '<option>Select</option>';
			$('#carframe').append(select_a);
			
			$(data).each(function(i,v)
				{ 
				
				html ="<option value='" + v.id + "'>" + v.car_frame_type +  "</option>";
				$("#carframe").append(html);
				});																	   
			});
			$.get('/lifterpapp/getCabin/',{lift_id:lift_id} , function(data) {
			$('#cabin').empty();
			var select_a = '<option>Select</option>';
			$('#cabin').append(select_a);
			
			$(data).each(function(i,v)
			{ 
				html ="<option value='" + v.id + "'>" + v.car_frame_type +  "</option>";
				$("#cabin").append(html);
			});																	   
			});
				
			});
			
			
			
			$("#floor" ).ready(function() 
			{
			var floor_id = $('#floor').val();
			
		   	$.get('/lifterpapp/getGuideRail/',{floor_id:floor_id} , function(data) {
			$('#guiderail').empty();
			var select_a = '<option>Select</option>';
			$('#guiderail').append(select_a);
			$(data).each(function(i,v)
				{ 
				
				html ="<option value='" + v.id + "'>" + v.guiderail_title +  "</option>";
				$("#guiderail").append(html);
				});																	   
			});
			$.get('/lifterpapp/getBracket/',{floor_id:floor_id} , function(data) {
			$('#bracket').empty();
			var select_a = '<option>Select</option>';
			$('#bracket').append(select_a);
			
			$(data).each(function(i,v)
				{ 
				
				html ="<option value='" + v.id + "'>" + v.bracket_title +  "</option>";
				$("#bracket").append(html);
				});																	   
			});
			$.get('/lifterpapp/getDoorset/',{floor_id:floor_id} , function(data) {
				
			$('#doorset').empty();
			var select_a = '<option>Select</option>';
			$('#doorset').append(select_a);
			
			$(data).each(function(i,v)
				{ 
				
				html ="<option value='" + v.id + "'>" + v.doorset_title +  "</option>";
				$("#doorset").append(html);
				});																	   
			});
			$.get('/lifterpapp/getRope/',{floor_id:floor_id} , function(data) {
			$('#rope').empty();
			var select_a = '<option>Select</option>';
			$('#rope').append(select_a);
			
			$(data).each(function(i,v)
				{ 
				
				html ="<option value='" + v.id + "'>" + v.type +  "</option>";
				$("#rope").append(html);
				});																	   
			});
			
			});	
			
			});	
				
		});	

	
 $("#machine_qty").change(function () {
	 
		$('#machine_p').remove();
        var qty = this.value;
		var price = $('#machine_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		//console.log(mtotal);
		var html = '<p class="ptag"> Machine <span class="total" style="float:right">' + mtotal +'</span></p> ';
			
		$('#machine_p').html(html);
		
	
		
		});
		
 $("#guiderail").change(function () {
		$("#guiderail_p").remove();
		var gid = $("#guiderail").val();
		var fid = $("#floor").val();
		$.get('/lifterpapp/getGuideRail_data/',{gid:gid,fid:fid} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		$('#guiderail_qty').val(dt.guiderail_qty);
		$('#guiderail_type').val(dt.guiderail_type);
		$('#guiderail_size').val(dt.guiderail_size);
		$('#guiderail_price').val(dt.guiderail_price);
		var mtotal = parseInt(dt.guiderail_qty) * parseInt(dt.guiderail_price);
		console.log(mtotal);
		var guide_rail = '<div id = "guiderail_p"><p class="ptag" > Guide Rail <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(guide_rail);
		total_price();
			
		});
	});
$("#cabin").change(function () {
		$("#cabin_p").remove();
		var id = $("#cabin").val();
		$.get('/lifterpapp/getCabin_data/',{id:id} , function(data)
		{
		$('#cabin_type').empty();
			var select_a = '<option>Select</option>';
			$('#cabin_type').append(select_a);
			
			$(data).each(function(i,v)
			{ 	
				html ="<option value='" + v.id + "'>" + v.cabin_subtype_title +  "</option>";
				$("#cabin_type").append(html);
																			   
			});
			
		});
	});
$("#cabin_type").change(function () {
		$("#cabin_p").remove();
		var id = $("#cabin").val();
		$.get('/lifterpapp/getCabinType_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		$('#cabin_qty').val(dt.qty);
		$('#cabin_size').val(dt.size);
		$('#cabin_price').val(dt.price);
		var mtotal = parseInt(dt.qty) * parseInt(dt.price);
		console.log(mtotal);
		var guide_rail = '<div id = "cabin_p"><p class="ptag" > Cabin <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(guide_rail);
		total_price();
			
		});
	});
$("#bracket").change(function () {
		$("#bracket_p").remove();
		var gid = $("#bracket").val();
		var fid = $("#floor").val();
		$.get('/lifterpapp/getBracket_data/',{gid:gid,fid:fid} , function(data)
		{
			$('#bracket_type').empty();
			var select_a = '<option>Select</option>';
			$('#bracket_type').append(select_a);
			
			$(data).each(function(i,v)
			{ 	
				html ="<option value='" + v.id + "'>" + v.type +  "</option>";
				$("#bracket_type").append(html);
																			   
			});
		});
});

$("#bracket_type").change(function () {
		$("#bracket_p").remove();
		var gid = $("#bracket_type").val();
		var fid = $("#floor").val();
		$.get('/lifterpapp/getBracketType_data/',{gid:gid,fid:fid} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		$('#bracket_qty').val(dt.bracket_qty);
		$('#bracket_size').val(dt.bracket_size);
		$('#bracket_price').val(dt.bracket_price);
		var mtotal = parseInt(dt.bracket_qty) * parseInt(dt.bracket_price);
		var bracket = '<div id = "bracket_p"><p class="ptag" > Bracket <span class="total" style="float:right">' + mtotal +'</span></p></div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#doorset").change(function () {
		$("#doorset_p").remove();
		var did = $("#doorset").val();
		var fid = $("#floor").val();
		$.get('/lifterpapp/getDoorset_data/',{did:did,fid:fid} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		$('#doorset_qty').val(dt.doorset_qty);
		$('#doorset_type').val(dt.doorset_type);
		$('#doorset_size').val(dt.doorset_size);
		$('#doorset_price').val(dt.doorset_price);
		var mtotal = parseInt(dt.doorset_qty) * parseInt(dt.doorset_price);
		var bracket = '<div id = "doorset_p"><p class="ptag" > Doorset <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#rope").change(function () {
		$("#rope_p").remove();
		var rid = $("#rope").val();
		var fid = $("#floor").val();
		$.get('/lifterpapp/getRope_data/',{rid:rid,fid:fid} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		$('#rope_meter').val(dt.rope_meter);
		$('#rope_size').val(dt.rope_size);
		$('#rope_price').val(dt.rope_price);
		var mtotal = parseInt(dt.rope_meter) * parseInt(dt.rope_price);
		var bracket = '<div id = "rope_p"><p class="ptag" > Rope <span class="total" style="float:right">' + mtotal +'</span></p>  </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});

$("#doorset_qty").change(function () {
	 
		$('#doorset_p').remove();
        var qty = this.value;
		var price = $('#doorset_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Doorset <span class="total" style="float:right">' + mtotal+'</span></p> ';
			
		$('#doorset_p').html(html);
	});
$("#carframe").change(function () {
		$("#carframe_p").remove();
		var cabin = $("#cabin_qty").val();
		var carframe_id = $("#carframe").val();
		$.get('/lifterpapp/carframe_data/',{carframe_id:carframe_id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		$('#carframe_qty').val(cabin);
		$('#carframe_size').val(dt.size);
		$('#carframe_type').val(dt.type);
		$('#carframe_price').val(dt.price);
		var mtotal = 5 * parseInt(dt.price);
		var bracket = '<div id = "carframe_p"><p class="ptag" > Carframe <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#switch_limit").change(function () {
		$("#switch_limit_p").remove();
		
		var id = $("#switch_limit").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var switch_limit_qty  = 6 * lift;
		$('#switch_limit_qty').val(switch_limit_qty);
		$('#switch_limit_price').val(dt.price);
		var mtotal = switch_limit_qty * parseInt(dt.price);
		var bracket = '<div id = "switch_limit_p"><p class="ptag" > Switch Limit  <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});

$("#weight_price").change(function (){
	$("#weight_sensor_p").remove();
	var qty = $('#weight_qty').val();
	var price = $('#weight_price').val();
	var mtotal = parseInt(qty) * parseInt(price);
	var bracket = '<div id = "weight_sensor_p"><p class="ptag" >Weight <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
	$('#calculation').append(bracket);

	total_price();
});
$("#door_sensor").change(function () {
	console.log(1);
		$("#door_sensor_p").remove();
		
		var id = $("#door_sensor").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var switch_limit_qty  = 1 * lift;
		$('#door_sensor_qty').val(switch_limit_qty);
		$('#door_sensor_price').val(dt.price);
		var mtotal = switch_limit_qty * parseInt(dt.price);
		var bracket = '<div id = "door_sensor_p"><p class="ptag" > Door Sensor <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#read_switch").change(function () {
		$("#read_switch_p").remove();
		
		var id = $("#read_switch").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		
		$('#read_switch_qty').val(1);
		$('#read_switch_price').val(dt.price);
		var mtotal = 1 * parseInt(dt.price);
		var bracket = '<div id = "read_switch_p"><p class="ptag" > Read Switch <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#read_switch_qty").change(function () {
	 
		$('#read_switch_p').remove();
        var qty = this.value;
		var price = $('#read_switch_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Read Switch <span class="total" style="float:right">' + mtotal +'</span></p>  ';
			
		$('#read_switch_p').html(html);
	});
$("#magnet").change(function () {
		$("#magnet_p").remove();
		
		
		var id = $("#magnet").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		
		var dt = JSON.parse(data);
		var qty = $('#read_switch_qty').val();
		var floor = $('#no_of_floor').val();
		
		if(qty == 1)
		{
			var magnet_qty = 1 * floor;
		}
			if(qty == 3)
		{
			var magnet_qty = 3 * floor;
		}
		$('#magnet_qty').val(magnet_qty);
		$('#magnet_price').val(dt.price);
		var mtotal = magnet_qty * parseInt(dt.price);
		var bracket = '<div id = "magnet_p" ><p class="ptag" > Magnet <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#inspection_box").change(function () {
		$("#inspection_box_p").remove();
		
		var id = $("#inspection_box").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#inspection_box_qty').val(qty);
		$('#inspection_box_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "inspection_box_p"><p class="ptag" > Inspection Box <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#junctionbox").change(function () {
		$("#junctionbox_p").remove();
		
		var id = $("#junctionbox").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#junctionbox_qty').val(qty);
		$('#junctionbox_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "junctionbox_P"><p class="ptag" > Junction Box <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#safetyswitch").change(function () {
		$("#safetyswitch_p").remove();
		
		var id = $("#safetyswitch").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#safetyswitch_qty').val(qty);
		$('#safetyswitch_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "safetyswitch_p"><p class="ptag" > Safety Switch <span class="total" style="float:right">' + mtotal +'</span></p>  </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#cablehanger").change(function () {
		$("#cablehanger_p").remove();
		
		var id = $("#cablehanger").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#cablehanger_qty').val(qty);
		$('#cablehanger_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "cablehanger_p"><p class="ptag" > Cable Hanger <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});

$("#emergencyball").change(function () {
		$("#emergencyball_p").remove();
		
		var id = $("#emergencyball").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#emergencyball_qty').val(qty);
		$('#emergencyball_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "emergencyball_p"><p class="ptag" > Emergency Ball  <span class="total" style="float:right">' + mtotal +'</span></p></div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#pitswitch").change(function () {
		$("#pitswitch_p").remove();
		
		var id = $("#pitswitch").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#pitswitch_qty').val(qty);
		$('#pitswitch_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "pitswitch_p"><p class="ptag" > Pit switch <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#firemanswitch").change(function () {
		$("#firemanswitch_p").remove();
		
		var id = $("#firemanswitch").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#firemanswitch_qty').val(qty);
		$('#firemanswitch_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "firemanswitch_p"><p class="ptag" > FireMan switch <span class="total" style="float:right">' + mtotal +'</span></p></div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#floorspeaker").change(function () {
		$("#floorspeaker_p").remove();
		
		var id = $("#floorspeaker").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		console.log(data);
		var dt = JSON.parse(data);
		var lift = $('#no_of_lift').val();
		//console.log(lift);
		var qty  = 1 * lift;
		$('#floorspeaker_qty').val(qty);
		$('#floorspeaker_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "floorspeaker_p"><p class="ptag" > Floor Speaker <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
$("#fan").change(function () {
		$("#fan_p").remove();
		
		var id = $("#fan").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#fan_qty').val(qty);
		$('#fan_type').val(dt.type);
		$('#fan_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "fan_p"><p class="ptag" > Fan <span class="total" style="float:right">' + mtotal +'</span></p>  </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#fan_qty").change(function () {
	 
		$('#fan_p').remove();
        var qty = this.value;
		var price = $('#fan_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Fan <span class="total" style="float:right">' + mtotal +'</span></p> ';
			
		$('#fan_p').html(html);
	});
$("#blower").change(function () {
		$("#blower_p").remove();
		
		var id = $("#blower").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#blower_qty').val(qty);
		$('#blower_type').val(dt.type);
		$('#blower_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "blower_p"><p class="ptag" > Blower <span class="total" style="float:right">' + mtotal +'</span></p>  </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#blower_qty").change(function () {
	 
		$('#blower_p').remove();
        var qty = this.value;
		var price = $('#blower_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Blower <div class="total" style="float:right">' + mtotal +'</div> </p> ';
			
		$('#blower_p').html(html);
	});
$("#controlpanel").change(function () {
		$("#controlpanel_p").remove();
		
		var id = $("#controlpanel").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#controlpanel_qty').val(qty);
		$('#controlpanel_type').val(dt.type);
		$('#controlpanel_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "controlpanel_p"><p class="ptag" > Control Panel <span class="total" style="float:right">' + mtotal +'</span></p>  </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#controlpanel_qty").change(function () {
	 
		$('#controlpanel_p').remove();
        var qty = this.value;
		var price = $('#controlpanel_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Control panel <span class="total" style="float:right"> ' + mtotal +'</span></p> ';
			
		$('#controlpanel_p').html(html);
	});
$("#ard_system").change(function () {
		$("#ard_system_p").remove();
		
		var id = $("#ard_system").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#ard_system_qty').val(qty);
		$('#ard_system_type').val(dt.type);
		$('#ard_system_size').val(dt.size);
		$('#ard_system_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "ard_system_p"><p class="ptag" > ARD System <span class="total" style="float:right"> ' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#ard_system_qty").change(function () {
	 
		$('#ard_system_p').remove();
        var qty = this.value;
		var price = $('#ard_system_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > ARD System <span class="total" style="float:right"> ' + mtotal +'</span></p> ';
			
		$('#ard_system_p').html(html);
	});
$("#light").change(function () {
		$("#light_p").remove();
		
		var id = $("#light").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#light_qty').val(qty);
		$('#light_type').val(dt.type);
		$('#light_size').val(dt.size);
		$('#light_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "light_p"><p class="ptag" > Light <span class="total" style="float:right">' + mtotal +'</span></p>  </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#light_qty").change(function () {
	 
		$('#light_p').remove();
        var qty = this.value;
		var price = $('#light_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Light <span class="total" style="float:right">' + mtotal +'</span></p> ';
			
		$('#light_p').html(html);
	});
$("#bufferspring").change(function () {
		$("#bufferspring_p").remove();
		
		var id = $("#bufferspring").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#bufferspring_qty').val(qty);
		$('#bufferspring_type').val(dt.type);
		$('#bufferspring_size').val(dt.size);
		$('#bufferspring_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "bufferspring_p"><p class="ptag" > Buffer Spring <span class="total" style="float:right"> ' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#bufferspring_qty").change(function () {
	 
		$('#bufferspring_p').remove();
        var qty = this.value;
		var price = $('#bufferspring_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Buffer Spring <span class="total" style="float:right">' + mtotal +'</span></p>  ';
			
		$('#bufferspring_p').html(html);
	});
	
$("#guideshoe").change(function () {
		$("#guideshoe_p").remove();
		
		var id = $("#guideshoe").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#guideshoe_qty').val(qty);
		$('#guideshoe_type').val(dt.type);
		$('#guideshoe_size').val(dt.size);
		$('#guideshoe_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "guideshoe_p"><p class="ptag" > Guide Shoe <span class="total" style="float:right"> ' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#guideshoe_qty").change(function () {
	 
		$('#guideshoe_p').remove();
        var qty = this.value;
		var price = $('#guideshoe_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Guide Shoe <span class="total" style="float:right"> ' + mtotal +'</span></p> ';
			
		$('#guideshoe_p').html(html);
	});   
	
$("#doorlock").change(function () {
		$("#doorlock_p").remove();
		
		var id = $("#doorlock").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#doorlock_qty').val(qty);
		$('#doorlock_type').val(dt.type);
		$('#doorlock_size').val(dt.size);
		$('#doorlock_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "doorlock_p"><p class="ptag" > Door Lock <span class="total" style="float:right">' + mtotal +'</span> </p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#doorlock_qty").change(function () {
	 
		$('#doorlock_p').remove();
        var qty = this.value;
		var price = $('#doorlock_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Door Lock <br>  <span class="total" style="float:right">' + mtotal +'</span></p>';
			
		$('#doorlock_p').html(html);
	});   
$("#arkem").change(function () {
		$("#arkem_p").remove();
		
		var id = $("#arkem").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#arkem_qty').val(qty);
		$('#arkem_type').val(dt.type);
		$('#arkem_size').val(dt.size);
		$('#arkem_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "arkem_p"><p class="ptag" > Arkem <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#arkem_qty").change(function () {
	 
		$('#arkem_p').remove();
        var qty = this.value;
		var price = $('#arkem_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Arkem <span class="total" style="float:right">' + mtotal +'</span></p>  ';
			
		$('#arkem_p').html(html);
	});   
$("#counternet").change(function () {
		$("#counternet_p").remove();
		
		var id = $("#counternet").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#counternet_qty').val(qty);
		$('#counternet_type').val(dt.type);
		$('#counternet_size').val(dt.size);
		$('#counternet_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "counternet_p"><p class="ptag" > Counter Net <span class="total" style="float:right"> ' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#counternet_qty").change(function () {
	 
		$('#counternet_p').remove();
        var qty = this.value;
		var price = $('#counternet_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Counter Net  <span class="total" style="float:right">' + mtotal +'</span></p> ';
			
		$('#counternet_p').html(html);
	});   
$("#intercom").change(function () {
		$("#intercom_p").remove();
		
		var id = $("#intercom").val();
		$.get('/lifterpapp/accessories_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#intercom_qty').val(qty);
		$('#intercom_type').val(dt.type);
		$('#intercom_size').val(dt.size);
		$('#intercom_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "intercom_p"><p class="ptag" > Intercom <span class="total" style="float:right"> ' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#intercom_qty").change(function () {
	 
		$('#intercom_p').remove();
        var qty = this.value;
		var price = $('#intercom_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Intercom <span class="total" style="float:right">' + mtotal +'</span></p>  ';
			
		$('#intercom_p').html(html);
	});   
$("#wirematerial").change(function () {
		$("#wirematerial_p").remove();
		
		var id = $("#wirematerial").val();
		$.get('/lifterpapp/wirematerial_data/',{id:id} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#wirematerial_qty').val(qty);
		$('#wirematerial_type').val(dt.type);
		$('#wirematerial_size').val(dt.size);
		$('#wirematerial_price').val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "wirematerial_p"><p class="ptag" > Wire Material <span class="total" style="float:right"> ' + mtotal +'</span></p> </div><br/>';
		$('#calculation').append(bracket);
		total_price();
		});
	});
 $("#wirematerial_qty").change(function () {
	 
		$('#wirematerial_p').remove();
        var qty = this.value;
		var price = $('#wirematerial_price').val();
		var mtotal = parseInt(qty) * parseInt(price);
		console.log(mtotal);
		var html = '<p class="ptag" > Wire Material <span class="total" style="float:right"> ' + mtotal +'</span></p> ';
			
		$('#wirematerial_p').html(html);
	});  
	
	
// $("#hardware").change(function () {
// 	console.log(1);
// 		$("#hardware_p").remove();
		
// 		var id = $("#hardware").val();
// 		$.get('/lifterpapp/hardware_data/',{id:id} , function(data)
// 		{
// 		//console.log(data);
// 		var dt = JSON.parse(data);
// 		var qty  = 1 ;
// 		$('#hardware_qty').val(qty);
// 		$('#hardware_type').val(dt.type);
// 		$('#hardware_size').val(dt.size);
// 		$('#hardware_price').val(dt.price);
// 		var mtotal = qty * parseInt(dt.price);
// 		var bracket = '<div id = "hardware_p"><p class="ptag" > Hardware  <span class="total" style="float:right">' + mtotal +'</span></p> </div><br/>';
// 		$('#calculation').append(bracket);
// 		total_price();	
// 		});
// 	});

//  $("#hardware_qty").change(function () {
	 
// 		$('#hardware_p').remove();
//         var qty = this.value;
// 		var price = $('#hardware_price').val();
// 		var mtotal = parseInt(qty) * parseInt(price);
// 		console.log(mtotal);
// 		var html = '<p class="ptag" > Hardware <span class="total" style="float:right">' + mtotal +'</span></p>  ';
			
// 		$('#hardware_p').html(html);
// 	});   
$("#labour_amount").blur(function () {
	 
		$('#labourexpense_p').remove();
        var price = this.value;
		var expense = $('#labour_expense').val();
		var html = '<div id="labourexpense_p"><p class="ptag" > Labour Charge <span class="total" style="float:right">'+ price + ' </span></p></div><br>';
			
		$('#calculation').append(html);
		total_price();
	});   
$("#service_amount").blur(function () {
	 
		$('#serviceamount_p').remove();
        var price = this.value;
		var expense = $('#service_name').val();
		var html = '<div id="serviceamount_p"><p class="ptag" > Service Charge <span class="total" style="float:right"> '+ price + ' </span></p></div><br>';
			
		$('#calculation').append(html);

		total_price();
	});     			
$("#noc_amount").blur(function () {
	 
		$('#nocamount_p').remove();
		var expense = $('#noc_expense').val();
        var price = this.value;
		
		var html = '<div id="nocamount_p"><p class="ptag" > NOC Charge <span class="total" style="float:right"> '+ price + ' </span></p> </div><br>';
			
		$('#calculation').append(html);

		total_price();
	});     			
$("#transport_amount").blur(function () {
	 
		$('#transport_p').remove();
		var expense = $('#noc_expense').val();
        var price = this.value;
		
		var html = '<div id="transport_p"><p class="ptag">Transport  <span class="total" style="float:right">'+ price + ' </span></p></div>';
			
		$('#calculation').append(html);	
		total_price();
		

		
	});     	
// $("#profit_amount").blur(function () {
	 
// 		$('#profit_amount_p').remove();
// 		var price = this.value;
			
// 		$('#calculation').append(html);
		
// 		$(".total").each(function(){

// 		sum += parseInt($(this).html());
		
// 		});
// 		var html =  '<div id="sub_total_p"><p class="ptag">Total  <span class="total" style="float:right">'+ sum + ' </span></p></div><hr>';
// 		 html += '<div id="profit_amount_p"><p class="ptag">Profit = <span class="total" style="float:right">'+ price + ' </span></p></div><br>';
// 		$('#total_amount').val(sum);
// 		$('#amount').empty();
// 		var sum_t = '<hr></hr><div id="total_amount_P" ><p class="ptag">Total Amount Is <span style="float:right">' + sum + '</span></p></div>';	
// 			//console.log(sum_t);
// 			$('#amount').append(sum_t);
		
// 	});  

   	
	
		

});

function change_hd_qty(id)
{
	$('#hardware_p'+id).remove();
	var qty = $('#hardware_qty'+id).val();
	var price = $('#hardware_price'+id).val();
	var mtotal = parseInt(qty) * parseInt(price);
	console.log(mtotal);
	var html = '<div id = "hardware_p'+id+'"><p class="ptag" > Hardware  <span class="total" style="float:right">' + mtotal +'</span></p><br/> </div>';
		
	$('#calculation').append(html);
	total_price();	
}

function hardware_data(value,id)
{
	console.log(id);
	$("#hardware_p"+id).remove();
		
		var ids = $("#hardware"+id).val();
		console.log(ids);
		$.get('/lifterpapp/hardware_data/',{id:ids} , function(data)
		{
		//console.log(data);
		var dt = JSON.parse(data);
		var qty  = 1 ;
		$('#hardware_qty'+id).val(qty);
		$('#hardware_type'+id).val(dt.type);
		$('#hardware_size'+id).val(dt.size);
		$('#hardware_price'+id).val(dt.price);
		var mtotal = qty * parseInt(dt.price);
		var bracket = '<div id = "hardware_p'+id+'"><p class="ptag" > Hardware  <span class="total" style="float:right">' + mtotal +'</span></p> <br/></div>';
		$('#calculation').append(bracket);
		total_price();	
		});
}

function get_amount()
{
	// $('.total_sec').remove();
	var profit_amount = $("#profit_amount").val();
	
	if(profit_amount != '' && profit_amount != 0 && profit_amount != 'undefined')
	{	
		$("#profit_amount").attr("required", true);
		$("#percentage").attr("required", false);
		$('#percentage').val('');
		$('#percentage').attr('readonly', true);
		$('#percentage').addClass('input-disabled');

		var price = profit_amount;			
		
		var sum = 0;	
		$(".total").each(function(){
			sum += parseInt($(this).html());		
		});
		
	
		// sum_t += '<br><div id="profit_amount_p"><p class="ptag">Profit = <span class="total" style="float:right">'+ price + ' </span></p></div><br>';
		
	
		$('#psubtotal').val(sum);
		$('#subtotalp').text(sum);
		$('#subtotal').show();

		$('#pfamt').val(price);
		$('#totalp').text(price);
		$('#profit_area').show()

		$("#prf_amt").val(price);
		
		var total = parseFloat(price) + parseFloat(sum);
		$('#total_amount').val(sum);
		// $('#amount').empty();
		total_price();
		// var sum_t  = '<div class="total_sec"><div id="total_amount_P" ><p class="ptag">Total Amount = <span style="float:right">' + total + '</span></p></div></div>';
			
		// $('#amount').append(sum_t);
	}else{
		
		$('#percentage').attr('readonly', false);
		$('#percentage').removeClass('input-disabled');
		$("#profit_amount").attr("required", false);
		$("#percentage").attr("required", false);
	}
}

function get_percentage()
{
	// $(".total_sec").remove();
	var percentage = $("#percentage").val();
	if(percentage != '' && percentage != 0 && percentage != 'undefined')
	{
		$("#profit_amount").attr("required", false);
		$("#percentage").attr("required", true);
		$("#profit_amount").val('');
		$('#profit_amount').attr('readonly', true);
		$('#profit_amount').addClass('input-disabled');
		var sum = 0;
		var price = percentage;				
		$(".total").each(function(){
			sum += parseInt($(this).html());		
		});

		countprofit = ((parseFloat(sum) * parseFloat(price)) / 100);
		
		

		$('#psubtotal').val(sum);
		$('#subtotalp').text(sum);
		$('#subtotal').show();

		$('#pfamt').val(countprofit);
		$('#totalp').text(countprofit);
		$('#profit_area').show()

		var total = parseFloat(sum) + parseFloat(countprofit);
		$('#total_amount').val(total);
		$("#prf_amt").val(countprofit);
		// $('#amount').empty();
		total_price();

		// var sum_t =  '<div class="total_sec"><br><div id="sub_total_p"><p class="ptag">Total  <span class="total" style="float:right">'+ sum + ' </span></p></div><hr>';
		// sum_t += '<br><div id="profit_amount_p"><p class="ptag">Profit = <span class="total" style="float:right">'+ countprofit + ' </span></p></div><br>';
		// var sum_t = '<div class="total_sec"><div id="total_amount_P" ><p class="ptag">Total Amount = <span style="float:right">' + total + '</span></p></div></div>';
			
		// $('#amount').append(sum_t);
	}else{
		$('#profit_amount').attr('readonly', false);
		$('#profit_amount').removeClass('input-disabled');
		$("#profit_amount").attr("required", false);
		$("#percentage").attr("required", false);
	}
}
function get_cgst()
{
	// $(".total_sec").remove();
	var percentage = $("#cgst").val();
	if(percentage != '' && percentage != 0 && percentage != 'undefined')
	{
		$("#sgst").val(percentage);
		$("#igst").attr("required", false);
		$("#igst").val('');
		$('#sgst').attr('readonly', true);
		$('#igst').attr('readonly', true);
		$('#sgst').addClass('input-disabled');
		$('#igst').addClass('input-disabled');
		var sum = 0;
		var price = percentage;				
		$(".total").each(function(){
			sum += parseInt($(this).html());		
		});

		var pfamt = $('#pfamt').val();
		
		var ptotal = (parseFloat(sum) + parseFloat(pfamt));
		
		countprofit = ((parseFloat(ptotal) * parseFloat(price)) / 100);
		
		var totalgst = (parseFloat(countprofit) * 2);
	
		$("#cgstamt").val(countprofit);
		$("#cgstt").text(countprofit);
		$("#sgstt").text(countprofit);
		$("#cp").text('('+percentage+'%)');
		$("#sp").text('('+percentage+'%)');
		$("#sgstamt").val(countprofit);
		$("#gst_area").show();

		$("#igstamt").val(0);
		$('#igstt').text(0);
		$("#igst_area").hide();
		
		// var sum_t =  '<br><div id="sub_total_p"><p class="ptag">Total  <span class="total" style="float:right">'+ sum + ' </span></p></div><hr>';
		// sum_t += '<br><div id="profit_amount_p"><p class="ptag">CGST = <span class="total" style="float:right">'+ countprofit + ' </span></p></div><br>';
		var total = parseFloat(sum) + parseFloat(countprofit) + parseFloat(pfamt) +  parseFloat(countprofit);
		console.log(total);

		$('#total_amount').val(total);
		$("#gst_amt").val(totalgst);
		// $('#amount').empty();
		total_price();
		// var sum_t = '<div class="total_sec"><div id="total_amount_P" ><p class="ptag">Total Amount = <span style="float:right">' + total + '</span></p></div></div>';
			
		// $('#amount').append(sum_t);
	}else{
		$("#sgst").attr("required", false);
		$("#cgst").attr("required", false);
		$("#igst").attr("required", false);
		
		$("#sgst").val('');

		$('#sgst').attr('readonly', false);
		$('#igst').attr('readonly', false);
		$('#sgst').removeClass('input-disabled');
		$('#igst').removeClass('input-disabled');
	}
}
function get_sgst()
{
	// $(".total_sec").remove();
	var percentage = $("#sgst").val();
	if(percentage != '' && percentage != 0 && percentage != 'undefined')
	{
		$("#cgst").val('');
		$("#igst").val('');
	
		$('#cgst').attr('readonly', true);
		$('#igst').attr('readonly', true);
		$('#cgst').addClass('input-disabled');
		$('#igst').addClass('input-disabled');
		var sum = 0;
		var price = percentage;				
		$(".total").each(function(){
			sum += parseInt($(this).html());		
		});

		countprofit = ((parseFloat(sum) * parseFloat(price)) / 100);
		
		var sum_t =  '<div class="total_sec"><br><div id="sub_total_p"><p class="ptag">Total  <span class="total" style="float:right">'+ sum + ' </span></p></div><hr>';
		sum_t += '<br><div id="profit_amount_p"><p class="ptag">SGST = <span class="total" style="float:right">'+ countprofit + ' </span></p></div><br>';
		var total = parseFloat(sum) + parseFloat(countprofit);
		$('#total_amount').val(total);
		$("#gst_amt").val(countprofit);
		// $('#amount').empty();
		sum_t += '<hr></hr><div id="total_amount_P" ><p class="ptag">Total Amount = <span style="float:right">' + total + '</span></p></div></div>';
			
		$('#amount').append(sum_t);
	}else{
		
		$('#cgst').attr('readonly', false);
		$('#igst').attr('readonly', false);
		$('#cgst').removeClass('input-disabled');
		$('#igst').removeClass('input-disabled');
	}
}
function get_igst()
{
	// $(".total_sec").remove();
	var percentage = $("#igst").val();
	if(percentage != '' && percentage != 0 && percentage != 'undefined')
	{
		$("#sgst").val();
		$("#cgst").val();
		$("#igst").attr("required", false);
		$("#cgst").attr("required", false);
		$('#sgst').attr('readonly', true);
		$('#cgst').attr('readonly', true);
		$('#sgst').addClass('input-disabled');
		$('#cgst').addClass('input-disabled');
		var sum = 0;
		var price = percentage;				
		$(".total").each(function(){
			sum += parseInt($(this).html());		
		});

		var pfamt = $('#pfamt').val();		
		var ptotal = (parseFloat(sum) + parseFloat(pfamt));
		countprofit = ((parseFloat(ptotal) * parseFloat(price)) / 100);		
		$("#cgstamt").val(0);
		$("#cgstt").text(0);
		$("#sgstt").text(0);
		$("#sgstamt").val(0);
		$("#gst_area").hide();
		$("#cp").text('');
		$("#sp").text('');

		$("#igstamt").val(countprofit);
		$('#igstt').text(countprofit);
		$("#ip").text('('+percentage+'%)');
		$("#igst_area").show();

		// var sum_t =  '<div class="total_sec"><br><div id="sub_total_p"><p class="ptag">Total  <span class="total" style="float:right">'+ sum + ' </span></p></div><hr>';
		// sum_t += '<br><div id="profit_amount_p"><p class="ptag">IGST = <span class="total" style="float:right">'+ countprofit + ' </span></p></div><br>';

		var total = parseFloat(sum) + parseFloat(countprofit) + parseFloat(pfamt);
		
		$('#total_amount').val(total);
		$("#gst_amt").val(countprofit);
		// $('#amount').empty();
		total_price();
		// var sum_t  = '<div class="total_sec"><div id="total_amount_P" ><p class="ptag">Total Amount = <span style="float:right">' + total + '</span></p></div></div>';
			
		// $('#amount').append(sum_t);
	}else{
		$("#igst").attr("required", false);
		$("#cgst").attr("required", false);
		$('#sgst').attr('readonly', false);
		$('#cgst').attr('readonly', false);
		$('#sgst').removeClass('input-disabled');
		$('#cgst').removeClass('input-disabled');
	}
}


function total_price()
{
	$(".total_sec").remove();
	var sum = 0;		
	$(".total").each(function(){
		sum += parseInt($(this).html());		
	});
	// var sum_t =  '<br><div id="sub_total_p"><p class="ptag">Total  <span class="total" style="float:right">'+ sum + ' </span></p></div><hr>';	

	$('#psubtotal').val(sum);
	$('#subtotalp').text(sum);
	$('#subtotal').show();

	
	var pfamt = $('#pfamt').val();
	if(cgstamt != '' && cgstamt != 'undefined')
	{
		var pf = $('#percentage').val();
		var pfa = $('#profit_amount').val();
		if(pf != '' && pf != 'undefined' && pf != 0)
		{
			pfamt = ((parseFloat(sum) * parseFloat(pf)) / 100);
			
			$('#pfamt').val(pfamt.toFixed(2));
			$('#totalp').text(pfamt.toFixed(2));
			$('#profit_area').show()

		}else if(pfa  != '' && pfa != 'undefined'  && pf != 0)
		{
			pfamt = pfa;
			$('#pfamt').val(pfamt.toFixed(2));
			$('#totalp').text(pfamt.toFixed(2));
			$('#profit_area').show()
	
			$("#prf_amt").val(pfamt.toFixed(2));
			
		}else{
			pfamt = pfamt;
		}
	}else{
		pfamt = 0;
	}
	console.log(pfamt);
	var cgstamt = $('#cgstamt').val();
	var sgstamt = $('#sgstamt').val();
	if(cgstamt != '' && cgstamt != 'undefined')
	{
		var percentage = $("#cgst").val();
		if(percentage != '' && percentage != 0 && percentage != 'undefined')
		{
			var pfamt = $('#pfamt').val();
		
			var ptotal = (parseFloat(sum) + parseFloat(pfamt));
			
			countprofit = ((parseFloat(ptotal) * parseFloat(percentage)) / 100);
			
			var totalgst = (parseFloat(countprofit) * 2);
		
			$("#cgstamt").val(countprofit.toFixed(2));
			$("#cgstt").text(countprofit.toFixed(2));
			$("#sgstt").text(countprofit.toFixed(2));
			$("#sgstamt").val(countprofit.toFixed(2));
			$("#cp").text('('+percentage+'%)');
			$("#sp").text('('+percentage+'%)');
			$("#gst_area").show();

			$("#igstamt").val(0);
			$('#igstt').text(0);
			$("#igst_area").hide();
			cgstamt = $("#cgstamt").val();
			sgstamt =  $('#sgstamt').val();
			$("#gst_amt").val(totalgst.toFixed(2));
		}else{
			cgstamt = cgstamt;
			sgstamt = sgstamt;
			$("#gst_amt").val(cgstamt);
		}
	}else{
		cgstamt = 0;
		sgstamt = 0;
		$("#gst_amt").val(cgstamt);
	}
	
	var igstamt = $('#igstamt').val();
	if(igstamt != '' && igstamt != 'undefined')
	{
		var percentage = $("#igst").val();
		if(percentage != '' && percentage != 0 && percentage != 'undefined')
		{
		
			var pfamt = $('#pfamt').val();
			var ptotal = (parseFloat(sum) + parseFloat(pfamt));
			countprofit = ((parseFloat(ptotal) * parseFloat(percentage)) / 100);		
			$("#cgstamt").val(0);
			$("#cgstt").text(0);
			$("#sgstt").text(0);
			$("#sgstamt").val(0);
			$("#gst_area").hide();

			$("#igstamt").val(countprofit.toFixed(2));
			$('#igstt').text(countprofit.toFixed(2));
			$("#ip").text('('+percentage+'%)');
			$("#igst_area").show();
			igstamt = $('#igstamt').val();
			$("#gst_amt").val(igstamt);
		}else{
			igstamt = igstamt;
			$("#gst_amt").val(igstamt);
		}
	}else{
		igstamt = 0;
		$("#gst_amt").val(igstamt);
	}
	
	console.log(cgstamt);
	console.log(igstamt);
	console.log(sgstamt);

	var total = parseFloat(sum) + parseFloat(pfamt) + parseFloat(cgstamt) + parseFloat(sgstamt) + parseFloat(igstamt);
	
	$('#total_amount').val(total.toFixed(2));
	var sum_t = '<div class="total_sec"><div id="total_amount_P" ><p class="ptag">Total Amount = <span style="float:right">' + total.toFixed(2) + '</span></p></div></div>';
	$('#amount').append(sum_t);
}
