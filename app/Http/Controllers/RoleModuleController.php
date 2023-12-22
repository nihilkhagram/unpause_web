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

class RoleModuleController extends Controller
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
			$this->tablename = 'tbl_role_module';
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
        return view('roleModule.index',['context' => $this,'module_details' => $module_details]);
    }
    public function create()
    {
        $module_details = Module::where('is_parent',0)->pluck('module_name','id');
        return view('roleModule.create',['context' => $this,'module_details' => $module_details]);
    }

    public function rolemodule_filter(Request $request)
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
                $query_set_value .= " AND (module_name like '%".$searchValue."%')";
            }
            

            $orderBy = " order by `".$columnName."` ".$columnSortOrder;
            $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
            $array = \DB::select("SELECT * FROM tbl_role_module $query_set_value $orderBy");

            $totalarray = \DB::select("SELECT * FROM tbl_role_module $query_set_value");

            $dataArray = array();
            $i = 1;
            if($array != NULL){
                foreach($array AS $key => $row){
                    
                    $rowData = new \stdClass();
                    $rowData->id = $key+1;
                    $rowData->module_name = $row->module_name;
                    $rowData->slug = $row->slug;
                    if($row->is_parent == 0):
                        $rowData->type = 'Parent';
                    else:
                        $rowData->type = 'Child';
                    endif;
                    $date=strtotime($row->created_at);
                    $rowData->created_dt=date('d-m-Y',$date);
                    
                    $delurl = URL::route('roleModule.destroy',$row->id);//URL::to('/').'/plandelete';//\
    
                    $rowData->action = '<div class="flex justify-center items-center">
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
                'module_name' => 'required',
               
            ]);
            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors())->withInput();
            }
            //bank account create
            $is_parent = 0;
            if(isset($request->is_parent) && $request->is_parent == 1 && $request->parent_module != '')
            {
                $is_parent = $request->parent_module;
            }
            $Module = new Module();		
            $generate_slug = Str::slug($request->module_name, '-');
            $Module->module_name = $request->module_name;
            $Module->slug = $generate_slug;
            $Module->is_parent = $is_parent;
            $Module->save();
        
           return redirect()->route('roleModule.index')->with('flash_message_success','Module added successfully.');
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
		$service = ServiceMaster::find($id);
      $WalletType = WalletType::where('is_delete','=',0)->where('is_active','=',1)->pluck('wallet_name','id')->prepend('Select Wallet Type','');
		return view('servicemaster.edit',['context' => $this,'service' => $service,'WalletType' => $WalletType]);
    }

    public function update(Request $request,$id)
    {
        try {
			$validatedData = $request->validate([
                'service_master_name' => 'required',
                'company_id' => 'required',
            ]);
        
            $ServiceMaster = ServiceMaster::find($id);
            $ServiceMaster->service_master_name = $request->service_master_name;
            $ServiceMaster->company_id = $request->company_id;
            $ServiceMaster->wt_id = $request->wt_id;
            if($request->image_icon) {
                 $imageName = time().rand(0000,9999).'.'.$request->image_icon->extension();  
                     
                 $request->image_icon->move(public_path('assets/images/service_image/'), $imageName);
                 $pic = 'assets/images/service_image/'.$imageName;
                 $ServiceMaster->image_icon = $pic;
           }         
            $ServiceMaster->created_by = Auth::User()->id;
            $ServiceMaster->created_at = date('Y-m-d H:i:s');
            $ServiceMaster->updated_at = date('Y-m-d H:i:s');
            $ServiceMaster->save();
            return redirect()->route('servicemaster.index')->with('flash_message_success','Service added successfully.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
    }
    public function destroy(Request $request,$id)
    {
        $data=Module::where('id','=',$id)->delete();
        echo json_encode(true);
    }
}



