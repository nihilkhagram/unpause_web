<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use DB;
use Auth;
use App\User;
use App\FloorM;
use Illuminate\Support\Facades\Input;
use Session;
use URL;


class AdminController extends Controller
{
      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
          // $this->middleware('auth');
      }

      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Http\Response
       */
      public function index(Request $request)
      {   
		  										 
      }
	  
	  /*
	   * view profile
	   */
      public function view_profile()
      {
			return view('view_profile');
      }

	  /*
	   * change password 
	   */
      public function change_password()
      {
			return view('change_password');
      }

      public function update_profile(Request $request)
      {

          $data = $request->all();
          $admin = Auth::user();
		  
		  if($request->has('curr_password')){
 			 $validatedData = $request->validate([
					'curr_password' => 'required|max:255',
					'new_password' => 'required',
					'new_confirm_password' => 'required|same:new_password'
			   ]);
			  
			 if(Hash::check($data['curr_password'], $admin->password))
			  {
				  $admin->password = Hash::make($data['new_password']);
				  $admin->save();
				  return redirect('/change/password')->with('flash_message_success','Password updated successfully!');
			  }else{
				  return redirect('/change/password')->with('flash_message_error','Invalid current password');
			  }
		  }else{
			  $validatedData = $request->validate([
					'name' => 'required|max:255',
					'email' => 'required|email',
			   ]);
			  
			  //profile update
			  $admin->name = $request->name;
			  $admin->email = $request->email;
			  $admin->save();
			  //profile update			  
		  }
		  
		return redirect('/profile')->with('flash_message_success','Profile updated successfully!');

      }
	  
	 /**
     * table action change
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tableaction(Request $request)
    {
		// echo "herer";exit;
		$data = $request->all();
		
		
		try{
			if(isset($data['selectedIds'])){
				$tablename = $data['tablename'];
				$feildname = $data['feildname'];
				$selectedIds = $data['selectedIds'];
				$selectedIds = implode("','",$selectedIds);
				// print_r($data['selectedIds']);
				//exit;
				if($data['tableaction'] == "delete"){
					DB::select("DELETE FROM `$tablename` WHERE id IN ('".$selectedIds."')");
				}
				if($data['tableaction'] == "active"){
					DB::select("UPDATE `$tablename` SET `$feildname`='1' WHERE id IN ('".$selectedIds."')");
				}
				if($data['tableaction'] == "inactive"){
					DB::select("UPDATE `$tablename` SET `$feildname`='2' WHERE id IN ('".$selectedIds."')");
				}
				$data1['status'] = "success";
			}else{
				$data1['status'] = "failed";
			}
		}catch (\Exception $e) {
			$data1['errormsg'] = $e->getMessage();
			$data1['errorline'] = $e->getLine();
			$data1['status'] = "failed";
		}	
		return json_encode($data1);
	}	
	 /**
     * Change status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function statuschange(Request $request)
    {
		$data = $request->all();
		try{
			if(isset($data['id'])){
				
				$id = $data['id'];
				$tablename = $data['tablename'];
				$feildname = $data['feildname'];
				
				$statusdata = DB::select("select * from `$tablename` WHERE id='$id'");
				$statusdata = isset($statusdata[0]) ? $statusdata[0] : "";
				if($statusdata->$feildname == 1){
					$updatedata["$feildname"] = 2;
				}else{
					$updatedata["$feildname"] = 1;
				}

				$status = $updatedata["$feildname"];
				$statusdata = DB::select("UPDATE `$tablename` SET `$feildname`='$status' WHERE id='$id'");

				if($feildname == 'status' && $updatedata["$feildname"] == 1)
				{
					// $start_date = date("Y-m-d");
					// $end_date = date("Y-m-d", strtotime("+30 days",strtotime(date("Y-m-d"))));

					// if($tablename == 'property')
					// {
						// $user_subscription = UserSubscription::where('rent_property_id',$id)->first();

					// }
					
					// else if($tablename == 'vehicle')
					// {
						// $vehicleObj = Vehicle::find($id);
						// if(isset($vehicleObj->type_id) && $vehicleObj->type_id == 1)
						// {
							// $user_subscription = UserSubscription::where('rent_vehicle_id',$id)->first();
						// }else {

							// $user_subscription = UserSubscription::where('vehicle_id',$id)->first();
						// }

					// }
					
				}
				$statusdata = DB::select("select * from $tablename WHERE id='$id'");
				$statusdata = isset($statusdata[0]) ? $statusdata[0] : "";	
				$view = View::make('statuschange', ["feildname"=>$feildname,"value" => $statusdata]);
				$data['html'] = $view->render();
				$data['status'] = "success";
			}else{
				$data['html'] = "";
				$data['status'] = "failed";
			}
		}catch (\Exception $e) {
			$data['errormsg'] = $e->getMessage();
			$data['errorline'] = $e->getLine();
			$data['html'] = "";
			$data['status'] = "failed";
		}
        return json_encode($data);
    }
}
