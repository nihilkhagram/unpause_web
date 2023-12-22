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
use App\Users;
use App\Appointment;
use App\Role;
use App\Traits\NotificationTrait;
use Exception;
use App\Jobs\SendNotificationJob;


class UsersController extends Controller
{
    use NotificationTrait;
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
			$this->tablename = 'users';
			 $this->feildname = 'is_active';
		 //Used For Table Row Status Active/InActive	
      }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index',['context' => $this]);
    }
    public function create()
    {
       return view('users.create',['context' => $this]);
    }

    public function users_filter(Request $request)
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
            $order_datefrom = isset($input['order_datefrom']) ? $input['order_datefrom'] : '';
		        $order_dateto = isset($input['order_dateto']) ? $input['order_dateto'] : '';
		
            $page = isset($input['page']) ? $input['page'] : '';
        
            
            $created_by = isset($input['created_by']) ? $input['created_by'] : '';
            $searchQuery = " ";
                $query_set_value="";
                $query_set_value = "WHERE 1=1 ";
				 $query_set_value .= "AND m.Is_delete = '0' "; 
                 $query_set_value .= "AND m.is_verified != '0' "; 

            if($searchValue != ''){
                $query_set_value .= " AND (email like '%".$searchValue."%')";
            }
            if ($order_datefrom != '') {
                $datefrom = date('Y/m/d', strtotime($order_datefrom));
                $query_set_value .= " AND m.created_at >= '" . $datefrom . "'";
            }
            if ($order_dateto != '') {
                $dateto = date('Y/m/d', strtotime($order_dateto));
                $query_set_value .= " AND m.created_at <= '" . $dateto . "'";
            }
            

            $orderBy = " order by `".$columnName."` ".$columnSortOrder;
            $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
            $array =  \DB::select("SELECT m.*,lt.role_name  as lname FROM users  as m left join tbl_role as lt on lt.id = m.role $query_set_value $orderBy");
				
               $totalarray =  \DB::select("SELECT m.*,lt.role_name as lname FROM users as m left join tbl_role as lt on lt.id = m.role	$query_set_value");
			  // $array = \DB::select("SELECT * FROM users  $query_set_value $orderBy");
			   //$totalarray = \DB::select("SELECT * FROM users  $query_set_value $orderBy");

            $dataArray = array();
            $i = 1;
            if($array != NULL){
                foreach($array AS $key => $row){
                    
                    $rowData = new \stdClass();
					$checkboxHtml = '<td><input type="checkbox" name="selectedIds[]" value="'.$row->id.'" id="rowchk'.$row->id.'" class="form-check-input flex-none allcheksel" /></td>';
						$rowData->chk  = $checkboxHtml;
                    $rowData->id = $i;
  					$rowData->role= $row->role; 
					$rowData->lname = $row->lname;
                    $rowData->first_name = $row->first_name;
                    $rowData->last_name = $row->last_name;
                    $rowData->phone_number = $row->phone_number;
                    $rowData->email = $row->email;
					 $rowData->password = $row->password;
                    $date=strtotime($row->created_at);
                        $rowData->created_at=date('d-m-Y',$date);
						
						 $view = View::make('statuschange', ["feildname"=>$this->feildname,"value" => $row]);
						$rowData->status = $view->render();
						
                  
                   // $date=strtotime($row->created_at);
                   //$rowData->created_at=$date;
                    
						/* 
                        if($row->Is_active == 1)
                        {
                            $rowData->status = '<button id="checkbox_'.$row->id.'" data-id="0" onclick="change_status('.$row->id.');" class="flex items-center justify-center text-theme-9"><i id="i_'.$row->id.'" data-feather="check-square" class="w-4 h-4 mr-2"></i>Active</button>';
                        }
                        else
                        {
                            $rowData->status = '<button id="checkbox_'.$row->id.'" data-id="0" onclick="change_status('.$row->id.');" class="flex items-center justify-center text-theme-6"><i id="i_'.$row->id.'" data-feather="check-square" class="w-4 h-4 mr-2"></i>InActive</button>';
                        } */
					 $url = URL::to('/').'/users/'.$row->id.'/edit';
                        $delete = "item_delete('".$row->id."','".$key."');";
						$delurl = URL::to('/').'/users';
						
        
					
					
                    //$delurl = URL::route('roleModule.destroy',$row->id);//URL::to('/').'/plandelete';//\
    
                   $rowData->action = '<div class="flex justify-center items-center">
                            <a class="btn btn-warning shadow-md flex items-center mr-3 edit_btn" href="'.$url.'"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                            <button type="button" class="btn btn-danger shadow-md flex items-center delete_btn" data-url="'.$delurl.'" data-id="'.$row->id.'" data-token="'. csrf_token().'"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </button>
                        </div>';
                        
                        $dataArray[] = $rowData;
								$i++;
                }
                
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
            $validatedData = $request->validate([
				
				'name' => 'required',
				'Is_active' => 'required',
				
			]);
	$insert_arr['role'] = $request->role;
			$insert_arr['name'] = $request->name;
			$insert_arr['email'] = $request->email;
			//$insert_arr['email_verified_at'] = $request->email_verified_at;
			$insert_arr['password'] = $request->password;
			$insert_arr['Is_active'] = $request->Is_active;
			//$insert_arr['Created_by'] = Auth::user()->id;
			//$insert_arr['created_dt'] = date("Y-m-d H:i:s");
			//$insert_arr['updated_at'] = date("Y-m-d H:i:s");
			//print_r($update_data);exit;
			//$update_data->save();
			$inserted_data = Users::create($insert_arr);
            return redirect('/users')->with('flash_message_success','Data added successfully.');
        }catch (\Illuminate\Validation\ValidationException $e ) {
			/**
             * Validation failed
             * Tell the end-user why
             */
            $arrError = $e->errors(); // Useful method - thank you Laravel
			// print_r($arrError);exit;
			return redirect()->back()->withErrors($arrError);
		}catch (\Exception $e) {
            print_r($e->getFile());
           print_r($e->getLine());
            print_r($e->getMessage());exit;
            return redirect()->back()->with('flash_message_error','Something is wrong!');
    }
    
    }
    public function show(Users $users)
    {
        //
    }
 /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Users $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users,$id)
    {
        $detail = Users::find($id);
		// print_r($detail);exit;
		return view('users.edit',['context' => $this,'detail' => $detail]);    }

  /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
		
		 $validatedData = $request->validate([
            'name' => 'required|max:255',
			'Is_active' => 'required|min:0|max:2',
			
            
       ]);
       try {
			 
			
			$update_data = Users::find($id);
			$update_data['name'] = $request->name;
			$update_data['email'] = $request->email;
			//$update_data['role'] = $request->role;
			$update_data['password'] = $request->password;
			$update_data['Is_active'] = $request->Is_active;
			//$update_data['Created_by'] = Auth::user()->id;
			//$update_data['updated_at'] = date("Y-m-d H:i:s");
			//print_r($update_data);exit;
			$update_data->save();
			//Liftmachine::where('id',$id)->update($update_data);
            return redirect('/users')->with('flash_message_success','Data updated successfully.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
	}
     
	 /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users $users
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		try {
			Users::find($id)->delete();
			return redirect()->back()->with('flash_message_success','Data Deleted Successfully');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
    }
    function sendNotification(Request $request)
    {

        try {
            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string',
            
            ]);

            $notification_data = array(
                
                'title' => $request->title,
                'body' => $request->body,
                'type' => $request->type,
            );

            $this->allUserNotification($notification_data);

            return redirect()->back()->with('flash_message_success', 'Notification request sent successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('flash_message_error', 'Something is wrong!');
        }
    }

    function send_notification(Request $request)
    {
        

        $today_date = date('Y-m-d');
        $user= Appointment::whereDate('date','=',$today_date)->where('is_appointment_done',0)->where('is_active',1)->where('is_delete',0)->get()->pluck('login_id','time','date')->toArray();   
        $time = $user->time;
        $date = $user->date;
       
  
            $fcm_token_array =Users::where('id,$user->login_id')->pluck('fcm_token')->toArray();

            $notification_data = array(
                'type' => 'normal',
                'title' => 'You Have Appointment Today',
                'body' => 'You Have Appointment Today',
            );

            
           $result[] = dispatch(new SendNotificationJob($fcm_token_array, $notification_data));

    }

    
}



