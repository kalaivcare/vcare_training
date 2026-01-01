@extends('admin.layouts.master')
@section('title', 'View Order - Admin')
@section('body')
 
<section class="content">
   @include('admin.message')
    <div class="row">
      <div class="col-md-12">
      	<div class="box box-primary">
           	<div class="box-header with-border">
            	<h3 class="box-title">Payment Receipt</h3>
         		</div>
          	<div class="panel-body">
				
  					<div id="printableArea">
  					    
  					     @php
  					     $rate = (float)$show['total_amount'] / (float)1.18;
                        $gst =   (float) $show['total_amount'] - (float) $rate;
                        @endphp
  						<!-- title row -->
  						<div class="row">
  						    <div class="col-xs-12">
  						      <h2 class="page-header">
  						        @if($setting->logo_type == 'L')
                        <div class="logo-invoice">

                           
                          <img src="{{ asset('images/logo/'.$setting->logo) }}">
                        </div>
                      @else()
                          <a href="{{ url('/') }}"><b><div class="logotext" >{{ $setting->project_title }}</div></b></a>
                      @endif
  						        <small>{{ __('adminstaticword.Date') }}:&nbsp;{{ date('jS F Y', strtotime($show['created_at'])) }}</small>
  						      </h2>
  						    </div>
  						    <!-- /.col -->
  						</div>
  						<!-- info row -->
              <div class="view-order">
    						<div class="row invoice-info">
    						    <div class="col-sm-4 invoice-col">
    						      {{ __('adminstaticword.From') }}:
      						      <address>
      						        <strong>NIHAWS<br>
		                            <small>(A unit of Ginerva Global Trading Corp LLP)</small><br>

                   
                    {{ __('frontstaticword.address') }}: 15, New Giri Road, T-nagar, Chennai-600017, Tamilnadu, India<br>
                      

                    {{ __('frontstaticword.Phone') }}: 9500186186<br>
                    {{ __('frontstaticword.Email') }}: info@nihaws.com<br>
                    GST number : 33AAVFG4443J1Z2
      						      </address>
                    
    						    </div>
    						    <!-- /.col -->
    						    <div class="col-sm-4 invoice-col">
    						      {{ __('adminstaticword.To') }}:
    						      <address>
    						        <strong>{{ $show->user['fname'] }}</strong><br>
                          {{ __('adminstaticword.Address') }}: {{ $show->user['address'] }}<br>
                        @if($show->user['state_id'] == !NULL)
                          {{ $show->user->state['name'] }},
                        @endif
                        @if($show->user['country_id'] == !NULL)
                          {{ $show->user->country['name'] }}<br>
                        @endif
    						          {{ __('adminstaticword.Phone') }}:&nbsp;{{ $show->user['mobile'] }}<br>
    						          {{ __('adminstaticword.Email') }}:&nbsp;{{ $show->user['email'] }}
    						      </address>
    						    </div>
    						    <!-- /.col -->
    						    <div class="col-sm-4 invoice-col">
    						      <br>
                      <b>{{ __('adminstaticword.OrderID') }}:</b> {{ $show['order_id'] }}<br>
    						      <b>{{ __('adminstaticword.TransactionId') }}:</b>&nbsp;{{ $show['transaction_id'] }}<br>
    						      <b>{{ __('adminstaticword.PaymentMethod') }}:</b>&nbsp;{{ $show['payment_method'] }}<br>
    						      <b>{{ __('adminstaticword.Currency') }}:</b>&nbsp;{{ $show['currency'] }}<br>
    						      <b>Offline tutor : </b>{{ $show->offline_tutor}} <br>
  	                              <b> No. of hours for offline tutor: </b>{{ $show['no_hours_off'] }}<br>
                      <b>Live tutor : </b>{{ $show->online_tutor_one}} &nbsp;<br>
                      <b> No. of hours for live tutor: </b>{{ $show['no_hours'] }}<br>
                      <b>Printed course materials : </b>{{ $show->hard_course}} <br>
                      <b>{{ __('frontstaticword.PaymentStatus') }}:</b> 
                      @if($show->status ==1)
                        <span class="badge badge-success">{{ __('adminstaticword.Recieved') }}</span>
                      @else 
                        <span class="badge badge-danger">{{ __('adminstaticword.Pending') }}</span>
                      @endif
                      </br>
                      <b>{{ __('adminstaticword.Enrollon') }}:</b> {{ date('jS F Y', strtotime($show['created_at'])) }}</br>
                      @if($money->currency != 'INR')
                      <b>Exchange Rate : </b><i class="fa fa-inr"></i>{{ $money->amount }}</br>
                      @endif
                      <b>
                        @if($show->enroll_expire != NULL)
                          {{ __('adminstaticword.EnrollEnd') }}:</b> {{ date('jS F Y', strtotime($show['enroll_expire'])) }}</br>
                        @endif
                        <br>
                        
                        @if($show->proof != NULL)
                           <a href="{{ asset('images/order/'.$show->proof) }}" download="{{$show->proof}}" title="Course">Download Proof <i class="fa fa-download"></i></a></br>
                        @endif
                        <br>
                        
    						    </div>
    						    <!-- /.col -->
    						</div>
              </div>
  						<!-- /.row -->
  		          		
          		<div class="order-table">
	             @if($show->course_id != Null)
          			<table class="table table-striped">
  							  <thead>
  							    <tr>
  							      <th>{{ __('adminstaticword.Course') }}</th>
                      <th>{{ __('adminstaticword.Currency') }}</th>
                      @if($show->coupon_discount != 0)
                      <th>{{ __('adminstaticword.CouponDiscount') }}</th>
                      @endif
                       @if($show['currency'] != 'INR')
                      <th>INR</th>
                      @endif
  							      <th>{{ __('adminstaticword.Total') }}</th>
  							    </tr>
  							  </thead>
  							  <tbody>
  							    <tr>
  							      <td>
                        @if($show->course_id != NULL)
                          {{ $show->courses['title'] }}
                        @else
                          {{ $show->bundle['title'] }}
                        @endif
                      </td>
                      <td>{{ $show['currency'] }}</td>

                      @if($show->coupon_discount != 0)
                      <td>
                        (-)&nbsp;<i class="{{ $show['currency_icon'] }}"></i>{{ $show['coupon_discount'] }}
                      </td>
                      @endif
                      
                       @if($show['currency'] != 'INR')
                      <td>{{ $show->courses['discount_price'] }}</td>
                      @endif

  							      <td>
                        @if($show->coupon_discount == !NULL)
                          <i class="fa {{ $show['currency_icon'] }}"></i>{{ $show['total_amount'] - $show['coupon_discount'] }}
                        @else
                          <i class="fa {{ $show['currency_icon'] }}"></i>{{ $show['total_amount'] }}
                        @endif
                      </td>
  							    </tr>
  							  </tbody>
  							</table>
  				 @endif
      	         @if($show->workshop_id != Null)
      	         
      	          <table class="table table-striped">
  							  <thead>
  							    <tr>
  							      <th>Workshops</th>
                      <th>{{ __('adminstaticword.Currency') }}</th>
                      @if($show->coupon_discount != 0)
                      <th>{{ __('adminstaticword.CouponDiscount') }}</th>
                      @endif
                      
                     
  							      <th>{{ __('adminstaticword.Total') }}</th>
  							    </tr>
  							  </thead>
  							  <tbody>
  							    <tr>
  							      <td>
                       
                          {{ $show->workshops['title'] }}
                        
                      </td>
                      <td>{{ $show['currency'] }}</td>

                      @if($show->coupon_discount != 0)
                      <td>
                        (-)&nbsp;<i class="{{ $show['currency_icon'] }}"></i>{{ $show['coupon_discount'] }}
                      </td>
                      @endif
                      
                     
  							      <td>
                        @if($show->coupon_discount == !NULL)
                          <i class="fa {{ $show['currency_icon'] }}"></i>{{ $show['total_amount'] - $show['coupon_discount'] }}
                        @else
                          <i class="fa {{ $show['currency_icon'] }}"></i>{{ $show['total_amount'] }}
                        @endif
                      </td>
  							    </tr>
  							  </tbody>
  							</table>
                 @endif

          		</div>

               @if($show->bundle_id != NULL)

                @foreach($show->bundle_course_id as $bundle_course)
                    @php
                      $coursess = App\Course::where('id', $bundle_course)->first();
                    @endphp

                    <div class="purchase-table table-responsive">
                      <table class="table">

                        <tbody>
                          <tr>
                            <td>
                              <div class="purchase-history-course-img display-inline-flex">
                              
                                    @if($coursess['preview_image'] !== NULL && $coursess['preview_image'] !== '')
                                      <img src="{{ asset('images/course/'. $coursess->preview_image) }}" class="img-fluid" alt="course">
                                    @else
                                      <img src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid" alt="course">
                                    @endif

                              </div>
                              <div class="purchase-history-course-title display-inline-flex" style="vertical-align: top;">
                                {{ $coursess->title }}
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                @endforeach

              @endif
              
                @if($show['currency'] == 'INR')
         <div class="text-right">
                      Subtotal : <i class="fa {{ $show['currency_icon'] }}"></i> {{ number_format($rate,2) }} <br>
                      GST (18%) : <i class="fa {{ $show['currency_icon'] }}"></i> {{ number_format($gst,2)}} <br>
                      Total : <i class="fa {{ $show['currency_icon'] }}"></i> {{  $rate+$gst }} <br>
            </div>
        @endif

            </div>
  					
  					<input type="button" class="btn btn-primary"  onclick="printDiv('printableArea')" value="Print Invoice" />

          	</div>
      	</div>
    	</div>
    </div>
</section>

@endsection


@section('scripts')

<script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
  	});
</script>

<script lang='javascript'>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
	}
</script>
@endsection


