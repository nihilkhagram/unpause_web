<?php if(isset($head) && $head == 1){  ?>
<form action="" id="multipleselecttable" method="post">
	<input type="hidden" name="tablename" value="{{ $page_details->tablename }}" />
	@csrf
	<input type="hidden" name="tableaction" id="tableactioninput"  value="" />
	<input type="hidden" name="feildname" id="tablefeildname"  value="" />
<?php } ?>
<span id="menu_url_header" class="hide">{{ $page_details->tablename }}</span>
<div class="table-toolbar col-md-6">
	<div class="grid grid-cols-12 gap-6 my-5">
		<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
			<div class="input-group m-b multiselectaction" >
				<select name="" class="form-control btn green tableactionsel mr-2" >
					<option value="">Select Action</option>
					<?php if(!isset($is_delete)){  ?>
					<option value="delete">Delete</option>
					<?php } ?>
					<?php if(isset($column)){ ?>
					<option value="active" data-feild="{{ $column }}">Active</option>
					<option value="inactive" data-feild="{{ $column }}">Inactive</option>
					<?php } ?>
				</select>
				<input type="button" id="multiactionbtn" class="btn btn-primary shadow-md mr-2" value="SUBMIT" />
			</div>
		</div>
	</div>
</div>

<?php if(!isset($head)){ ?>	
</form>
<?php } ?>