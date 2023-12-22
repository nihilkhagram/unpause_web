<?php

namespace App\Http\Controllers;

use App\Category;
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

class CategoryController extends Controller
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
			$this->tablename = 'category';
			$this->feildname = 'is_active';
            $this->commonservice = $commonservices;
		 //Used For Table Row Status Active/InActive
    }

    public function index()
    {
        return view('category.index',['context' => $this]);
    
    }

    public function category_filter(Request $request)
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
            
                
                $Created_by = isset($input['Created_by']) ? $input['Created_by'] : '';
                $searchQuery = " ";
                 $query_set_value="";
                 $query_set_value = "WHERE 1=1 ";
                $query_set_value .= "AND is_delete = '0'"; 
                if($searchValue != ''){
                  $query_set_value .= " AND (title like '%".$searchValue."%' )";
                }
                

                $orderBy = " order by `".$columnName."` ".$columnSortOrder;
                $orderBy .= " LIMIT ".$_POST['start']." ,".$_POST['length'];
                 $array = \DB::select("SELECT *,id AS chk FROM category $query_set_value $orderBy");

                $totalarray = \DB::select("SELECT *,id AS chk FROM category $query_set_value $orderBy");

                $dataArray = array();
                $i = 1;
                if($array != NULL){
                    foreach($array AS $key => $row){
                        
                        $rowData = new \stdClass();
							$checkboxHtml = '<td><input type="checkbox" name="selectedIds[]" value="'.$row->id.'" id="rowchk'.$row->id.'" class="form-check-input flex-none allcheksel" /></td>';
						$rowData->chk  = $checkboxHtml;
                        $rowData->id = $i;
						//$rowData->Lift_type_id = $row->Lift_type_id; 
						$rowData->category_name = $row->category_name;
						// $rowData->category_image = $row->category_image;                       
                        $rowData->category_short_info = $row->category_short_info;
                       // $parent_category_name = Category::where('id',$row->parent_id)->first();
						$rowData->category_image = $row->category_image;

                        $Created_by = User::where('id',$row->Created_by)->first();
						$rowData->Created_by = $Created_by->name;

                        $date=strtotime($row->created_at);
                        $rowData->created_at=date('d-m-Y',$date);

                        $view = View::make('statuschange', ["feildname"=>$this->feildname,"value" => $row]);
						
						/*$image_show = "show_image('".asset($row->image)."');";
                        $rowData->play= '<button onclick="'.$image_show.'" class="btn btn-circle btn-icon-only green "><i class="fa fa-image" aria-hidden="true"></i></button>';*/
						
						

						$rowData->is_active = $view->render();
						
						/* 
                        if($row->Is_active == 1)
                        {
                            $rowData->status = '<button id="checkbox_'.$row->id.'" data-id="0" onclick="change_status('.$row->id.');" class="flex items-center justify-center text-theme-9"><i id="i_'.$row->id.'" data-feather="check-square" class="w-4 h-4 mr-2"></i>Active</button>';
                        }
                        else
                        {
                            $rowData->status = '<button id="checkbox_'.$row->id.'" data-id="0" onclick="change_status('.$row->id.');" class="flex items-center justify-center text-theme-6"><i id="i_'.$row->id.'" data-feather="check-square" class="w-4 h-4 mr-2"></i>InActive</button>';
                        } */
						

                        $encodeid = base64_encode($row->id);
                        $url = URL::route('category.edit',$encodeid);//URL::to('/').'/plan/'.$encodeid.'/edit';
                        //$view_url = URL::route('banner.show',$encodeid);
                        $delurl = URL::route('category.destroy',$row->id);//URL::to('/').'/plandelete';//\


                        $rowData->action = '<div class="flex justify-center items-center">
                            <a class="btn btn-warning shadow-md flex items-center mr-3 edit_btn" href="'.$url.'"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                          
                            <button type="button" class="btn btn-danger shadow-md flex items-center delete_btnn" data-url="'.$delurl.'" data-id="'.$row->id.'" data-token="'. csrf_token().'">  Delete </button>      
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

    public function create()
    {
        $category_list = Category::where('is_active','1')->where('is_delete','0')->get()->pluck('title','id');
		return view('category.create',['context' => $this],compact('category_list'));
    }

    public function store(Request $request)
    {
        //
		try {
			 $validatedData = $request->validate([
				'category_name' => 'required',
                'category_image' =>  'sometimes|nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg',

			]);
			
            $category = new Category();
			$category->category_name = $request->category_name;
            $category->category_short_info = $request->category_short_info;
            $category->is_active = $request->is_active;

			//$banner->subtitle = $request->subtitle;
			//$banner->enable = $request->enable;
			

            //save category image
            if($request->category_image && $request->category_image != '') {
                $imageName = time().rand(0000,9999).'.'.$request->category_image->extension();
                
                $pic = 'assets/images/category_image/'.$imageName;
                $fileType = $request->category_image->extension();
                $request->category_image->move(public_path('assets/images/category_image/'), $imageName);
                $temp_path = public_path('assets/images/category_image/'.$imageName);
                $destination = public_path('assets/images/category_image/'.$imageName);
                $this->resize($temp_path,$destination,300,200);
            
                $category->category_image = $pic ;
                $category->category_image = 'assets/images/category_image/'.$imageName;
                
            }

			//$category->parent_id = $request->parent_id;
			$category->Created_by = auth()->id();
			//$category->short_description = $request->short_description;
			//$category->long_description = $request->long_description;
	 
			$category->save();
			//print_r($inserted_data);
			//exit;
            return redirect()->route('category.index')->with('flash_message_success','Category created successfully.');
        }catch (\Illuminate\Validation\ValidationException $e ) {
			/**
             * Validation failed
             * Tell the end-user why
             */
            $arrError = $e->errors(); // Useful method - thank you Laravel
		//print_r($arrError);exit;
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
        $category_list = Category::where('id','!=',$id)->where('is_active','1')->where('is_delete','0')->get()->pluck('category_name','id');
		$category = Category::find($id);
		return view('category.edit',['context' => $this],compact('category_list','category'));
    }

    public function update(Request $request,$id)
    {
    
		try {
			 $validatedData = $request->validate([
				//'title' => 'required',
                'category_image' =>  'sometimes|nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg',

			]);
			
            $category = Category::find($id);
			$category->category_name = $request->category_name;
            $category->category_short_info = $request->category_short_info;
			// $banner->subtitle = $request->subtitle;
            // $banner->enable = $request->enable;

             // delete old category image
            if($category->category_image != null && $request->category_image != null && $request->category_image != '') {
                if(file_exists(public_path().'/'.$category->category_image))
                {
                    unlink(public_path().'/'.$category->category_image);
                }
            }
            //save new category image
            if($request->category_image && $request->category_image != '') {
                $imageName = time().rand(0000,9999).'.'.$request->category_image->extension();

                $pic = 'assets/images/category_image/'.$imageName;
                $fileType = $request->category_image->extension();
                $request->category_image->move(public_path('assets/images/category_image/'), $imageName);
                $temp_path = public_path('assets/images/category_image/'.$imageName);
                $destination = public_path('assets/images/category_image/'.$imageName);
                $this->resize($temp_path,$destination,300,200);
            
                $category->category_image = $pic ;
                $category->category_image = 'assets/images/category_image/'.$imageName;
            }

			//$category->parent_id = $request->parent_id;
			$category->Created_by = auth()->id();
            $category->is_active = $request->is_active;

			/*$category->short_description = $request->short_description;
			$category->long_description = $request->long_description;*/
	 
			$category->save();
			//print_r($inserted_data);
			//exit;
            return redirect()->route('category.index')->with('flash_message_success','Category Updated successfully.');
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
            print_r($e->getMessage());exit;
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
		
		
    }

    public function destroy($id)
    {
        try {
			$category = Category::find($id);
            $category->is_delete = 1;
            $category->save();
			return redirect()->back()->with('flash_message_success','Category Deleted Successfully');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('flash_message_error','Something is wrong!');
        }
    }


}//end of controller
