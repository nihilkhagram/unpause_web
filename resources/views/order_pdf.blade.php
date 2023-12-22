<!DOCTYPE html>
<html>
    <head>
        <style>
            
            p{
                color: #000;;
                font-size:14px;
            }
            hr{
                color:#636363;
            }
            tr{
                height:10px !important;
            }
            .white{
                color:#fff;
                margin:3px !important;
            }
            .bold{
                /* color:#636363; */
                font-size:16px;
                font-weight:300;
            }
            .main{
                width:100%;
            }
            .header{
                background:#000;
                height: 20px !important;
            }
            .section{
                margin:10px;
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
    </head>
    <body>
        <div class="main">
            <div class="section">
                <div class="address">
                    <table width="100%" >
                        <tr>
                        <td width="30%">
                    <div class="logo">
                        <img src="{{asset('logo/unpause.png')}}" height="50px"/>
                    </div>
                        </td>
                        <td width="30%"></td>
                        <td width="30%">
                    <div>
                        <p><bold>Unpause</bold><br>
                        Ahead Studio, 9th floor, Becket House,<br>
                        1 Lambeth Palace Road, London, SE 7EU</p>
                    </div>
                        </td>
                        </tr>
                    </table>
                </div>
                <div class="details">
                <h2>INVOICE</h2>

                <table class="table">  
                <tr> 
                <td style="width:25%">
                    {{$user->first_name . $user->last_name }}<br>
                    {{$address->apartment }}<br>
                    {{$address->address }}<br>
                    {{$address->city }}<br>
                    {{$address->region }}<br>
                    {{$address->zipcode }}<br>
                    {{$user->phone_number }}<br>
                    {{$user->mobile_no }}<br>
                </td>
                <td style="width:25%">
                    Ship To:<br>
                    {{$user->first_name . $user->last_name }}<br>
                    {{$address->apartment }}<br>
                    {{$address->address }}<br>
                    {{$address->city }}<br>
                    {{$address->region }}<br>
                    {{$address->zipcode }}<br>
                    {{$user->phone_number }}<br>
                    {{$user->mobile_no }}<br>
                </td>
                <td style="width:25%">
                        <p>Invoice Number:</p>
                        <p>Invoice Date:</p>
                        <p>Order Number:</p>
                        <p>Order Date:</p>
                        <p>Payment Method:</p>
                    
                </td>
                <td style="width:25%">
                <p>{{$id}}</p>
                        <p>{{date('M d,Y',strtotime($created_at))}}</p>
                        <p>{{$id}}</p>
                        <p>{{date('M d,Y',strtotime($created_at))}}</p>
                        <p>{{$payment_method}}</p>
                </td>
                </tr>
                </table>
                <br><br>
                <table class="table">
                    <tr class="header">
                        <td><h4 class="white"><bold>Product</bold></h4></td>
                        <td><h4  class="white"><bold>Quantity</bold></h4></td>
                        <td><h4  class="white"><bold>Price</bold></h4></td>
                    </tr>
                    @foreach($order_items as $items)
                    <tr>
                        <td style="width:60% !important">
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
                </table>
                    
                    <div>   <hr>
                    <p class="bold">Subtotal </p>
                    £ {{$subtotal}}
                    </div>
                    <div style="width:60% !important"></div>
                    <div>   <hr>
                    <p class="bold">Delivery Charge
                    £ {{$delivery_charge}}</p>
                    </div>
                    <div style="width:60% !important"></div>
                    <div>   <hr>
                    <p class="bold">Shipping
                    10% On subtotal</p>
                    </div>
                    <div style="width:60% !important"></div>
                    <div>   <hr>
                    <p class="bold">Total
                    £ {{$total_amount}}</p>
                    </div>
                    <div> 
                    
                </div>
            </div>
        </div>    
    </body>
</html>        