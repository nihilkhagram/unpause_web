<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Session;
use URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 
use App\ServiceMaster;
use App\Module;
use App\Role;
use App\RolePermission;

class RolePermissionController extends Controller
{
	public $feildname;
	public $tablename;
	/**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
          //Used For Table Row Status Active/InActive
			$this->tablename = 'tbl_role';
			// $this->feildname = 'is_active';
		 //Used For Table Row Status Active/InActive	
      }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module_details = Module::where('is_parent',0)->get();
        return view('rolePermission.index',['context' => $this,'module_details' => $module_details]);
    }
    public function create()
    {
        $module_details = Module::get();
        return view('rolePermission.create',['context' => $this,'module_details' => $module_details]);
    }

    public function rolepermission_filter(Request $request)
    {
		 
			
            $input = $request->all();
            $draw = $_POST['draw'];
            // $row = $_POST['start'];
            // $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
            if(isset($_REQUEST['search_input'])){
                $searchValue = $_REQUEST['search_input'];
            }
            $page = isset($input['page']) ? $input['page'] : '';
        
            
            $created_by = isset($input['created_by']) ? $input['created_by'] : '';
            $searchQuery = " ";
                $query_set_value="";
                $query_set_value = "WHERE 1=1 ";
            if($searchValue != ''){
                $query_set_value .= " AND (role_name like '%".$searchValue."%')";
            }
            

            $orderBy = " order by `".$columnName."` ".$columnSortOrder;
            $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
            $array = \DB::select("SELECT * FROM tbl_role $query_set_value $orderBy");

            $totalarray = \DB::select("SELECT * FROM tbl_role $query_set_value");

            $dataArray = array();
            $i = 1;
            if($array != NULL){
                foreach($array AS $key => $row){
                    
                    $rowData = new \stdClass();
                    $rowData->id = $key+1;
                    $rowData->role_name = $row->role_name;
                   
                    $date=strtotime($row->created_at);
                    $rowData->created_dt=date('d-m-Y',$date);

                    $encodeid = base64_encode($row->id);
                    $url = URL::route('rolePermission.edit',$encodeid);
                    $delurl = URL::route('rolePermission.destroy',$row->id);//URL::to('/').'/plandelete';//\
    
                    $rowData->action = '<div class="flex justify-center items-center"> <a class="btn btn-warning shadow-md flex items-center mr-3 edit_btn" href="'.$url.'"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                        <button class="btn btn-danger shadow-md flex items-center delete_btnn" data-url="'.$delurl.'" data-id="'.$row->id.'" data-token="'. csrf_token().'"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </button>
                    </div>';                        
                    $dataArray[] = $rowData;
                }
                $i++;
            }

            

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => count($dataArray),
                "iTotalDisplayRecords" => count($totalarray),
                "aaData" => $dataArray
            );

            echo json_encode($response);
            exit;


    }

  

 
    public function store(Request $request)
    {
        try {
            $v = Validator::make($request->all(), [
                'role_name' => 'required',
               
            ]);
            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors())->withInput();
            }
            $requestData = $request->all();
            $Module = new Role();
            $Module->role_name = $requestData['role_name'];
            $Module->save();
            $role_id = $Module->id;
            $total_page = sizeof($requestData['module_id']);
            
            for($j=0;$j<$total_page;$j++)
            {
                $permission = '';
                
                if(isset($requestData['view_all'.$j])){
                    $permission .= $requestData['view_all'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['view_own'.$j])){
                    $permission .= $requestData['view_own'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['create'.$j])){
                    $permission .= $requestData['create'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['edit_all'.$j])){
                    $permission .= $requestData['edit_all'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['edit_own'.$j])){
                    $permission .= $requestData['edit_own'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['delete'.$j])){
                    $permission .= $requestData['delete'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['delete_own'.$j])){
                    $permission .= $requestData['delete_own'.$j];
                }
                else{
                    $permission .= 'none';
                }
                $module_id = $requestData['module_id'][$j];
                $module_slug = Module::where('id',$module_id)->first();
                $RolePermission = new RolePermission();
                $RolePermission->role_id = $role_id;
                $RolePermission->module_id = $module_id;
                $RolePermission->slug = $module_slug->slug;
                $RolePermission->permission = $permission;            
                $RolePermission->save();
            }
        
           return redirect()->route('rolePermission.index')->with('flash_message_success','Role Permission added successfully.');
       }catch (\Illuminate\Validation\ValidationException $e ) {
       
           $arrError = $e->errors(); // Useful method - thank you Laravel
           return redirect()->back()->withErrors($arrError);
       }catch (\Exception $e) {
        
           return redirect()->back()->with('flash_message_error','Something is wrong!');
       }
    }
    public function show(FloorM $floor)
    {
        //
    }

    public function edit(Request $request,$id)
    {
        $id = base64_decode($id);
		$role_name = Role::where('id',$id)->first();
        $module_details = Module::get();
		 foreach($module_details as $key => $value)
		 {
			 $checkRolePermission = RolePermission::where('role_id',$id)->where('module_id',$value->id)->first();
			 if($checkRolePermission !='')
			 {
				 $permissiongrp = $checkRolePermission->permission;
				 $permissionarray = explode('|',$permissiongrp);
				 if($permissionarray[0] == 'viewall')
				 {
					 $module_details[$key]->viewall = 1;
				 }else{
					 $module_details[$key]->viewall = 0;
				 }
				  if($permissionarray[1] == 'viewown')
				 {
					 $module_details[$key]->viewown = 1;
				 }else{
					 $module_details[$key]->viewown = 0;
				 }
				  if($permissionarray[2] == 'create')
				 {
					 $module_details[$key]->create = 1;
				 }else{
					 $module_details[$key]->create = 0;
				 }
				  if($permissionarray[3] == 'editall')
				 {
					 $module_details[$key]->editall = 1;
				 }else{
					 $module_details[$key]->editall = 0;
				 }
				  if($permissionarray[4] == 'editown')
				 {
					 $module_details[$key]->editown = 1;
				 }else{
					 $module_details[$key]->editown = 0;
				 }
				  if($permissionarray[5] == 'delete')
				 {
					 $module_details[$key]->delete = 1;
				 }else{
					 $module_details[$key]->delete = 0;
				 }
				  if($permissionarray[6] == 'deleteown')
				 {
					 $module_details[$key]->deleteown = 1;
				 }else{
					 $module_details[$key]->deleteown = 0;
				 }
			 }
		 }
		return view('rolePermission.edit',['context' => $this,'role_name' => $role_name,'module_details' => $module_details]);
    }

    public function update(Request $request,$id)
    {
        try {
			$validatedData = $request->validate([
                'role_name' => 'required',
            ]);
            $v = Validator::make($request->all(), [
                'role_name' => 'required',               
            ]);
            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors())->withInput();
            }
            
            $requestData = $request->all();
            $Module = Role::where('id',$id)->first();
            $Module->role_name = $requestData['role_name'];
            $Module->save();
            RolePermission::where('role_id',$id)->delete();
            $total_page = sizeof($requestData['module_id']);
            
            for($j=0;$j<$total_page;$j++)
            {
                $permission = '';
                
                if(isset($requestData['view_all'.$j])){
                    $permission .= $requestData['view_all'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['view_own'.$j])){
                    $permission .= $requestData['view_own'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['create'.$j])){
                    $permission .= $requestData['create'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['edit_all'.$j])){
                    $permission .= $requestData['edit_all'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['edit_own'.$j])){
                    $permission .= $requestData['edit_own'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['delete'.$j])){
                    $permission .= $requestData['delete'.$j].'|';
                }
                else{
                    $permission .= 'none|';
                }
                
                if(isset($requestData['delete_own'.$j])){
                    $permission .= $requestData['delete_own'.$j];
                }
                else{
                    $permission .= 'none';
                }
                $module_id = $requestData['module_id'][$j];
                $module_slug = Module::where('id',$module_id)->first();
                $RolePermission = new RolePermission();
                $RolePermission->role_id = $id;
                $RolePermission->module_id = $module_id;
                $RolePermission->slug = $module_slug->slug;
                $RolePermission->permission = $permission;
                $RolePermission->save(); 
            }
            return redirect()->route('rolePermission.index')->with('flash_message_success','Role Permission Updated successfully.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
    }
    public function destroy(Request $request,$id)
    {
        RolePermission::where('role_id',$id)->delete();
		$check = Role::where('id',$id)->delete();
        echo json_encode(true);
    }
}



