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
use App\Order;
use App\Cart;
use App\Product;
use App\ProductDetail;
use App\ProductReview;
use App\ShippingAddress;
use PDF;
use DB;
class OrderController extends Controller
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
			$this->tablename = 's_order';
			$this->feildname = 'is_active';
            $this->commonservice = $commonservices;
		 //Used For Table Row Status Active/InActive
    }

    public function index()
    {
        return view('order.index',['context' => $this]);
    
    }

    public function order_filter(Request $request)
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
                if($searchValue != ''){
                  $query_set_value .= " AND (id like '%".$searchValue."%' )";
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
                 $array = \DB::select("SELECT *,id AS chk FROM s_order $query_set_value $orderBy");
                // print_r($array);
                // exit;
                 $totalarray = \DB::select("SELECT *,id AS chk FROM s_order $query_set_value $orderBy");


                $dataArray = array();
                $i = 1;
                if($array != NULL){
                    foreach($array AS $key => $row){
                        
                        $rowData = new \stdClass();
						$checkboxHtml = '<td><input type="checkbox" name="selectedIds[]" value="'.$row->id.'" id="rowchk'.$row->id.'" class="form-check-input flex-none allcheksel" /></td>';
						$rowData->chk  = $checkboxHtml;
                        $rowData->id = $i;						
						$rowData->user = '';						                   
						$rowData->subtotal = $row->subtotal;						                   
                        $rowData->tax = $row->tax;
                        $rowData->discount = $row->discount;
						$rowData->delivery_charge = $row->delivery_charge;
                         $rowData->total_amount = $row->total_amount;
                         $rowData->payment_method = $row->payment_method;
                         $rowData->promocode = $row->promocode;
                         $rowData->total_items = Cart::where('order_id',$row->id)->get()->count();
                         
                        $date=strtotime($row->created_at);
                        $rowData->created_at=date('d-m-Y',$date);

                        $view = View::make('statuschange', ["feildname"=>$this->feildname,"value" => $row]);
						
                        $encodeid = base64_encode($row->id);
                        $url = URL::route('orders.edit',$encodeid);
                        $delurl = URL::route('orders.destroy',$row->id);
                        $viewurl = URL::to('/') . '/orders/' . $encodeid;
                        $pdfurl = URL::to('/') . '/order/pdf/' . $encodeid;
                        $status_html = '<select class="form-control order_status_'.$row->id.'" onchange="statuschange('.$row->id.')">';
                        if($row->status == 'pending')
                        {
                            $status_html .= '<option value="pending" selected >Pending</option>';
                        }else
                        {
                            $status_html .= '<option value="pending">Pending</option>';
                        }
                        if($row->status == 'processing')
                        {
                            $status_html .= '<option value="processing" selected >Processing</option>';
                        }else
                        {
                            $status_html .= '<option value="processing">Processing</option>';
                        }
                        if($row->status == 'dispatched')
                        {
                            $status_html .= '<option value="dispatched" selected >Dispatched</option>';
                        }else
                        {
                            $status_html .= '<option value="dispatched">Dispatched</option>';
                        }
                        if($row->status == 'delivered')
                        {
                            $status_html .= '<option value="delivered" selected >delivered</option>';
                        }else
                        {
                            $status_html .= '<option value="delivered">Delivered</option>';
                        }
                        if($row->status == 'cancelled')
                        {
                            $status_html .= '<option value="cancelled" selected >Cancelled</option>';
                        }else
                        {
                            $status_html .= '<option value="cancelled">Cancelled</option>';
                        }
                        $status_html .=  '</select>';
                        $rowData->status = $status_html;   
                        $rowData->action = '<div class="flex justify-center items-center">
                            <a class="btn btn-warning shadow-md flex items-center mr-3" href="'.$viewurl.'"><i class="fa fa-eye"></i></a>
                           </div>';

                             $rowData->pdf = '<a class="btn btn-warning shadow-md flex items-center mr-3" href="'.$pdfurl.'" target="_blank"><i class="fas fa-file-pdf"></i></a> '; 
                        
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

  
    public function show($id)
    {
        $id = base64_decode($id);
        $order = Order::find($id);

        return view('order.show',['context' => $this],compact('order'));


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
    public function order_status(Request $request)
    {
        $new_status = $request->status;
        $update = array('status'=>$new_status);

        \DB::table('s_order')->where('id', $request->id)->update($update);
        return response()->json([
            'status' => true,
            'message' => 'success'
        ]);
    }
    public function pdf($id)
    {
        $id = base64_decode($id);
        $data = Order::find($id);
        if(!empty($data))
            {
                $cart_items = Cart::where('is_cart',0)->where('order_id',$data->id)->get();
                $data->order_items = $cart_items;
                $data->user = User::where('id',$data->user_id)->first();
                $data->address = ShippingAddress::where('id',$data->address_id)->first();
            }
           // return view('order_pdf',$data);
       $filename = 'order_pdf_'.$id.'.pdf';
       $pdf = PDF::loadView('order_pdf',$data);
       return  $pdf->stream();
    }

}//end of controller
