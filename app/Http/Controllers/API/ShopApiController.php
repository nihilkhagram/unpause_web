<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use App\{Product,ProductDetail,ProductReview,Cart,ShippingAddress,Promocode,Order,User,OrderItems,SiteSetting,RefundRequest};
use Illuminate\Support\Facades\Validator;
use DB; 
use PDF;

class ShopApiController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function product_list(Request $request)
    {
        try {


            $data = Product::orderby('id', 'DESC');
            
            if(isset($request->search))
            {
            $data = $data->where('name','like','%'.$request->search.'%');
            }
            $data = $data->get();    
           
            $response['result'] = true;
            $response['message'] = "Product list fetched successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function product_detail(Request $request)
    {
        try {

            $url = explode('/',$request->url());
            $route = end($url);

            if($route == 'product_detail')
            {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:s_product',
            ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'color' => 'required|exists:s_product_detail',
                ]);
            }

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            
            if($route == 'product_detail')
            {
            $id = $request->id;

            $data = Product::where('id',$request->id)->first();   

            $details =ProductDetail::where('product_id',$id)->get();
            }else
            {
                $color = $request->color;
                $cd = ProductDetail::where('color',$color)->first();

                $id = $cd->product_id;

                $data = Product::where('id',$id)->first();   

                $details =ProductDetail::where('color',$color)->first();
                $details->name = $data->name;
            }
            


            foreach($details as $k=>$row)
            {
                if($data->type == 'strip')
                {
                $des = explode(',',$row->description);
                
                $details[$k]->desc1 = isset($des[0])?$des[0]:'';
                $details[$k]->desc2 = isset($des[1])?$des[1]:'';
                }
                if($route == 'product_detail'){
                $details[$k]->name = $data->name;
                }else{
                    $details->name = $data->name;
                }
            }
            $data->details = $details;
            $data->review = ProductReview::join('users','users.id','=','s_product_review.user_id','left')
            ->select(DB::raw('DATE_FORMAT(s_product_review.created_at, "%d %b,%Y") as review_date'),'s_product_review.*','users.first_name','users.last_name')->where('product_id',$id)->get();
            
            
           
            $response['result'] = true;
            $response['message'] = "Product detail fetched successfully";
            if($route == 'product_detail')
            {
            $response['data'] =  $data;
            }else
            {
                $response['data'] =  $details;
            }

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function add_cart(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'detail_id' => 'required',
                'qunatity' => 'required|min:1',                
                'amount' => 'required',                
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            
            $id = $request->detail_id;
            $qunatity = $request->qunatity;
            $amount = $request->amount;
            $user_id = Auth::user()->id;

            $check = Cart::where('user_id',$user_id)->where('product_detail_id',$id)->where('is_cart',1)->where('order_id',NULL)->get()->count();
            
            if($check == 0)
            {
                $add = new Cart;
                $add->product_detail_id = $id;
                $add->quantity = $qunatity;
                $add->amount = $amount;
                $add->user_id = $user_id;
                $add->is_cart = 1;
                $add->save();
                $add_id = $add->id;
            }else
            {
                $add = Cart::where('user_id',$user_id)->where('product_detail_id',$id)->where('is_cart',1)->where('order_id',NULL)->first();
                $add->product_detail_id = $id;
                $add->quantity = $qunatity;
                $add->amount = $amount;
                $add->user_id = $user_id;
                $add->is_cart = 1;
                $add->save();
                $add_id = $add->id;
            }    
            $data = Cart::where('id',$add_id)->first();   

            
            
           
            $response['result'] = true;
            $response['message'] = "Cart item added successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function remove_cart(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:s_cart',              
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            
            $id = $request->id;
           
            $delete = Cart::where('id',$id)->delete();
           
            $response['result'] = true;
            $response['message'] = "Cart item removed successfully";

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function cart_list(Request $request)
    {
        try {

            
            $user_id = Auth::user()->id;
           
            $data = Cart::where('user_id',$user_id)->where('is_cart',1)->get();

            $count = Cart::where('user_id',$user_id)->where('is_cart',1)->get()->count();
           
            if(!empty($data))
            {
                $i = 0;
                foreach($data as $k=> $row)
                {
                    $i++;
                    $product_detail = ProductDetail::join('s_product','s_product.id','=','s_product_detail.product_id')->where('s_product_detail.id',$row->product_detail_id)->select('s_product_detail.image as image','s_product.name as name','s_product.price as product_amount')->first();

                    $tm = Cart::select(DB::RAW('SUM(amount) as total_amount'))->where('is_cart',1)->where('user_id',$user_id)->get();
                    $data[$k]->product_name = isset($product_detail->name)?$product_detail->name:'';
                    $data[$k]->image = isset($product_detail->image)?$product_detail->image:'';
                    $data[$k]->product_amount = isset($product_detail->product_amount)?$product_detail->product_amount:'';
                    if($count == 1)
                    {
                    $data[$k]->total_amount = $tm[0]->total_amount;
                    }
                }

                
            }
            $response['result'] = true;
            $response['message'] = "Cart item fetched successfully";
            $response['data'] = $data;
            $tm = Cart::select(DB::RAW('SUM(amount) as total_amount'))->where('is_cart',1)->where('user_id',$user_id)->get();
            $response['total_amount'] = $tm[0]->total_amount;   
            $ac = ShippingAddress::where('user_id',$user_id)->get()->count();
            if($ac > 0)
            {
                $response['isAddress'] = true;
            }else{
                $response['isAddress'] = false;
            }

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function add_shipping_address(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'address' => 'required',
                'apartment' => 'required',                
                'city' => 'required',                
                'region' => 'required',                
                'zipcode' => 'required',    
                'country_code'=>'required',            
                'phone_number' => 'required',                
                'type' => 'required',                
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            
            $add = new ShippingAddress;
            $add->address = $request->address;
            $add->apartment = $request->apartment;
            $add->city = $request->city;
            $add->region = $request->region;
            $add->zipcode = $request->zipcode;
            $add->country_code = $request->country_code;
            $add->phone_number = $request->phone_number;
            $add->type = $request->type;
            $add->user_id = Auth::user()->id;
            $add->save();
            $add_id = $add->id;
            
            $data = ShippingAddress::where('id',$add_id)->first();   

            $response['result'] = true;
            $response['message'] = "Address added successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function edit_shipping_address(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:s_shipping_address',
                'address' => 'required',
                'apartment' => 'required',                
                'city' => 'required',                
                'region' => 'required',                
                'country_code' => 'required',                
                'zipcode' => 'required',                
                'phone_number' => 'required',                
                'type' => 'required',                
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            
            $add =  ShippingAddress::find($request->id);
            $add->address = $request->address;
            $add->apartment = $request->apartment;
            $add->city = $request->city;
            $add->region = $request->region;
            $add->zipcode = $request->zipcode;
            $add->country_code = $request->country_code;
            $add->phone_number = $request->phone_number;
            $add->type = $request->type;
            $add->user_id = Auth::user()->id;
            $add->save();
            $add_id = $add->id;
            
            $data = ShippingAddress::where('id',$add_id)->first();   

            $response['result'] = true;
            $response['message'] = "Address updated successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function shipping_address_list(Request $request)
    {
        try {
            $data = ShippingAddress::where('user_id',Auth::user()->id)->get(); 
            foreach($data as $k=>$row) 
            {
                if($row->type == 'home')
                {
                    $data[$k]->type_image = 'images/product/home.png';
                }else if($row->type == 'office')
                {
                    $data[$k]->type_image = 'images/product/office.png';
                }else if($row->type == 'other')
                {
                    $data[$k]->type_image = 'images/product/other.png';
                }
            } 
            $response['result'] = true;
            $response['message'] = "Address list fetched successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function apply_promocode(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'promocode' => 'required|exists:s_promocode',
                
            ]);

            if ($validator->fails()) {
                //return $this->sendError($validator->errors());
                $response['result'] = false;
            $response['message'] = "The selected promocode is invalid.";
            $response['data'] =  [];

            return $this->sendResponse($response);
            }
            
            // $promocode = $request->promocode;
            // $amount = $request->amount;
            
            // $promo = Promocode::where('promocode',$promocode)->first();
            // $value = $promo->value;
            // if($promo->type == 'percent')
            // {
            //     $damount = ($amount * $value) / 100;
            // }
            // if($promo->type == 'amount')
            // {
            //     $damount = $value;
            // }
            
            // $data['amount'] = $amount;
            // $data['discount'] = $damount;
            // $data['discounted_amount'] =$amount - $damount;
            // $data['promocode'] = $promocode;
           
            $setting = SiteSetting::find(1);
            $user_id = Auth::user()->id;
            
            $oids = OrderItems::where('user_id',$user_id)->pluck('cart_id');
            
            $tm = Cart::select(DB::RAW('SUM(amount) as total_amount'))->whereIn('id',$oids)->get();

            $sub_total = round($tm[0]->total_amount,2);   
            $tax = ($tm[0]->total_amount * $setting->tax_per)/100;   
            $delivery_fee = $setting->delivery_fee;

            $total_amount = $sub_total + $tax + $delivery_fee;

            $data['sub_total'] =$sub_total;
            $data['tax'] = round($tax,2);
            $data['delivery_fee'] = $delivery_fee;

            $total_amount = round($total_amount,2);

            $data['total_amount'] = $total_amount;

            $promocode = $request->promocode;
            $amount = $total_amount;
            
            $promo = Promocode::where('promocode',$promocode)->first();
            $value = $promo->value;
            if($promo->type == 'percent')
            {
                $damount = ($amount * $value) / 100;
            }
            if($promo->type == 'amount')
            {
                $damount = $value;
            }

            $tm = Cart::whereIn('id',$oids)->update(['promocode'=>$promocode]);

            $data['discount'] = $damount;
            $data['discounted_amount'] =$amount - $damount;
            $data['promocode'] = $promocode;
            $cart = Cart::where('is_cart',1)->where('user_id',$user_id)->first();
            $address_id = isset($cart->address_id)?$cart->address_id:'';
            if($address_id == '')
            {
               $add =  ShippingAddress::where('user_id',$user_id)->orderby('id','DESC')->get()->first();
               $address_id = isset($add->id)?$add->id:'';

            }
            $address = ShippingAddress::where('id',$address_id)->first();
            $data['address'] = $address;

           
           
            $response['result'] = true;
            $response['message'] = "Promocode applied successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function add_order(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'tax' => 'required',
                'delivery_charge' => 'required',
                'total_amount' => 'required',
                'address_id' => 'required',                
                'transaction_id' => 'required',                
                'payment_method' => 'required', 
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            
            $user_id = Auth::user()->id;
            
            $oids  = OrderItems::where('user_id',$user_id)->pluck('cart_id');
            
            $sub_total = Cart::select(DB::RAW('SUM(amount) as total_amount'))->whereIn('id',$oids)->get();
            
            $add = new Order;
            $add->promocode = $request->promocode;
            $add->tax = $request->tax;
            $add->delivery_charge = $request->delivery_charge;
            $add->discount = $request->discount;
            $add->total_amount = $request->total_amount;
            $add->address_id = $request->address_id;
            $add->transaction_id = $request->transaction_id;
            $add->payment_method = $request->payment_method;
            $add->user_id = $user_id;
            $add->subtotal = $sub_total[0]->total_amount;
            $add->shipping = "shipping charge £ 1.99";
            $add->save();
            $add_id = $add->id;
            
            $oids  = OrderItems::where('user_id',$user_id)->pluck('cart_id');

            Cart::where('user_id',$user_id)->whereIn('id',$oids)->update(['is_cart'=>0,'order_id'=>$add_id]);

            $cart = Cart::where('user_id',$user_id)->where('is_cart',0)->where('order_id',$add_id)->get();

            $data = Order::find($add_id);  
            
            $data->order_items = Cart::select('*')->where('is_cart',0)->where('order_id',$add_id)->where('user_id',$user_id)->get();
            
            OrderItems::where('user_id',$user_id)->whereIn('cart_id',$oids)->delete();

            $this->send_email($add_id);

            $response['result'] = true;
            $response['message'] = "Order added successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function order_list(Request $request)
    {
        try {

            $user_id = Auth::user()->id;
            $data = Order::where('user_id',$user_id);
            if(isset($request->search) && $request->search != '')
            {
                $search = $request->search;
                $data = $data->where('id','like','%'.$search.'%');
            }
            $data = $data->orderby('id','DESC')->get();
            
           
            if(!empty($data))
            {
                foreach($data as $k=> $row)
                {
                    $user = User::where('id',$row->user_id)->first();

                    $cart_items = Cart::where('is_cart',0)->where('order_id',$row->id)->where('user_id',$user_id)->get();
                    foreach($cart_items as $key=>$ri)
                    {
                        $product_detail = ProductDetail::
                                    join('s_product','s_product.id','=','s_product_detail.product_id')->where('s_product_detail.id',$ri->product_detail_id)->
                                        select('s_product.name as pname','s_product.price as price',
                                        's_product.description as pdescription','s_product_detail.price as pd_price','s_product.image as image','s_product_detail.image as pimage','s_product_detail.description as ppdescription')->first();
                        $cart_items[$key]->product_name = isset($product_detail->pname)?$product_detail->pname:'';
                        $cart_items[$key]->description = isset($product_detail->pdescription)?$product_detail->pdescription:'';
                        $cart_items[$key]->detail_description = isset($product_detail->ppdescription)?$product_detail->ppdescription:'';
                        $cart_items[$key]->image = isset($product_detail->image)?$product_detail->image:'';
                        $cart_items[$key]->detail_image = isset($product_detail->pimage)?$product_detail->pimage:'';
                        $cart_items[$key]->price = isset($product_detail->price)?$product_detail->price:'';
                        $cart_items[$key]->pd_price = isset($product_detail->pd_price)?$product_detail->pd_price:'';
                        $data[$k]->product_name = isset($product_detail->pname)?$product_detail->pname:'';
                        $data[$k]->description = isset($product_detail->pdescription)?$product_detail->pdescription:'';
                        $data[$k]->detail_description = isset($product_detail->ppdescription)?$product_detail->ppdescription:'';
                        $data[$k]->image = isset($product_detail->image)?$product_detail->image:'';
                        $data[$k]->detail_image = isset($product_detail->pimage)?$product_detail->pimage:'';
                        $data[$k]->price = isset($product_detail->price)?$product_detail->price:'';
                        $data[$k]->detail_price = isset($product_detail->pd_price)?$product_detail->pd_price:'';
                    }
                   
                    $data[$k]->order_items = $cart_items;
                    $data[$k]->full_name = isset($user->first_name)?$user->first_name .' '. $user->last_name:'';
                }
                
            }
            $response['result'] = true;
            $response['message'] = "Order item fetched successfully";
            $response['data'] = $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function add_review(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
                'rating' => 'required',
                
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            $user_id = Auth::user()->id;
            $add = new ProductReview;
            $add->user_id = $user_id;
            $add->rating = $request->rating;
            $add->review = $request->review;
            $add->save();
            $add_id = $add->id;
            
            $data = ProductReview::where('id',$add_id)->first();  
            

            $response['result'] = true;
            $response['message'] = "Review added successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }

    public function cart_detail(Request $request)
    {
        try {

            $setting = SiteSetting::find(1);
            $user_id = Auth::user()->id;
            $tm = Cart::select(DB::RAW('SUM(amount) as total_amount'))->where('is_cart',1)->where('user_id',$user_id)->get();

            $sub_total = round($tm[0]->total_amount,2);   
            $tax = ($tm[0]->total_amount * $setting->tax_per)/100;   
            $delivery_fee = $setting->delivery_fee;

            $total_amount = $sub_total + $tax + $delivery_fee;

            $data['sub_total'] =$sub_total;
            $data['tax'] = round($tax,2);
            $data['delivery_fee'] = $delivery_fee;

            $data['total_amount'] = number_format($total_amount,2);

            $cart = Cart::where('is_cart',1)->where('user_id',$user_id)->first();
            $address_id = isset($cart->address_id)?$cart->address_id:'';
            if($address_id == '')
            {
               $add =  ShippingAddress::where('user_id',$user_id)->orderby('id','DESC')->get()->first();
               $address_id = $add->id;

            }
            $address = ShippingAddress::where('id',$address_id)->first();
            $data['address'] = $address;

            $response['result'] = true;
            $response['message'] = "Cart detail fetched successfully";
            $response['data'] =  $data;

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    
    public function add_cart_address(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'address_id' => 'required',
                
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }
            

            $user_id = Auth::user()->id;
             Cart::where('is_cart',1)->where('user_id',$user_id)->update(['address_id'=>$request->address_id]);

            
            $response['result'] = true;
            $response['message'] = "Order address added successfully";

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function generate_customer($user)
    {

        //client secret
        $url = 'https://api.stripe.com/v1/customers';

        //test
        $token  = "sk_test_51NslnHJ0HCWXlxktNBMlRAnj3iggCslRXkCFTmlEz2BObZb5S6aYjAMqQr2o7WMXapmYjd3ewm6xPzSlkpgDfHs800nKh5pmTP";

        //live
        //$token = "sk_test_51NslnHJ0HCWXlxktNBMlRAnj3iggCslRXkCFTmlEz2BObZb5S6aYjAMqQr2o7WMXapmYjd3ewm6xPzSlkpgDfHs800nKh5pmTP";
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $post['name'] = isset($user->first_name) ? $user->first_name . ' '.$user->last_name : '';
        $post['phone'] = isset($user->phone_number) ? $user->phone_number : '';
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $result = curl_exec($ch);

        $errormsg = curl_error($ch);

        curl_close($ch);

        $data = json_decode($result, true);

        return $data['id'];

        
    }

    public function generate_ephemeral($amount)
    {
        //test
        $token  = "sk_test_51NslnHJ0HCWXlxktNBMlRAnj3iggCslRXkCFTmlEz2BObZb5S6aYjAMqQr2o7WMXapmYjd3ewm6xPzSlkpgDfHs800nKh5pmTP";

        //live
        //$token = "sk_test_51NslnHJ0HCWXlxktNBMlRAnj3iggCslRXkCFTmlEz2BObZb5S6aYjAMqQr2o7WMXapmYjd3ewm6xPzSlkpgDfHs800nKh5pmTP";

        $user = User::where('id',Auth::user()->id)->first();

        $customer = $this->generate_customer($user);

        /* EPHEMERAL KEY */

        $url = 'https://api.stripe.com/v1/ephemeral_keys';

        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token,
            'Stripe-Version: 2023-10-16'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $post['customer'] = $customer;

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $result = curl_exec($ch);

        $errormsg = curl_error($ch);

        curl_close($ch);

        $edata = json_decode($result, true);


        /* PAYMENT INTENT */

        $url = 'https://api.stripe.com/v1/payment_intents';

        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $post['customer'] = $customer;
        $post['amount'] = round($amount);
        $post['currency'] = 'GBP';
        //$post['transaction_id'] = time();
        $enabled['enabled'] = 'true';
        $post['automatic_payment_methods'] = $enabled;

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $result = curl_exec($ch);

        $errormsg = curl_error($ch);

        curl_close($ch);

        $idata = json_decode($result, true);


        $response = array('paymentIntent' => $idata['client_secret'],
                        'ephemeralKey' => $edata['id'],
                        'transaction_id' => $idata['id'],
                        'ephemeralKeySecret' => $edata['secret'],
                        'customer' => $customer,
                        'publishableKey' => 'pk_test_51NslnHJ0HCWXlxkt2SjdXc52TsXXNFOtmmnC0UvVnYAj7etlVRXAuJwhi9RjGeJueTmRzRmwllE1XiGRJlyLGgSI00smTuEzkL');

        return array("success" => true, "message" => "Keys generated successfully", "data" => (object) $response);
    }

    public function stripe_payment(Request $request)
    {
      $amount = $request->amount;  
      return  $this->generate_ephemeral($amount);
    }

    public function cart_product_detail(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'cart_id' => 'required',
               ]);
    
    
            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $setting = SiteSetting::find(1);
            $user_id = Auth::user()->id;
            $cart_id = $request->cart_id;
            $check = OrderItems::where('user_id',$user_id)->where('cart_id',$cart_id)->get()->count();

            if($check > 0)
            {
                OrderItems::where('user_id',$user_id)->where('cart_id',$cart_id)->delete();
            }
            else{
                OrderItems::create(array('user_id'=>$user_id,'cart_id'=>$cart_id));
            }
            
            $oids = OrderItems::where('user_id',$user_id)->pluck('cart_id');
            
            $tm = Cart::select(DB::RAW('SUM(amount) as total_amount'),'promocode')->whereIn('id',$oids)->get();

            $sub_total = round($tm[0]->total_amount,2);   
            $tax = ($tm[0]->total_amount * $setting->tax_per)/100;   
            $delivery_fee = $setting->delivery_fee;

            $total_amount = $sub_total + $tax + $delivery_fee;

            $promocode = isset($tm[0]->promocode)?$tm[0]->promocode:'';

            $amount = round($total_amount,2);

            if($promocode != '')
            {
            $promo = Promocode::where('promocode',$promocode)->first();
            $value = $promo->value;

            if($promo->type == 'percent')
            {
                $damount = ($amount * $value) / 100;
            }
            if($promo->type == 'amount')
            {
                $damount = $value;
            }
            $data['discount'] = $damount;
            $data['discounted_amount'] =$amount - $damount;
            $data['promocode'] = $promocode;

            
            }else
            {
                $data['discount'] = 0;
                $data['discounted_amount'] =$amount;
                $data['promocode'] = $promocode;

            }
            $data['sub_total'] =$sub_total;
            $data['tax'] = round($tax,2);
            $data['delivery_fee'] = $delivery_fee;
            $data['total_amount'] = round($total_amount,2);
            
            $cart = Cart::where('is_cart',1)->where('user_id',$user_id)->first();
            $address_id = isset($cart->address_id)?$cart->address_id:'';
            if($address_id == '')
            {
               $add =  ShippingAddress::where('user_id',$user_id)->orderby('id','DESC')->get()->first();
               $address_id = isset($add->id)?$add->id:'';

            }
            $address = ShippingAddress::where('id',$address_id)->first();
            $data['address'] = $address;

           
            $response['result'] = true;
            $response['message'] = "Product detail fetched successfully";
            $response['data'] =  $data;
        

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function cart_count(Request $request)
    {
        try {

          
            $user_id = Auth::user()->id;
            $count = Cart::where('user_id',$user_id)->where('is_cart',1)->get()->count();

            $data['count'] = $count;
           
           
            $response['result'] = true;
            $response['message'] = "Total cart items";
            $response['data'] =  $data;
        

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }   

    public function send_email($id)
    {
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
           
            $data = Order::where('id',$id)->first();

           
            if(!empty($data))
            {
                $cart_items = Cart::where('is_cart',0)->where('order_id',$data->id)->get();
                $data->order_items = $cart_items;
                $data->user = User::where('id',$data->user_id)->first();
                $data->address = ShippingAddress::where('id',$data->address_id)->first();
            }
        $filename = 'order_pdf_1.pdf';
        $pdf = PDF::loadView('order_pdf',$data);
        $path = public_path().'/pdf/';
        $pdf->save($path.$filename);

        $edata['data'] = $data;


    
        $path = public_path('/pdf/order_pdf_1.pdf');
        $emails = [$email];
        \Mail::send('emails.order_email', $edata, function($message) use ($emails, $path)
        {
            $message->to($emails)->subject('Order Placed email');
            $message->attach($path,[
                'as' => 'Invoice.pdf',
                'mime' => 'application/pdf',
            ]);
        });
    }

    public function dashboard(Request $request)
    {
        try{
            $user_id = Auth::user()->id;
        $data['orders'] = Order::where('user_id',$user_id)->get()->count();
        $data['address'] = ShippingAddress::where('user_id',$user_id)->get()->count();
        $data['refund_request'] = RefundRequest::where('user_id',$user_id)->get()->count();

        $response['result'] = true;
        $response['message'] = "Dashboard counts";
        $response['data'] =  $data;

        return $this->sendResponse($response);
        

        }catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function primary_address(Request $request)
    {
        try{
            // $validator = Validator::make($request->all(), [
            //     'id' => 'required|exists:s_order',
            //    ]);
    
    
            // if ($validator->fails()) {
            //     return $this->sendError($validator->errors());
            // }
        $user_id = Auth::user()->id;
        $data['shipping_address'] = ShippingAddress::where('user_id',$user_id)->orderby('id','ASC')->get()->first();
        $data['billing_address'] = ShippingAddress::where('user_id',$user_id)->orderby('id','ASC')->get()->first();
        
        $response['result'] = true;
        $response['message'] = "Primary address";
        $response['data'] =  $data;

        return $this->sendResponse($response);
    }catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
    }
    public function add_refund_request(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:s_order',
           ]);


        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $user_id = Auth::user()->id;
        $add = new RefundRequest;
        $add->user_id = $user_id;
        $add->order_id = $request->id;
        $add->status = 'refund_initiated';
        $add->save();
        
        $order = Order::find($request->id);
        $order->status = 'refund_initiated';
        $order->save();

        $id = $add->id;

        $data = RefundRequest::find($id);
        $response['result'] = true;
        $response['message'] = "Refund request send successfully";

        $response['data'] =  $data;

        return $this->sendResponse($response);
        
    }
    public function order_again(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:s_order',
               ]);
    
    
            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $user_id = Auth::user()->id;
            $setting = SiteSetting::find(1);
            $order_id = $request->id;
            
            $oitems = Cart::where('order_id',$order_id)->get();

            foreach($oitems as $row)
            {
                $check = Cart::where('user_id',$user_id)->where('product_detail_id',$row->product_detail_id)->get()->count();
                if($check == 0)
                {
                    $add = new Cart;
                    $add->product_detail_id = $row->product_detail_id;
                    $add->quantity = $row->quantity;
                    $add->amount = $row->amount;
                    $add->user_id = $user_id;
                    $add->is_cart = 1;
                    $add->save();
                    $oids[] = $add->id;
                }else{
                    $add = Cart::find($row->id);
                    $add->product_detail_id = $row->product_detail_id;
                    $add->quantity = $row->quantity;
                    $add->amount = $row->amount;
                    $add->user_id = $user_id;
                    $add->is_cart = 1;
                    $add->save();
                    $oids[] = $add->id;
                }
            }
            $tm = Cart::select(DB::RAW('SUM(amount) as total_amount'))->whereIn('id',$oids)->get();

            $sub_total = round($tm[0]->total_amount,2);   
            $tax = ($tm[0]->total_amount * $setting->tax_per)/100;   
            $delivery_fee = $setting->delivery_fee;

            $total_amount = $sub_total + $tax + $delivery_fee;


            $amount = round($total_amount,2);

            $data['discount'] = 0;
            $data['discounted_amount'] =$amount;
            $data['promocode'] = '';

            
            $data['sub_total'] =$sub_total;
            $data['tax'] = round($tax,2);
            $data['delivery_fee'] = $delivery_fee;
            $data['total_amount'] = round($total_amount,2);
            
            $cart = Cart::where('is_cart',1)->where('user_id',$user_id)->first();
            $address_id = isset($cart->address_id)?$cart->address_id:'';
            if($address_id == '')
            {
               $add =  ShippingAddress::where('user_id',$user_id)->orderby('id','DESC')->get()->first();
               $address_id = isset($add->id)?$add->id:'';

            }
            $address = ShippingAddress::where('id',$address_id)->first();
            $data['address'] = $address;

           
            $response['result'] = true;
            $response['message'] = "Order again data";
            $response['data'] =  $data;
        

            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError('Something is wrong', ['error' => $e->getMessage() . ' || ON LINE NO. :' . $e->getLine() . ' || IN FILE: ' . $e->getFile()], 500);
        }
            
    }
}
