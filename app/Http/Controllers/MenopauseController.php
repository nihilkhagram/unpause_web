<?php

namespace App\Http\Controllers;

use App\Menopause;
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
use App\User;

class MenopauseController extends Controller
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
			$this->tablename = 'menopause';
			$this->feildname = 'is_active';
            $this->commonservice = $commonservices;
		 //Used For Table Row Status Active/InActive
    }

    public function index()
    {
        return view('menopause.index',['context' => $this]);
    
    }

    public function menopause_filter(Request $request)
    {
		 
			
                $input = $request->all();
                $draw = $_POST['draw'];
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
            
                
                $Created_by = isset($input['Created_by']) ? $input['Created_by'] : '';
                
                $searchQuery = " ";
                 $query_set_value="";
                 $query_set_value = "WHERE 1=1 ";
                $query_set_value .= "AND is_delete = '0'"; 
                if($searchValue != ''){
                  $query_set_value .= " AND (first_name like '%".$searchValue."%' )";
                }
                if ($order_datefrom != '') {
                    $datefrom = date('Y/m/d', strtotime($order_datefrom));
                    $query_set_value .= " AND created_at >= '" . $datefrom . "'";
                }
                if ($order_dateto != '') {
                    $dateto = date('Y/m/d', strtotime($order_dateto));
                    $query_set_value .= " AND created_at <= '" . $dateto . "'";
                }
                

                $orderBy = " order by `".$columnName."` ".$columnSortOrder;
                $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
                 $array = \DB::select("SELECT *,id AS chk FROM menopause $query_set_value $orderBy");
                // print_r($array);
                // exit;
                 $totalarray = \DB::select("SELECT *,id AS chk FROM menopause $query_set_value $orderBy");


                $dataArray = array();
                $i = 1;
                if($array != NULL){
                    foreach($array AS $key => $row){
                        
                        $rowData = new \stdClass();
						$checkboxHtml = '<td><input type="checkbox" name="selectedIds[]" value="'.$row->id.'" id="rowchk'.$row->id.'" class="form-check-input flex-none allcheksel" /></td>';
						$rowData->chk  = $checkboxHtml;
                        $rowData->id = $i;						
						$rowData->first_name = $row->first_name;						                   
                        $rowData->age = $row->age;
						$rowData->weight = $row->weight;
                         $rowData->smoking = $row->smoking;
                         $rowData->drinking = $row->drinking;
                         $rowData->exercise = $row->exercise;
                         $rowData->pdf_generated_date = $row->pdf_generated_date;
                         $rowData->hot_flashes = $row->hot_flashes;
                         $rowData->night_sweats = $row->night_sweats;
                         $rowData->cold_flashes = $row->cold_flashes;
                         $rowData->physchological = $row->physchological;
                         $rowData->physical = $row->physical;
                         $rowData->last_period = $row->last_period;
                         $rowData->cycle_changed = $row->cycle_changed;
                         $rowData->heavier_bleeding = $row->heavier_bleeding;
                         $rowData->my_management = $row->my_management;
                         $rowData->hrt_routine = $row->hrt_routine;
                        //  $Created_by = User::where('id',$row->Created_by)->first();
    					//  $rowData->Created_by = $Created_by->first_name;

                        // $Created_by = User::where('id',$row->Created_by)->first();
						// $rowData->login_id = $Created_by->first_name;

                        $date=strtotime($row->created_at);
                        $rowData->created_at=date('d-m-Y',$date);

                        $view = View::make('statuschange', ["feildname"=>$this->feildname,"value" => $row]);
						$rowData->status = $view->render();
                        $encodeid = base64_encode($row->id);
                        $url = URL::route('test.edit',$encodeid);
                        $delurl = URL::route('test.destroy',$row->id);
                        $pdf = URL::to('/') . '/menopause/' . $encodeid . '/view';


                        $rowData->action = '<div class="flex justify-center items-center">
                            <a class="btn btn-warning shadow-md flex items-center mr-3 edit_btn" href="'.$url.'"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                          
                            <button type="button" class="btn btn-danger shadow-md flex items-center delete_btnn" data-url="'.$delurl.'" data-id="'.$row->id.'" data-token="'. csrf_token().'">  Delete </button>      
                             </div>';

                             $rowData->pdf = ' <a class="btn btn-success shadow-md flex items-center mr-3 edit_btn" href="' . $pdf . '" target="_blank"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> PDF </a>';
                        
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

    public function create()
    {
		return view('test.create',['context' => $this]);
    }

    public function store(Request $request)
    {
        //
		try {
			 $validatedData = $request->validate([

			]);
			
            $test = new Test();
			$test->connected = $request->connected;
            $test->disconnected = $request->disconnected;
            $test->firmware = $request->firmware;
            $test->batteryLevel = $request->batteryLevel;
            $test->temperatureValue = $request->temperatureValue;
            $test->dateAndTimeValue = $request->dateAndTimeValue;
            $test->alertLevel = $request->alertLevel;
            $test->alertStatus = $request->alertStatus;
            $test->manufacturerName = $request->manufacturerName;
            $test->modelNumber = $request->modelNumber;
            $test->serialNumber = $request->serialNumber;
            $test->temperature = $request->temperature;
            $test->is_active = $request->is_active;
			$test->Created_by = auth()->id();
            $test->login_id = auth()->id();
			
			$test->save();
			
            return redirect()->route('test.index')->with('flash_message_success','Test created successfully.');
        }catch (\Illuminate\Validation\ValidationException $e ) {
			/**
             * Validation failed
             * Tell the end-user why
             */
            $arrError = $e->errors(); 
		
			return redirect()->back()->withInput()->withErrors($arrError);
		}catch (\Exception $e) {
           print_r($e->getFile());
           print_r($e->getLine());
            print_r($e->getMessage());exit;
            return redirect()->back()->withInput()->with('flash_message_error','Something is wrong!');
        }
		
		
    }
    
function createThumbnail($sourcePath, $targetPath, $file_type, $thumbWidth, $thumbHeight){
	
    $source = imagecreatefromjpeg($sourcePath);
	
    $width = imagesx($source);
	$height = imagesy($source);
	
	$tnumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
	
	imagecopyresampled($tnumbImage, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
	
	if (imagejpeg($tnumbImage, $targetPath, 90)) {
	    imagedestroy($tnumbImage);
		imagedestroy($source);
		return TRUE;
	} else {
		return FALSE;
	}
}	


public function resize($source,$destination,$newWidth,$newHeight)
    {
        ini_set('max_execution_time', 0);
        $ImagesDirectory = $source;
        $DestImagesDirectory = $destination;
        $NewImageWidth = $newWidth;
        $NewImageHeight = $newHeight;
        $Quality = 100;
        $imagePath = $ImagesDirectory;
        $destPath = $DestImagesDirectory;
        $checkValidImage = getimagesize($imagePath);
        if(file_exists($imagePath) && $checkValidImage)
        {
            if($this->resizeImage($imagePath,$destPath,$NewImageWidth,$NewImageHeight,$Quality))
            return true;
            else
            return false;
        }
    }



    public function resizeImage($SrcImage,$DestImage, $thumb_width,$thumb_height,$Quality)
    {
     
        list($width,$height,$type) = getimagesize($SrcImage);
        switch(strtolower(image_type_to_mime_type($type)))
        {
            case 'image/gif':
                $NewImage = imagecreatefromgif($SrcImage);
                break;
            case 'image/png':
                $NewImage = imagecreatefrompng($SrcImage);
                break;
            case 'image/jpeg':
                $NewImage = imagecreatefromjpeg($SrcImage);
                break;
            default:
                return false;
                break;
        }
        $original_aspect = $width / $height;
        $positionwidth = 0;
        $positionheight = 0;

        if($original_aspect > 1)    {
            $new_width = $thumb_width;
            $new_height = $new_width/$original_aspect;
            while($new_height > $thumb_height) {
                $new_height = $new_height - 0.001111;
                $new_width  = $new_height * $original_aspect;
                while($new_width > $thumb_width) {
                    $new_width = $new_width - 0.001111;
                    $new_height = $new_width/$original_aspect;
                }

            }
        } else {
            $new_height = $thumb_height;
            $new_width = $new_height/$original_aspect;
            while($new_width > $thumb_width) {
                $new_width = $new_width - 0.001111;
                $new_height = $new_width/$original_aspect;
                while($new_height > $thumb_height) {
                    $new_height = $new_height - 0.001111;
                    $new_width  = $new_height * $original_aspect;
                }
            }
        }

        if($width < $new_width && $height < $new_height){
            $new_width = $width;
            $new_height = $height;
            $positionwidth = ($thumb_width - $new_width) / 2;
            $positionheight = ($thumb_height - $new_height) / 2;
        }elseif($width < $new_width && $height > $new_height){
            $new_width = $width;
            $positionwidth = ($thumb_width - $new_width) / 2;
            $positionheight = 0;
        }elseif($width > $new_width && $height < $new_height){
            $new_height = $height;
            $positionwidth = 0;
            $positionheight = ($thumb_height - $new_height) / 2;
        } elseif($width > $new_width && $height > $new_height){
            if($new_width < $thumb_width) {
                $positionwidth = ($thumb_width - $new_width) / 2;
            } elseif($new_height < $thumb_height) {
                $positionheight = ($thumb_height - $new_height) / 2;
            }
        }
        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        /********************* FOR WHITE BACKGROUND  *************************/
            $white = imagecolorallocate($thumb, 255,255,255);
            imagefill($thumb, 0, 0, $white);

        if(imagecopyresampled($thumb, $NewImage,$positionwidth, $positionheight,0, 0, $new_width, $new_height, $width, $height)) {
            if(imagejpeg($thumb,$DestImage,$Quality)) {
                imagedestroy($thumb);
                return true;
            }
        }
    }

    public function show($id)
    {
        $id = base64_decode($id);
        $category = Category::find($id);
       $category_list = Category::where('id',$id)->where('is_delete','0')->get();

        return view('category.view',['context' => $this],compact('category','category_list'));


    }

    public function edit(Request $request,$id)
    {
        $id = base64_decode($id);
		$test = Test::find($id);
		return view('test.edit',['context' => $this],compact('test'));
    }

    public function update(Request $request,$id)
    {
    
		try {
			 $validatedData = $request->validate([
				
			]);
			
            $test->login_id = auth()->id();
            $test->connected = $request->connected;
            $test->disconnected = $request->disconnected;
            $test->firmware = $request->firmware;
            $test->batteryLevel = $request->batteryLevel;
            $test->temperatureValue = $request->temperatureValue;
            $test->dateAndTimeValue = $request->dateAndTimeValue;
            $test->alertLevel = $request->alertLevel;
            $test->alertStatus = $request->alertStatus;
            $test->manufacturerName = $request->manufacturerName;        
            $test->modelNumber = $request->modelNumber;
            $test->serialNumber = $request->serialNumber;
            $test->temperature = $request->temperature;
            $test->is_active = $request->is_active;
            $test->Created_by = auth()->id();
            
	 
			$test->save();
			
            return redirect()->route('test.index')->with('flash_message_success','test Updated successfully.');
        }catch (\Illuminate\Validation\ValidationException $e ) {
			/**
             * Validation failed
             * Tell the end-user why
             */
            $arrError = $e->errors(); // Useful method - thank you Laravel
			return redirect()->back()->withErrors($arrError);
		}catch (\Exception $e) {
           print_r($e->getFile());
           print_r($e->getLine());
            print_r($e->getMessage());exit;
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
		
		
    }

    public function destroy($id)
    {
        try {
			$test = Test::find($id);
            $test->is_delete = 1;
            $test->save();
			return redirect()->back()->with('flash_message_success','Test Deleted Successfully');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
    }


}//end of controller
