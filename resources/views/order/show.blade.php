@include('header')
@include('sidebarnew')

<?php 
$baseurl = URL::to('/');
$order_items = \App\Cart::where('order_id',$order->id)->get();
$address = \App\ShippingAddress::where('id',$order->address_id)->first();
$user = \App\User::where('id',$order->user_id)->first();

?>
<style>
        p{
                color:#636363;
                font-size:14px;
            }
            .white{
                color:#fff;
            }
            .bold{
                color:#636363;
                font-size:18px;
                font-weight:bold;
            }
            .bold-p{
                font-size:16px;
            }
            .main{
                width:100%;
            }
            .header{
                background:#000;
            }
            .section{
                margin:20px;
            }
            h3{
               color:#d3354a; 
            }
           
            .table{
                /* border:1px solid #9e9e9ea3; */
                width:100%;
            }
            .address{
                display: flex;
    /* justify-content: space-between; */

            }
</style>
<!-- BEGIN: Content -->
            <div class="content" >
                <!-- BEGIN: Top Bar -->
                @include('topbar')
                
                <table class="table" id="sample_3">  
                <tr> 
                <td width="50%">
                    <p class="bold">Shipping Details:</p>
                   <p class="bold-p"> {{$user->first_name . $user->last_name }}<br></p>
                    <p class="bold-p">{{$address->apartment }},
                    {{$address->address }},
                    {{$address->city }}</p>
                    <p class="bold-p">{{$address->region }}</p>
                    <p class="bold-p">{{$address->zipcode }}</p>
                    <p class="bold-p">{{$user->phone_number }}</p>
                    <p class="bold-p">{{$user->mobile_no }}</p>
                </td>
                <td width="50%">
                <p class="bold-p">Invoice Number:{{$order->id}}</p><br>
                <p class="bold-p">Invoice Date:{{date('M d,Y',strtotime($order->created_at))}}</p><br>
                <p class="bold-p">Order Number:{{$order->id}}</p><br>
                <p class="bold-p">Order Date:{{date('M d,Y',strtotime($order->created_at))}}</p><br>
                        <p class="bold-p">Payment Method:{{$order->payment_method}}</p><br>
                    
                </td>
                </tr>
                </table>
                <br><br>
                <table  class="table table--sm" id="sample_3">
                    <tr class="header">
                        <td><h4 class="white"><bold>Product</bold></h4></td>
                        <td><h4  class="white"><bold>Quantity</bold></h4></td>
                        <td><h4  class="white"><bold>Price</bold></h4></td>
                    </tr>
                    @foreach($order_items as $items)
                    <tr>
                        <td>
                            @php
                                $productdetail = \App\ProductDetail::where('id',$items->product_detail_id)->first();
                                $product = \App\Product::where('id',$productdetail->product_id)->first();
                            @endphp
                            {{$product->name}}
                            <br>
                            @if($product->type == 'strip')
                            {{$productdetail->description}}
                            @endif
                        </td>
                        <td>{{$items->quantity}}</td>
                        <td>£ {{$items->amount}}</td>
                    </tr>            
                    @endforeach
                    <tr><td></td><td><p class="bold">Subtotal</td><td>£ {{$order->subtotal}}</td></tr>        
                    <tr><td></td><td><p class="bold">Tax</td><td>£ {{$order->tax}}</td></tr>        
                    <tr><td></td><td><p class="bold">Delivery Charge</td><td>£ {{$order->delivery_charge}}</td></tr>        
                    @if($order->discount != NULL)
                    <tr><td></td><td><p class="bold">Shipping</td><td>£ {{$order->discount}}</td></tr>    
                    @endif    
                    <tr><td></td><td><p class="bold">Total</td><td>£ {{$order->total_amount}}</td></tr>        
                    <tr></tr>        
                </table>
            </div>
<!-- END: Content -->
@include('footer')
