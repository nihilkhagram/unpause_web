<?php

namespace App\Http\Controllers;

use App\Failedjobs;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Input;

use Session;

use URL;

use Illuminate\Support\Facades\View;

class FailedjobsController extends Controller
{
	public $feildname;
	/**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
          //Used For Table Row Status Active/InActive
			$this->tablename = 'failed_jobs';
		 //Used For Table Row Status Active/InActive	
      }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('failedjobs.index',['context' => $this]);
    }

    public function failedjobs_filter(Request $request)
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
                $query_set_value .= "AND Is_delete = '0'"; 
                if($searchValue != ''){
                  $query_set_value .= " AND (name like '%".$searchValue."%' OR mobile_no like '%".$searchValue."%')";
                }
                

                $orderBy = " order by `".$columnName."` ".$columnSortOrder;
                $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
                 $array = \DB::select("SELECT * ,id AS chk FROM executive $query_set_value $orderBy");

                $totalarray = \DB::select("SELECT *,id AS chk FROM executive $query_set_value $orderBy");

                $dataArray = array();
                $i = 1;
                if($array != NULL){
                    foreach($array AS $key => $row){
                        
                        $rowData = new \stdClass();
							$checkboxHtml = '<td><input type="checkbox" name="selectedIds[]" value="'.$row->id.'" id="rowchk'.$row->id.'" class="form-check-input flex-none allcheksel" /></td>';
						$rowData->chk  = $checkboxHtml;
                        $rowData->id = $i;
						//$rowData->Lift_type_id = $row->Lift_type_id; 
						$rowData->name = $row->name;
						$rowData->executive_type = $row->executive_type;
						$rowData->mobile_no = $row->mobile_no;
						$rowData->address = $row->address;
						$rowData->district = $row->district;
					    $rowData->state = $row->state;
						$rowData->city = $row->city;
						$rowData->pincode = $row->pincode;
						$rowData->birthdate = $row->birthdate;
						$rowData->emailid = $row->emailid;
						$rowData->anni_date = $row->anni_date;
						$rowData->photo = $row->photo;
                        $date=strtotime($row->created_dt);
                        $rowData->created_dt=date('d-m-Y',$date);
						$view = View::make('statuschange', ["feildname"=>$this->feildname,"value" => $row]);
						$rowData->status = $view->render();
						
						/* 
                        if($row->Is_active == 1)
                        {
                            $rowData->status = '<button id="checkbox_'.$row->id.'" data-id="0" onclick="change_status('.$row->id.');" class="flex items-center justify-center text-theme-9"><i id="i_'.$row->id.'" data-feather="check-square" class="w-4 h-4 mr-2"></i>Active</button>';
                        }
                        else
                        {
                            $rowData->status = '<button id="checkbox_'.$row->id.'" data-id="0" onclick="change_status('.$row->id.');" class="flex items-center justify-center text-theme-6"><i id="i_'.$row->id.'" data-feather="check-square" class="w-4 h-4 mr-2"></i>InActive</button>';
                        } */
						
                        $url = URL::to('/').'/executive/'.$row->id.'/edit';
                        $delete = "item_delete('".$row->id."','".$key."');";
						$delurl = URL::to('/').'/executive';
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		
		 $states = State::where('status','Active')->orderBy('state_title')->get();
		return view('executive.create',['context' => $this],compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		try {
			 $validatedData = $request->validate([
				'name' => 'required',
				'executive_type' => 'required',
			]);
			// Validator::make($request->all(), [
			   // 'Floor_title' => 'required',
			   // 'Floor_price' => 'required',
			// ]);
			
			// if (isset($validator) && $validator->fails()) {
				 // return redirect()->back()->withErrors($validator);
			// }
		// print_r($request->all());exit;
			$insert_arr['name'] = $request->name;
			$insert_arr['executive_type'] = $request->executive_type;
			$insert_arr['mobile_no'] = $request->mobile_no;
			$insert_arr['address'] = $request->address;
			$insert_arr['district'] = $request->district;
			$insert_arr['state'] = $request->state;
			$insert_arr['city'] = $request->city;
			$insert_arr['pincode'] = $request->pincode;
			$insert_arr['birthdate'] = $request->birthdate;
			$insert_arr['emailid'] = $request->emailid;
			$insert_arr['anni_date'] = $request->anni_date;
			$insert_arr['photo'] = $request->photo;
			$insert_arr['Is_active'] = $request->Is_active;
			$insert_arr['created_by'] = Auth::user()->id;
			$insert_arr['created_dt'] = date("Y-m-d H:i:s");
			$insert_arr['modified_dt'] = date("Y-m-d H:i:s");
	 //print_r($insert_arr);exit;
			$inserted_data = Executive::create($request->all());
			//print_r($inserted_data);
			//exit;
            return redirect('/executive')->with('flash_message_success','Data added successfully.');
        }catch (\Illuminate\Validation\ValidationException $e ) {
			/**
             * Validation failed
             * Tell the end-user why
             */
            $arrError = $e->errors(); // Useful method - thank you Laravel
		//print_r($arrError);exit;
			return redirect()->back()->withErrors($arrError);
		}catch (\Exception $e) {
           print_r($e->getFile());
           print_r($e->getLine());
            //print_r($e->getMessage());exit;
            return redirect()->back()->with('flash_message_error','Something is wrong!');
    }
		
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function show(Executive $executive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Executive $executive
     * @return \Illuminate\Http\Response
     */
    public function edit(Executive $executive,$id)
    {
        //
		$detail = Executive::find($id);
		$states = State::where('status','Active')->orderBy('state_title')->get();
		// print_r($detail);exit;
		return view('executive.edit',['context' => $this,'detail' => $detail],compact('states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		try {
			// print_r($lifttype);exit;
			$update_data = array();
			$update_data['name'] = $request->name;
			$update_data['executive_type'] = $request->executive_type;
			$update_data['mobile_no'] = $request->mobile_no;
			$update_data['address'] = $request->address;
			$update_data['district'] = $request->district;
			$update_data['state'] = $request->state;
			$update_data['city'] = $request->city;
			$update_data['pincode'] = $request->pincode;
			$update_data['birthdate'] = $request->birthdate;
			$update_data['emailid'] = $request->emailid;
			$update_data['anni_date'] = $request->anni_date;
			$update_data['photo'] = $request->photo;
			$update_data['Is_active'] = $request->Is_active;
			$update_data['created_by'] = Auth::user()->id;
			$update_data['modified_dt'] = date("Y-m-d H:i:s");
			//print_r($update_data);exit;
			//$update_data->save();
			Executive::where('id',$id)->update($update_data);
            return redirect('/executive')->with('flash_message_success','Data updated successfully.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Executive $executive,$id=NULL)
    {
        //
		 try {
			Executive::find($executive->id)->delete();
			return redirect()->back()->with('flash_message_success','Data Deleted Successfully');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
		
    }
}
