<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2019.
**********************************************************************************************************  -->
<!-- 
Template Name: NextClass
Version: 1.0.0
Author: Media City
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->
<html lang="en">
<!-- <![endif]-->
<!-- head -->
<!-- theme styles -->
<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
<link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<!-- google fonts -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- end theme styles -->
</head>


<!-- end head -->
<!-- body start-->
<body>
<!-- terms end-->
<!-- about-home start -->
<section id="wishlist-home" class="invoice-home-main-block ">
    <div class="container-fluid">
        <h2>Payment Receipt</h2>
    </div>
</section> 
<!-- about-home end -->
<section id="purchase-block" class="Invoice-main-block">
    <div class="container-fluid">
        <div class="panel-body">
      
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="page-header">
              @php
                  $setting = App\setting::first();
              @endphp

              <div class="download-logo">
                @if($setting['logo_type'] == 'L')

                          <img src="{{ asset('images/logo/logo_1625129576nihaws.jpg') }}" class="img-fluid">
                @else()
                    <a href="{{ url('/') }}"><b><div class="logotext">{{ $setting['project_title'] }}</div></b></a>
                @endif
              </div>
              <br>
              <small class="purchase-date">{{ __('frontstaticword.Puchasedon') }}: {{ date('jS F Y', strtotime($orders['created_at'])) }}</small>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="view-order">
            
         <table class="table table-striped">
            <thead>
              <th class="col-sm-4 invoice-col">
                From:
                  <address>
                    <strong>NIHAWS</strong><br>
                    <small>(A unit of Ginerva Global Trading Corp LLP)</small><br>
                   
                    {{ __('frontstaticword.address') }}: 15, New Giri Road, T-nagar, Chennai-600017, Tamilnadu, India<br>
                      

                    {{ __('frontstaticword.Phone') }}: 9500186186<br>
                    {{ __('frontstaticword.Email') }}: info@nihaws.com<br>
                    GST number : 33AAVFG4443J1Z2
                  </address>
               
              </th>
              <!-- /.col -->
              <th class="col-sm-4 invoice-col">
                To:
                <address>
                  <strong>{{ $orders->user['fname'] }}</strong><br>
                  {{ __('frontstaticword.address') }}: {{ $orders->user['address'] }}<br>
                    @if($orders->user->state_id == !NULL)
                      {{ $orders->user->state['name'] }},
                    @endif
                    @if($orders->user->country_id == !NULL)
                      {{ $orders->user->country['name'] }}
                    @endif
                    <br>
                  {{ __('frontstaticword.Phone') }}: {{ $orders->user['mobile'] }}<br>
                  {{ __('frontstaticword.Email') }}: {{ $orders->user['email'] }}
                </address>
              </th>
              <!-- /.col -->
              <th class="col-sm-4 invoice-col">
                <b>{{ __('frontstaticword.OrderID') }}:</b> {{ $orders['order_id'] }}<br>
                <b>{{ __('frontstaticword.TransactionID') }}:</b> {{ $orders['transaction_id'] }}<br>
                <b>{{ __('frontstaticword.PaymentMode') }}:</b> {{ $orders['payment_method'] }}<br>
                <b>{{ __('frontstaticword.Currency') }}:</b> {{ $orders['currency'] }}<br>
                <b>Offline tutor : </b>{{ $orders->offline_tutor}} <br>
                <b> No. of hours for offline tutor: </b>{{ $orders['no_hours_off'] }}<br>
                <b>Live tutor : </b>{{ $orders->online_tutor_one}} &nbsp;<br>
                <b> No. of hours for live tutor: </b>{{ $orders['no_hours'] }}<br>
                <b>Printed course materials : </b>{{ $orders->hard_course}} <br>
                <b>{{ __('frontstaticword.PaymentStatus') }}:</b> 
                @if($orders->status ==1)
                  {{ __('frontstaticword.Recieved') }}
                @else 
                  {{ __('frontstaticword.Pending') }}
                @endif
              </th>
          </thead>
      </table>
             
        </div>
        <!-- /.row -->
         @php
               $rate = $orders['total_amount']/1.18 ;
              $gst = $orders['total_amount'] - $rate;
          @endphp
        <div class="order-table table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
              @if($orders->course_id != NULL)
                <th>{{ __('frontstaticword.Courses') }}</th>
              @elseif($orders->workshop_id != NULL)
       		      <th>Workshops</th>
       		  @else
                  <th>{{ __('frontstaticword.Courses') }}</th>
              @endif
                <th>{{ __('frontstaticword.Currency') }}</th>
                @if($orders->coupon_discount != 0)
                <th class="text-center">Coupon Discount</th>
                @endif
                <th class="txt-rgt">{{ __('frontstaticword.Total') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  @if($orders->course_id != NULL)
                    {{ $orders->courses['title'] }}
                  @elseif($orders->workshop_id != NULL)
                  {{ $orders->workshops['title'] }}
                  @else
                    {{ $orders->bundle['title'] }}
                  @endif
                </td>
                <td>{{ $orders['currency'] }}</td>

                @if($orders->coupon_discount != 0)
                <td class="text-center">
                  (-)&nbsp;<i class="{{ $orders['currency_icon'] }}"></i>{{ $orders['coupon_discount'] }}
                </td>
                @endif

                <td class="txt-rgt">
                   
                  @if($orders->coupon_discount == !NULL)
                    <i class="{{ $orders['currency_icon'] }}"></i>{{ $orders['total_amount'] - $orders['coupon_discount'] }}
                  @else
                    <i class="{{ $orders['currency_icon'] }}"></i>{{ $orders['total_amount'] }}
                  @endif
                </td>
               
              </tr>
            </tbody>
          </table>

           @if($orders->bundle_id != NULL)

          @foreach($bundle_order->course_id as $bundle_course)
              @php
                $coursess = App\Course::where('id', $bundle_course)->first();
              @endphp

              <div class="purchase-table table-responsive">
                <table class="table">

              <tbody>
                <tr>
                  <td>
                    <div class="purchase-history-course-img">
                    
                        @if($coursess['preview_image'] !== NULL && $coursess['preview_image'] !== '')
                            <a href="{{url('show/coursecontent',$orders->bundle->id)}}"><img src="{{ asset('images/course/'. $coursess->preview_image) }}" class="img-fluid" alt="course"></a>
                          @else
                            <a href="{{url('show/coursecontent',$orders->bundle->id)}}"><img src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid" alt="course"></a>
                          @endif

                    </div>
                    <div class="purchase-history-course-title">
                      <a href="{{url('show/coursecontent',$orders->bundle->id)}}">{{ $coursess->title }}</a>
                    </div>
                  </td>
                </tr>
              </tbody>
                </table>
              </div>
          @endforeach

        @endif
         @if($orders['currency'] == 'INR')
          <div class="txt-rgt">
                      Subtotal : <i class="fa {{ $orders['currency_icon'] }}"></i> {{ number_format($rate,2) }} <br>
                      GST (18%) : <i class="fa {{ $orders['currency_icon'] }}"></i> {{ number_format($gst,2)}} <br>
                      Total : <i class="fa {{ $orders['currency_icon'] }}"></i> {{  $orders['total_amount'] }} <br>
            </div>
        @endif
        </div>
       
            
      </div>

    </div>
    </div>
</section>
<!-- footer start -->

<!-- footer end -->
<!-- jquery -->
<script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
<!-- end jquery -->
</body>
<!-- body end -->
</html> 



