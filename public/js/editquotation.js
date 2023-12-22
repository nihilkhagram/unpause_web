$(document).ready(function(){
//console.log(2);

console.log(1);
var id = $('#quotation_id').val();
$.get('/lifterpapp/getQuotationData/',{id:id} , function(data) {
	
var dt = JSON.parse(data);
		
		console.log(dt);
var name = '<p> Name - Test</p><br>';
			$('#customer').val(dt.qd.customer_id);
			$('#customer_mobile').val(dt.qd.customer_mobile);
			$('#customer_email').val(dt.qd.customer_email);
			$('#lift').val(dt.qd.lift_type);
			$('#no_of_lift').val(dt.qd.no_of_lifts);
			$('#no_of_floor').val(dt.qd.no_of_floor);
			$('#floor').val(dt.qd.floor);
			$('#labour_expense').val(dt.qd.labour_charge_name);
			$('#labour_amount').val(dt.qd.labour_charge_amount);
			$('#service_name').val(dt.qd.service_charge_name);
			$('#service_amount').val(dt.qd.service_charge_amount);
			$('#noc_amount').val(dt.qd.noc_charge_amount);
			$('#noc_expense').val(dt.qd.noc_charge_name);
			$('#transport_amount').val(dt.qd.transport);
			$('#profit_amount').val(dt.qd.profit);
			$('#total_amount').val(dt.qd.total_amount);
			var item  = dt.qi;
			var html = '';
			item.forEach(function(elements)
			{
			if(elements.item_name == 'Machine')
			{
			$('#machine').val(elements.item_id);
			$('#machine_qty').val(elements.item_quantity);
			$('#machine_size').val(elements.item_size);
			$('#machine_type').val(elements.item_type);
			$('#machine_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "machine_p" ><p> Machine </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'GuideRail')
			{
			$('#guiderail').val(elements.item_id);
			$('#guiderail_qty').val(elements.item_quantity);
			$('#guiderail_size').val(elements.item_size);
			$('#guiderail_type').val(elements.item_type);
			$('#guiderail_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "guiderail_p" ><p> GuideRail </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Bracket')
			{
			$('#bracket').val(elements.item_id);
			$('#bracket_qty').val(elements.item_quantity);
			$('#bracket_size').val(elements.item_size);
			$('#bracket_type').val(elements.item_type);
			$('#bracket_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "machine_p" ><p> Bracket </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Cabin')
			{
			$('#cabin').val(elements.item_id);
			$('#cabin_qty').val(elements.item_quantity);
			$('#cabin_size').val(elements.item_size);
			$('#cabin_type').val(elements.item_type);
			$('#cabin_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "cabin_p" ><p> Cabin </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Doorset')
			{
			$('#doorset').val(elements.item_id);
			$('#doorset_qty').val(elements.item_quantity);
			$('#doorset_size').val(elements.item_size);
			$('#doorset_type').val(elements.item_type);
			$('#doorset_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "doorset_p" ><p> Doorset </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Rope')
			{
			$('#rope').val(elements.item_id);
			$('#rope_meter').val(elements.item_quantity);
			$('#rope_size').val(elements.item_size);
			$('#rope_type').val(elements.item_type);
			$('#rope_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "rope_p" ><p> Rope </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'CarFrame')
			{
			$('#carframe').val(elements.item_id);
			$('#carframe_qty').val(elements.item_quantity);
			$('#carframe_size').val(elements.item_size);
			$('#carframe_type').val(elements.item_type);
			$('#carframe_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "carframe_p" ><p> CarFrame </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Switch')
			{
			$('#switch_limit').val(elements.item_id);
			$('#switch_limit_qty').val(elements.item_quantity);
			$('#switch_limit_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "switch_p" ><p> Switch </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'DoorSensor')
			{
			$('#door_sensor').val(elements.item_id);
			$('#door_sensor_qty').val(elements.item_quantity);
			$('#door_sensor_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "doorsensor_p" ><p> DoorSensor </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'ReadSwitch')
			{
			$('#read_switch').val(elements.item_id);
			$('#read_switch_qty').val(elements.item_quantity);
			$('#read_switch_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "readswitch_p" ><p> ReadSwitch </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'InspectionBox')
			{
			$('#inspection_box').val(elements.item_id);
			$('#inspection_box_qty').val(elements.item_quantity);
			$('#inspection_box_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "inspectionbox_p" ><p> InspectionBox </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			
			if(elements.item_name == 'Magnet')
			{
			$('#magnet').val(elements.item_id);
			$('#magnet_qty').val(elements.item_quantity);
			$('#magnet_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "magnet_p" ><p> Magnet </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Junctionbox')
			{
			$('#junctionbox').val(elements.item_id);
			$('#junctionbox_qty').val(elements.item_quantity);
			$('#junctionbox_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "junctionbox_p" ><p> Junctionbox </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Safetyswitch')
			{
			$('#safetyswitch').val(elements.item_id);
			$('#safetyswitch_qty').val(elements.item_quantity);
			$('#safetyswitch_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "safetyswitch_p" ><p> Safetyswitch </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'cableHanger')
			{
			$('#cablehanger').val(elements.item_id);
			$('#cablehanger_qty').val(elements.item_quantity);
			$('#cablehanger_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "cablehanger_p" ><p> cablehanger </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'EmergencyBall')
			{
			$('#emergencyball').val(elements.item_id);
			$('#emergencyball_qty').val(elements.item_quantity);
			$('#emergencyball_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "emergencyball_p" ><p> EmergencyBall </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Pitswitch')
			{
			$('#pitswitch').val(elements.item_id);
			$('#pitswitch_qty').val(elements.item_quantity);
			$('#pitswitch_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "pitswitch_p" ><p> Pitswitch </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Firemanswitch')
			{
			$('#firemanswitch').val(elements.item_id);
			$('#firemanswitch_qty').val(elements.item_quantity);
			$('#firemanswitch_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "firemanswitch_p" ><p> Firemanswitch </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Floorspeaker')
			{
			$('#floorspeaker').val(elements.item_id);
			$('#floorspeaker_qty').val(elements.item_quantity);
			$('#floorspeaker_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "floorspeaker_p" ><p> Floorspeaker </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Fan')
			{
			$('#fan').val(elements.item_id);
			$('#fan_qty').val(elements.item_quantity);
			$('#fan_type').val(elements.item_type);
			$('#fan_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "fan_p" ><p> Fan </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Blower')
			{
			$('#blower').val(elements.item_id);
			$('#blower_qty').val(elements.item_quantity);
			$('#blower_type').val(elements.item_type);
			$('#blower_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "blower_p" ><p> Blower </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'controlPanel')
			{
			$('#controlpanel').val(elements.item_id);
			$('#controlpanel_qty').val(elements.item_quantity);
			$('#controlpanel_type').val(elements.item_type);
			$('#controlpanel_price').val(elements.item_price);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "controlPanel_p" ><p> ControlPanel </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'ARDSystem')
			{
			$('#ard_system').val(elements.item_id);
			$('#ard_system_qty').val(elements.item_quantity);
			$('#ard_system_type').val(elements.item_type);
			$('#ard_system_price').val(elements.item_price);
			$('#ard_system_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "ardsystem_p" ><p> ARDSystem </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Light')
			{
			$('#light').val(elements.item_id);
			$('#light_qty').val(elements.item_quantity);
			$('#light_type').val(elements.item_type);
			$('#light_price').val(elements.item_price);
			$('#light_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "light_p" ><p> Light </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Bufferspring')
			{
			$('#bufferspring').val(elements.item_id);
			$('#bufferspring_qty').val(elements.item_quantity);
			$('#bufferspring_type').val(elements.item_type);
			$('#bufferspring_price').val(elements.item_price);
			$('#bufferspring_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "bufferspring_p" ><p> Bufferspring </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Guideshoe')
			{
			$('#guideshoe').val(elements.item_id);
			$('#guideshoe_qty').val(elements.item_quantity);
			$('#guideshoe_type').val(elements.item_type);
			$('#guideshoe_price').val(elements.item_price);
			$('#guideshoe_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "guideshoe_p" ><p> Guideshoe </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Doorlock')
			{
			$('#doorlock').val(elements.item_id);
			$('#doorlock_qty').val(elements.item_quantity);
			$('#doorlock_type').val(elements.item_type);
			$('#doorlock_price').val(elements.item_price);
			$('#doorlock_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "doorlock_p" ><p> DoorLock </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Arkem')
			{
			$('#arkem').val(elements.item_id);
			$('#arkem_qty').val(elements.item_quantity);
			$('#arkem_type').val(elements.item_type);
			$('#arkem_price').val(elements.item_price);
			$('#arkem_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "arkem_p" ><p> Arkem </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'counternet')
			{
			$('#counternet').val(elements.item_id);
			$('#counternet_qty').val(elements.item_quantity);
			$('#counternet_type').val(elements.item_type);
			$('#counternet_price').val(elements.item_price);
			$('#counternet_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "counternet_p" ><p> counternet </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Intercom')
			{
			$('#intercom').val(elements.item_id);
			$('#intercom_qty').val(elements.item_quantity);
			$('#intercom_type').val(elements.item_type);
			$('#intercom_price').val(elements.item_price);
			$('#intercom_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "intercom_p" ><p> Intercom </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'wirematerial')
			{
			$('#wirematerial').val(elements.item_id);
			$('#wirematerial_qty').val(elements.item_quantity);
			$('#wirematerial_type').val(elements.item_type);
			$('#wirematerial_price').val(elements.item_price);
			$('#wirematerial_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "wirematerial_p" ><p> wirematerial </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			if(elements.item_name == 'Hardware')
			{
			$('#hardware').val(elements.item_id);
			$('#hardware_qty').val(elements.item_quantity);
			$('#hardware_type').val(elements.item_type);
			$('#hardware_price').val(elements.item_price);
			$('#hardware_size').val(elements.item_size);
			if(elements.item_id != null && elements.item_id != 0)
			{
			html += '<div id = "hardware_p" ><p> Hardware </p> ' + elements.item_quantity+' * ' + elements.item_price + ' =  <div class="total" style="float:right">' + elements.total_price +'</div></div><br/>'
			}
			}
			});
			html += '<div id="labourexpense_p"><p> Labour Charge </p> '+ dt.qd.labour_charge_name +'= <div class="total" style="float:right">'+ dt.qd.labour_charge_amount + ' </div></div><br>';
			
			html += '<div id="serviceamount_p"><p> Service Charge </p> ' + dt.qd.service_charge_name + '=<div class="total" style="float:right"> '+ dt.qd.service_charge_amount + ' </div></div><br>';
			
			 html += '<div id="nocamount_p"><p> NOC Charge </p> '+ dt.qd.noc_charge_name + '=<div class="total" style="float:right"> '+ dt.qd.noc_charge_amount + ' </div></div><br>';
		
			html += '<div id="transport_p">Transport  <div class="total" style="float:right">'+ dt.qd.transport + ' </div></div>';
		
			html += '<hr></hr><div id="total_amount_P" >Total Amount Is <div style="float:right">' + dt.qd.total_amount + '</div></div>';
			
			$("#calculation").append(html);	
});	

});