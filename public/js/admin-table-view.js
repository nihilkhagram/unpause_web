function multiactionpostdata(action){
	$.ajax({
			url: $("#table_action_url").text(),
			type: "post",
			dataType: "json",
			data: $("#multipleselecttable").serialize(),
			success: function(data) {				
				// return false;
				if(data.status){
					location.reload();
					
				}else{
					//console.log(data.errormsg);
					swal($("#table_ajax_error").text(), " ", "error");
				}
			}
		});
}
jQuery(document).ready(function() {
	
	var tableactionsel='';
	var columnname='';
	var is_disable = 0;
	// table view status change
	$(document).on("click",".tablestatuschange", function(e){
		console.log('status clicked');
		var context = $(this);
		var token = $(this).data('token');
		var id = $(this).data('id');
		var status = $(this).data('status');
		if(is_disable == 0){
			//alert(is_disable);
			is_disable = 1;
			//alert($("#table_status_url").text());
			$.ajax({
				url: $("#table_status_url").text(),
				type: "post",
				dataType: "json",
				data: {_method: 'post', _token :token, id :id,status:status,tablename:$("#tablename").val(),feildname:$("#feildname").val()},
				success: function(data) {
					is_disable = 0;
					if(data.status){
						if(data.html.indexOf('blockdata') !== -1){
							$(context).parent(".blockdata").parent('td').replaceWith(data.html);
						}else{
							$(context).parent(".blockdata").parent('td').html(data.html);
						}
						swal("Status updated successfully", " ", "success");
						return false;
					}else{
						//console.log(data.errormsg);
						swal($("#table_ajax_error").text(), " ", "error");
						return false;
					}
				}
			});
		}	
	});
	$(document).on("change",".tableactionsel", function(e){
		tableactionsel = $(this).val();
		columnname = $('option:selected', this).attr("data-feild");
		// alert('before'+columnname);
	});	
	// table multi action change
	$(document).on("click","#multiactionbtn", function(e){
		
		if($('.allcheksel:checked').size() > 0){
			// alert('after'+tableactionsel);
			if(tableactionsel != ''){
				var context = $(this);
				$("#tableactioninput").val(tableactionsel);
				$("#tablefeildname").val(columnname);
				//delete opration
				if(tableactionsel == 'delete' || columnname == "block_complain"){
						swal({
							title: $("#confirm_msg_error").text(),
							text: "",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: '#DD6B55',
							confirmButtonText: $("#confirm_yes_error").text(),
							cancelButtonText: $("#confirm_no_error").text(),
							closeOnConfirm: false,
							closeOnCancel: false
						 },
						 function(isConfirm){
						   if (isConfirm){
							multiactionpostdata(tableactionsel);
						} else {
						  swal($("#cancel_msg_error").text(), " ", "error");
						}
					});
				}else{ 
					//status change opration
					multiactionpostdata(tableactionsel);
				}
			}else{
				swal($("#table_selaction_error").text(), " ", "error");
			} 
			
		}else{
			swal($("#table_checkbox_del_error").text(), " ", "error");
		}
		
	});
	
	//select/unselect all checkbox
	$(document).on("click","#selectchkall", function(e){
		console.log('clicked');
		console.log($(this).prop("checked"));
		if($(this).prop("checked") == true){
			$('.allcheksel').parent('span').addClass('checked');
			// $('.allcheksel').attr('checked','checked');
			$('.allcheksel').trigger("click");
		}else{
			$('.allcheksel').parent('span').removeClass('checked');
			$('.allcheksel').removeAttr('checked');
		}
	});	
	
	//single row delete from table
	$("body").on("click",".delete_btn", function(){

            var btn = $(this);
            var token = $(this).data('token');
            var id = $(this).data('id');
			var delurl = $(this).data('url');
            swal({
                title: $("#confirm_msg_error").text(),
				text: "",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: $("#confirm_yes_error").text(),
				cancelButtonText: $("#confirm_no_error").text(),
                closeOnConfirm: false,
                closeOnCancel: false
             },
             function(isConfirm){
               if (isConfirm){
				  
					// console.log(delurl+'/'+id);
					// return false;
                     $.ajax({
						url: delurl+"/"+id,
						type: "post",
						data: {_method: 'delete', _token :token},
						success: function(d) {
							swal($("#delete_msg_error").text(), " ", "success");
							setTimeout(function(){ location.reload(); }, 1500);
							//btn.parent().parent().hide();
							//return false;
						}
					});
                } else {
                  swal($("#cancel_msg_error").text(), " ", "error");
                }
             });

        });

	//single row delete from table
	$("body").on("click",".delete_btnn", function(){

		var btn = $(this);
		var token = $(this).data('token');
		var id = $(this).data('id');
		var delurl = $(this).data('url');
		swal({
			title: $("#confirm_msg_error").text(),
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: $("#confirm_yes_error").text(),
			cancelButtonText: $("#confirm_no_error").text(),
			closeOnConfirm: false,
			closeOnCancel: false
		 },
		 function(isConfirm){
		   if (isConfirm){
			  
				// console.log(delurl+'/'+id);
				// return false;
				 $.ajax({
					url: delurl,
					type: "post",
					data: {_method: 'delete', _token :token},
					success: function(d) {
						// swal($("#delete_msg_error").text(), " ", "success");
						swal({
							title: $("#delete_msg_error").text(), 
							text: " ", 
							type: "success"
						  },
						function(){ 
							datatablefilter();
						});
						// setTimeout(function(){ location.reload(); }, 1500);
						//btn.parent().parent().hide();
						//return false;
					}
				});
			} else {
			  swal($("#cancel_msg_error").text(), " ", "error");
			}
		 });

	});
});	