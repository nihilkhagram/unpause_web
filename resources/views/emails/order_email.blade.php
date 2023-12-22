<html>
<div>
    <div></div>
  </div>
  <style>@media screen and (max-width: 600px){#header_wrapper{padding: 27px 36px !important; font-size: 24px;}#body_content table > tbody > tr > td{padding: 10px !important;}#body_content_inner{font-size: 10px !important;}}</style>
  <div>
    <table id="outer_wrapper" style="background-color: #f7f7f7;" width="100%" bgcolor="#f7f7f7">
      <tbody>
        <tr>
          <td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. --></td>
          <td width="600">
            <div id="wrapper" dir="ltr" style="margin: 0 auto; padding: 70px 0; width: 100%; max-width: 600px; -webkit-text-size-adjust: none;">
              <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td align="center" valign="top">
                      <div id="template_header_image">
                        <p style="margin-top: 0;">
                          <img style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; max-width: 100%; margin-left: 0; margin-right: 0;" src="https://unpause.club/wp-content/uploads/2023/10/unpause-logo-small.png" alt="Unpause Menopause" border="0">
                        </p>
                      </div>
                      <table id="template_container" style="background-color: #fff; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0,0,0,.1); border-radius: 3px;" border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fff">
                        <tbody>
                          <tr>
                            <td align="center" valign="top"><!-- Header -->
                              <table id="template_header" style="background-color: #d3354a; color: #fff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; border-radius: 3px 3px 0 0;" border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#d3354a">
                                <tbody>
                                  <tr>
                                    <td id="header_wrapper" style="padding: 36px 48px; display: block;">
                                      <h1 style="font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #dc5d6e; color: #fff; background-color: inherit;">New Order: #{{$data->id}}</h1>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
  <!-- End Header -->
                            </td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"><!-- Body -->
                              <table id="template_body" border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td id="body_content" style="background-color: #fff;" valign="top" bgcolor="#fff"><!-- Content -->
                                      <table border="0" width="100%" cellspacing="0" cellpadding="20">
                                        <tbody>
                                          <tr>
                                            <td style="padding: 48px 48px 32px;" valign="top">
                                              <div id="body_content_inner" style="color: #636363; font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 14px; line-height: 150%; text-align: left;" align="left">
                                                <p style="margin: 0 0 16px;">You’ve received the following order from {{$data->user->first_name . $data->user->last_name }}:</p>
                                                <h2 style="color: #d3354a; display: block; font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">
                                                  <a class="link" href="https://unpause.club/wp-admin/admin.php?page=wc-orders&amp;action=edit&amp;id=2139" style="font-weight: normal; text-decoration: underline; color: #d3354a;">[Order #{{$data->id}}]</a> ({{date('M d, Y',strtotime($data->created_at))}})
                                                </h2>
                                                <div style="margin-bottom: 40px;">
                                                  <table class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1" width="100%" cellspacing="0" cellpadding="6">
                                                    <thead>
                                                      <tr>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" scope="col" align="left">Product</th>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" scope="col" align="left">Quantity</th>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" scope="col" align="left">Price</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data->order_items as $items)
                                                      <tr class="order_item">
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; padding: 12px; text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap: break-word;" align="left">                                                          <ul class="wc-item-meta" style="font-size: small; margin: 1em 0 0; padding: 0; list-style: none;">
                                                            <li style="margin: .5em 0 0; padding: 0;">
                                                              <strong class="wc-item-meta-label" style="float: left; margin-right: .25em; clear: both;">  @php
                                $productdetail = \App\ProductDetail::where('id',$items->product_detail_id)->first();
                                $product = \App\Product::where('id',$productdetail->product_id)->first();
                            @endphp
                            {{$product->name}}
                          </strong>
                          @if($product->type == 'strip')
                          <p style="margin: 0;"> {{$productdetail->description}}</p>
                            @endif
                                                            </li>
                                                          </ul>
                                                        </td>
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; padding: 12px; text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" align="left">{{$items->quantity}}</td>
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; padding: 12px; text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" align="left">
                                                          <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">£</span>{{$items->amount}}
                                                          </span>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                    @endforeach
                                                    <tfoot>
                                                      <tr>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left; border-top-width: 4px;" colspan="2" scope="row" align="left">Subtotal:</th>
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left; border-top-width: 4px;" align="left">
                                                          <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">£</span>{{$data->subtotal}}
                                                          </span>
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" colspan="2" scope="row" align="left">Shipping:</th>
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" align="left">10% On subtotal</td>
                                                      </tr>
                                                      <tr>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" colspan="2" scope="row" align="left">Payment method:</th>
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" align="left">{{$data->payment_method}}</td>
                                                      </tr>
                                                      <tr>
                                                        <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" colspan="2" scope="row" align="left">Total:</th>
                                                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;" align="left">
                                                          <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">£</span>{{$data->subtotal}}
                                                          </span> 
                                                          <small class="includes_tax">(includes 
                                                            <span class="woocommerce-Price-amount amount">
                                                              <span class="woocommerce-Price-currencySymbol">£</span>{{$data->total_amount}}
                                                            </span> GST)
                                                          </small> USD
                                                        </td>
                                                      </tr>
                                                    </tfoot>
                                                  </table>
                                                </div>
                                                <table id="addresses" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding: 0;" border="0" width="100%" cellspacing="0" cellpadding="0">
                                                  <tbody>
                                                    <tr>
                                                      <td style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border: 0; padding: 0;" align="left" valign="top" width="50%">
                                                        <h2 style="color: #d3354a; display: block; font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">Billing address</h2>
                                                        <address class="address" style="padding: 12px; color: #636363; border: 1px solid #e5e5e5;"> 
                                                         {{$data->user->first_name . $data->user->last_name }}<br>
                    {{$data->address->apartment }},<br>
                    {{$data->address->address }},<br>
                    {{$data->address->city }}<br>
                    {{$data->address->region }}<br>
                    {{$data->address->zipcode }}<br>
                    {{$data->user->phone_number }}<br>
                    {{$data->user->mobile_no }}<br>
                                                        </address>
                                                      </td>
                                                      <td style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding: 0;" align="left" valign="top" width="50%">
                                                        <h2 style="color: #d3354a; display: block; font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">Shipping address</h2>
                                                        <address class="address" style="padding: 12px; color: #636363; border: 1px solid #e5e5e5;">CG 
                                                        {{$data->user->first_name . $data->user->last_name }}<br>
                    {{$data->address->apartment }},<br>
                    {{$data->address->address }},<br>
                    {{$data->address->city }}<br>
                    {{$data->address->region }}<br>
                    {{$data->address->zipcode }}<br>
                    {{$data->user->phone_number }}<br>
                    {{$data->user->mobile_no }}<br>
                                                          <a href="tel:{{$data->user->mobile_no }}" style="color: #d3354a; font-weight: normal; text-decoration: underline;">{{$data->user->mobile_no }}</a>
                                                        </address>
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                                <p style="margin: 0 0 16px;">Congratulations on the sale.</p>
  Process your orders on the go. 
                                                <a href="https://woocommerce.com/mobile?blog_id=226118698&amp;utm_campaign=deeplinks_promote_app&amp;utm_medium=email&amp;utm_source=unpause.club&amp;utm_term=226118698" style="color: #d3354a; font-weight: normal; text-decoration: underline;">Get the app</a>.
                                              </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
  <!-- End Content -->
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
  <!-- End Body -->
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><!-- Footer -->
                      <table id="template_footer" border="0" width="100%" cellspacing="0" cellpadding="10">
                        <tbody>
                          <tr>
                            <td style="padding: 0; border-radius: 6px;" valign="top">
                              <table border="0" width="100%" cellspacing="0" cellpadding="10">
                                <tbody>
                                  <tr>
                                    <td id="credit" style="border-radius: 6px; border: 0; color: #8a8a8a; font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 12px; line-height: 150%; text-align: center; padding: 24px 0;" colspan="2" align="center" valign="middle">
                                      <p style="margin: 0 0 16px;">Copyright © 2023 Unpause Ru Medical. All rights reserved. 
                                        <br>
                                        <br>Powered by Creatographics
                                      </p>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
  <!-- End Footer -->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </td>
          <td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. --></td>
        </tr>
      </tbody>
    </table>
  </div>
  </html>