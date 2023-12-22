<?php

namespace App\Http\Controllers;

use App\Post;

use App\Catgory;

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
use App\Services\CommonService;

class PostController extends Controller
{
	public $feildname;
	public $tablename;
	/**
       * Create a new controller instance.
       *
       * @return void
       */
	   protected $commonservice;
      public function __construct(CommonService $commonservices)
      {
          //Used For Table Row Status Active/InActive
			$this->tablename = 'post';
			$this->feildname = 'is_active';
			 $this->commonservice = $commonservices;
		 //Used For Table Row Status Active/InActive	
      }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
       
			return view('post.index',['context' => $this]);
       
        
    }

    public function post_filter(Request $request)
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
                $query_set_value .= "AND m.is_delete = '0'"; 
				
                   
                
                if($searchValue != ''){
                  $query_set_value .= " AND (title like '%".$searchValue."%' )";
                }
                

                $orderBy = " order by `".$columnName."` ".$columnSortOrder;
                $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
                //$array = \DB::select("SELECT * FROM tbl_lift_machine  $query_set_value $orderBy");
				//$array = \DB::select("SELECT q.*,u.id as users FROM property as q left join users as u on u.id = q.user_id  $query_set_value $orderBy");
				$array =  \DB::select("SELECT m.*,lt.category_name  as lname FROM post  as m left join category as lt on lt.id = m.category_id  $query_set_value $orderBy");
				
                $totalarray =  \DB::select("SELECT m.*,lt.category_name  as lname FROM post as m left join category as lt on lt.id = m.category_id  $query_set_value ");

                $dataArray = array();
                $i = 1;
                if($array != NULL){
                    foreach($array AS $key => $row){
                        
                        $rowData = new \stdClass();
										$checkboxHtml = '<td><input type="checkbox" name="selectedIds[]" value="'.$row->id.'" id="rowchk'.$row->id.'" class="form-check-input flex-none allcheksel" /></td>';
						$rowData->chk  = $checkboxHtml;
                        $rowData->id = $i;
						$rowData->category_id = $row->category_id; 
						//$rowData->Is_stock = $row->Is_stock;
						//$rowData->Is_stock = $row->Is_stock;
						$rowData->lname = $row->lname;
						$rowData->title = $row->title;
						$rowData->short_desc = $row->short_desc;
						$rowData->long_desc = $row->long_desc;
					    $rowData->videos = $row->videos;

                        $rowData->youtube_url = $row->youtube_url;
                        //$rowData->approve_status = $row->approve_status;
                        $os = $row->approve_status;
						if($os=="Pending")
						{
							$status = array('Pending'=>'Pending','Verified'=>'Verified','Active'=>'Active','Rejected'=>'Rejected');
						}
						elseif($os=="Verified")
						{
							$status = array('Verified'=>'Verified','Active'=>'Active','Rejected'=>'Rejected');
						}
						elseif($os=="Active")
						{
							$status = array('Active'=>'Active','Rejected'=>'Rejected');
						}
						else
						{
							$status = array('Rejected'=>'Rejected');
						}
						
						$sh = '<select name="approve_status" onChange="approve_status_change(value,'.$row->id.')" class="form-control">';
						$sh .='<option value="'.$os.'" selected>'.$os.'</option>';
						unset($status[$os]);
						foreach($status as $s)
						{
							$sh .= '<option value="'.$s.'" >'.$s.'</option>';
						}
						$sh .='</select>';
						$rowData->approve_status = $sh;
                        $rowData->reward_points= $row->reward_points;

                        $date=strtotime($row->created_date);
                        $rowData->created_date=date('d/m/Y',$date);

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
						
                        $url = URL::to('/').'/post/'.$row->id.'/edit';
                        $delete = "item_delete('".$row->id."','".$key."');";
						$delurl = URL::to('/').'/post';
						
        
                         $action = '<div class="flex justify-center items-center">';
                        
                                    $action .=' <a class="btn btn-warning shadow-md flex items-center mr-3 edit_btn" href="'.$url.'"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>';
                              
                       
                                    $action .='<button type="button" class="btn btn-danger shadow-md flex items-center delete_btn" data-url="'.$delurl.'" data-id="'.$row->id.'" data-token="'. csrf_token().'"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </button>';
                               
                               
                        $action .='</div>';
                        $rowData->action = $action;

                        
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
		
		    return view('post.create',['context' => $this]);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
       try {
		   $validatedData = $request->validate([
				'title' => 'required|max:255',
				'short_desc' => 'required|max:255',
                'videos'=>'required|nullable|mimetypes:video/mp4',
			]);

			// print_r($lifttype);exit;
			//$update_data = array();
			$insert_arr['category_id']=$request->category_id;
			$insert_arr['title'] = $request->title;
			$insert_arr['short_desc'] = $request->short_desc;
			$insert_arr['long_desc'] = $request->long_desc;
		//	$insert_arr['videos'] = $request->videos;

       
        //save new category image
        if($request->videos && $request->videos != '') {
            $imageName = time().rand(0000,9999).'.'.$request->videos->extension();

            $pic = 'assets/images/category_image/'.$imageName;
            $fileType = $request->videos->extension();
            $request->videos->move(public_path('assets/images/category_image/'), $imageName);
            $temp_path = public_path('assets/images/category_image/'.$imageName);
            $destination = public_path('assets/images/category_image/'.$imageName);
            $this->resize($temp_path,$destination,300,200);
        
            $insert_arr['videos'] = $pic ;
            $insert_arr['videos'] = 'assets/images/category_image/'.$imageName;
        }


			$insert_arr['youtube_url'] = $request->youtube_url;
            $insert_arr['approve_status'] = $request->approve_status;
            $insert_arr['reward_points'] = $request->reward_points;
            $insert_arr['is_active'] = $request->is_active;
			$insert_arr['Created_by'] = Auth::user()->id;
			$insert_arr['created_date'] = date("Y-m-d H:i:s");
			$insert_arr['Modified_dt'] = date("Y-m-d H:i:s");
			//print_r($insert_arr);exit;
			//$update_data->save();
			$inserted_data = Post::create($insert_arr);
            return redirect('/post')->with('flash_message_success','Post added successfully.');
        }catch (\Illuminate\Validation\ValidationException $e ) {
			/**
             * Validation failed
             * Tell the end-user why
             */
            $arrError = $e->errors(); // Useful method - thank you Laravel
			// print_r($arrError);exit;
			return redirect()->back()->withErrors($arrError);
		}catch (\Exception $e) {
            //print_r($e->getFile());
           print_r($e->getLine());
            print_r($e->getMessage());exit;
            return redirect()->back()->with('flash_message_error','Something is wrong!');
    }
    
	
   
		
    }
    public function approve_status_change(Request $request)
	{
        // print_r('k');
        // exit;
		$id = $request->get('id');
		$status  = $request->get('status');
		$cancel_message  = $request->get('cancel_message');
		$res = Post::where('id',$id)->update(array('approve_status'=>$status));
		return true;	
	}
    /**
     * Display the specified resource.
     *
     * @param  \App\Cabinsubtype $cabinsubtype
     * @return \Illuminate\Http\Response
     */
    public function show(Cabinsubtype $cabinsubtype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post,$id)
    {
        //
		$detail = Post::find($id);
		// print_r($detail);exit;
		return view('post.edit',['context' => $this,'detail' => $detail]);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		// try {
            $validatedData = $request->validate([
				// 'title' => 'required|max:255',
				// 'short_desc' => 'required|max:255',
                //'videos'=>'required|nullable|mimetypes:video/mp4',
			]);
			// print_r($lifttype);exit;
			$update_data = array();
			$update_data['category_id'] = $request->category_id;
			//$update_data['Is_stock'] = $request->Is_stock;
			//$update_data['Stock_qty'] = $request->Stock_qty;
			$update_data['title'] = $request->title;
			$update_data['short_desc'] = $request->short_desc;
			$update_data['long_desc'] = $request->long_desc;
			//$update_data['videos'] = $request->videos;
            $update_data['title'] = $request->title;
			$update_data['short_desc'] = $request->short_desc;
			$update_data['long_desc'] = $request->long_desc;
            $update_data['youtube_url'] = $request->youtube_url;
            $update_data['approve_status'] = $request->approve_status;
            $update_data['reward_points'] = $request->reward_points;
			//$update_data['videos'] = $request->videos;



              // delete old category image
              if($request->videos != null && $request->videos != '') {
                if(file_exists(public_path().'/'.$request->videos))
                {
                    unlink(public_path().'/'.$request->videos);
                }
            }
            //save new category image
            if($request->videos && $request->videos != '') {
                $imageName = time().rand(0000,9999).'.'.$request->videos->extension();

                $pic = 'assets/images/category_image/'.$imageName;
                $fileType = $request->videos->extension();
                $request->videos->move(public_path('assets/images/category_image/'), $imageName);
                $temp_path = public_path('assets/images/category_image/'.$imageName);
                $destination = public_path('assets/images/category_image/'.$imageName);
                //$this->resize($temp_path,$destination,300,200);
            
                $update_data['videos'] = $pic ;
                $update_data['videos'] = 'assets/images/category_image/'.$imageName;
            }


			$update_data['is_active'] = $request->is_active;
			//$update_data['Created_by'] = Auth::user()->id;
			$update_data['created_date'] = date("Y-m-d H:i:s");
			//print_r($update_data);exit;
			//$update_data->save();
			Post::where('id',$id)->update($update_data);
            return redirect('/post')->with('flash_message_success','Data updated successfully.');
        // }
        // catch (\Exception $e) {
        //     print_r($e->getLine());
        //     print_r($e->getMessage());exit;
        //     return redirect()->back()->with('flash_message_error','Something is wrong!');
        // }

		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post,$id)
    {
       
	   //
		try {
			Post::find($id)->delete();
			return redirect()->back()->with('flash_message_success','Data Deleted Successfully');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
    }
		
    
}
