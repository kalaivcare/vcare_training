@extends('theme.master')
@section('title', 'Cart')
@section('content')

@include('admin.message')

<!-- about-home start -->
<section id="wishlist-home" class="wishlist-home-main-block">
    <div class="container">
        <h1 class="wishlist-home-heading text-white">{{ __('frontstaticword.ShoppingCart') }}</h1>
    </div>
</section> 
<!-- about-home end -->
<section id="cart-block" class="cart-main-block">
    
	<div class="container">
		<div class="cart-items btm-30">
			<h4 class="cart-heading">
        		@php
                    $item = App\Cart::where('user_id', Auth::User()->id)->get();
                    if(count($item)>0){

                        echo count($item);
                    }
                    else{

                        echo "0";
                    }
                @endphp
            	Courses in Cart
            </h4>
            @if(count($item)>0)
		        <div class="row">
		            <div class="col-lg-9 col-md-9">
	        			@foreach($carts as $cart)
	        		
		    				<div class="cart-add-block">
			                    <div class="row no-gutters">
			                        <div class="col-lg-2 col-sm-6 col-5">
			                            <div class="cart-img">
			                               @if($cart->workshop_id != Null)
											    @if($cart->workshops['preview_image'] !== NULL && $cart->workshops['preview_image'] !== '')
				                                	<a href="{{ route('detail.workshop.show',['id' => $cart->workshops->id, 'slug' => $cart->workshops->slug ]) }}"><img src="{{ asset('images/workshop/'. $cart->workshops->preview_image) }}" class="img-fluid" alt="blog"></a>
				                                @else
				                                	<a href="{{ route('detail.workshop.show',['id' => $cart->workshops->id, 'slug' => $cart->workshops->slug ]) }}"><img src="{{ Avatar::create($cart->workshops->title)->toBase64() }}" class="img-fluid" alt="blog"></a>
				                                @endif
											@endif
			                            	@if($cart->course_id != NULL)
				                            	@if($cart->courses['preview_image'] !== NULL && $cart->courses['preview_image'] !== '')
				                                	<a href="{{ route('user.course.show',['id' => $cart->courses->id, 'slug' => $cart->courses->slug ]) }}"><img src="{{ asset('images/course/'. $cart->courses->preview_image) }}" class="img-fluid" alt="blog"></a>
				                                @else
				                                	<a href="{{ route('user.course.show',['id' => $cart->courses->id, 'slug' => $cart->courses->slug ]) }}"><img src="{{ Avatar::create($cart->courses->title)->toBase64() }}" class="img-fluid" alt="blog"></a>
				                                @endif
			                                @elseif($cart->bundle_id != Null)
				                                @if($cart->bundle['preview_image'] !== NULL && $cart->bundle['preview_image'] !== '')
				                                	<a href="{{ route('user.course.show',['id' => $cart->bundle->id, 'slug' => $cart->bundle->slug ]) }}"><img src="{{ asset('images/bundle/'. $cart->bundle->preview_image) }}" class="img-fluid" alt="blog"></a>
				                                @else
				                                	<a href="{{ route('user.course.show',['id' => $cart->bundle->id, 'slug' => $cart->bundle->slug ]) }}"><img src="{{ Avatar::create($cart->bundle->title)->toBase64() }}" class="img-fluid" alt="blog"></a>
				                                @endif
			                                @endif


			                            </div>
			                        </div>
			                        <div class="col-lg-4 col-sm-6 col-6">
			                        	<div class="cart-course-detail">
			                        	    @if($cart->workshop_id != Null)
											<div class="cart-course-name"><a href="{{ route('detail.workshop.show',['id' => $cart->workshops->id, 'slug' => $cart->workshops->slug ]) }}">{{ str_limit($cart->workshops->title, $limit = 50, $end = '...') }}</a></div>
											@endif
			                        		@if($cart->course_id != NULL)
					                            <div class="cart-course-name"><a href="{{ route('user.course.show',['id' => $cart->courses->id, 'slug' => $cart->courses->slug ]) }}">{{ str_limit($cart->courses->title, $limit = 50, $end = '...') }}</a></div>
												@if($cart->instructor_price == NULL && $cart->certificate_price == NULL)
					                            <div class="cart-course-update"> For Course</div>
												@elseif($cart->instructor_price!= NULL && $cart->certificate_price == NULL)
												<div class="cart-course-update"> To hire an Instructor </div>
												@else
												<div class="cart-course-update"> For Original Certificate </div>
                                                @endif
				                            @elseif($cart->bundle_id != Null)
					                            <div class="cart-course-name"><a href="{{ route('user.course.show',['id' => $cart->bundle->id, 'slug' => $cart->bundle->slug ]) }}">{{ str_limit($cart->bundle->title, $limit = 50, $end = '...') }}</a></div>
												@if($cart->instructor_price == NULL && $cart->certificate_price == NULL)
					                            <div class="cart-course-update"> For Learning Courses</div>
												@elseif($cart->instructor_price!= NULL && $cart->certificate_price == NULL)
												<div class="cart-course-update"> To hire an Instructor </div>
												@else
												<div class="cart-course-update"> For Original Certificate </div>
                                                @endif
				                            @endif

				                        </div>
			                        </div>
			                        <div class="col-lg-2 offset-lg-1 col-sm-6 col-6">
			                            <div class="cart-actions">
		                                    <span>
		                                    	<form id="cart-form" method="post" action="{{url('removefromcart', $cart->id)}}" 
					                            	data-parsley-validate class="form-horizontal form-label-left">
					    	                        {{ csrf_field() }}
					    	                        
					    	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>
					    	                    </form>
											</span>
											<span>
    											@if($cart->course_id != Null)
												<form id="wishlist-form" method="post" action="{{ url('show/wishlist', $cart->id ) }}" data-parsley-validate class="form-horizontal form-label-left">
					                                {{ csrf_field() }}

					                                <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
					                                <input type="hidden" name="course_id"  value="{{$cart->course_id}}" />

					                                <button class="cart-wishlisht-btn" title="Add to wishlist" type="submit">{{ __('frontstaticword.AddtoWishlist') }}</button>
					                            </form>
					                            @endif
											</span>
											
			                            </div>
			                        </div>
			                        <div class="col-lg-3 col-sm-6 col-6">
			                        	<div class="row">
			                        		<div class="col-lg-10 col-10">
					                            <div class="cart-course-amount">
					                                <ul>
			                                            
			                                            @if($cart->price != NULL)
			                                            @if($cart->offer_price == !NULL)

					                                    	<li><i class="{{ $cart->currency_icon }}"></i>{{ $cart->offer_price }}</li>
					                                    	<li><s><i class="{{ $cart->currency_icon }}"></i>{{ $cart->price }}</s></li>
					                                    @else
					                                    	<li><i class="{{ $cart->currency_icon }}"></i>{{ $cart->price }}</li>
					                                    @endif
					                                    @endif
					                                    
					                                    
					                                </ul>
					                            </div>
					                        </div>
					                        <div class="col-lg-2 col-2">
					                        	@if($cart->disamount == !NULL)
						                        	@if(Session::has('coupanapplied'))
						                            <div class="cart-coupon">
				                    					<a href="" class="btn btn-link top" data-toggle="tooltip" data-placement="top" title="{{Session::get('coupanapplied')['msg']}}"><i class="fa fa-tag"></i></a>
				                    				</div>
				                    				@endif
				                    			@endif
			                    			</div>
	                    				</div>
			                        </div>
			                    </div>
			                    <hr>
                            @if ($cart->course_id != null) 
			                    @php
			                     $ordertutor = App\Order::where('user_id', Auth::User()->id)->where('course_id', $cart->courses->id)->get();
                                foreach($ordertutor as $ordertutors){
                                if ($ordertutors->offline_tutor ==  round($cart->courses->offline_tutor/$money->amount)) {
                                          $tutoroffid = $ordertutors->course_id;
                                   }
                                   
                                   if ($ordertutors->online_tutor_one == !Null) {
                                               $tutoronid = $ordertutors->course_id;
                                    }
                                    
                                    if ($ordertutors->hard_course ==  round($cart->courses->hard_course/$money->amount)) {
                                                $tutorhardid = $ordertutors->course_id;
                                    }  
                                         
                                    }
                                @endphp
			                   
			                    @if( round($cart->courses->offline_tutor/$money->amount) !=Null)
                                @if(empty($tutoroffid))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-6 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="offline_tutor">Add offline tutor for this course</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">-->
								<!--	@if($cart->offline_tutor != 0)-->

								<!--	<form id="cart-form" method="post" action="{{url('removeoffline_tutor', $cart->id)}}" -->
					   <!--                         	data-parsley-validate class="form-horizontal form-label-left">-->
					   <!-- 	                        {{ csrf_field() }}-->
					    	                        
					   <!-- 	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>-->
					   <!-- 	                    </form>-->
								<!--	@else-->
									
								<!--		<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#offlinetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->

									
								<!--	<div class="modal fade" id="offlinetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
        <!--                                <div class="modal-dialog modal-lg" role="document">-->
        <!--                                  <div class="modal-content">-->
        <!--                                    <div class="modal-header">-->
        <!--                                      <h4 class="modal-title" id="myModalLabel">Offline Tutor</h4>-->
        <!--                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--                                    </div>-->
        <!--                                    <div class="box box-primary">-->
        <!--                                      <div class="panel panel-sum">-->
        <!--                                        <div class="modal-body">-->
								<!--				<form id="demo-form2" method="post" action="{{ route('offline_tutor',['course_id' => $cart->courses->id, 'price' =>  round($cart->courses->price/$money->amount), 'discount_price' =>  round($cart->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($cart->courses->offline_tutor/$money->amount) }}" name="offline_tutor">-->
														
								<!--						<div class="row">-->
								<!--							<div class="col-6">-->
								<!--								<div class="form-group">-->
								<!--								<label for="no_hours_off">No. of hours : </label>-->
								<!--								<select name="no_hours_off" id="no_hours_off" class="form-control js-example-basic-single" required>-->
                                                                
        <!--                                                        </select>-->
								<!--								</div>-->
								<!--							</div>-->
								<!--						</div>-->


        <!--                                                <hr>-->
        <!--                                                <div class="box-footer">-->
								<!--						<button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                                    </button>-->
								<!--                       </div>-->
        <!--                                            </form>-->
        <!--                                        </div>-->
        <!--                                      </div>-->
        <!--                                    </div>-->
        <!--                                  </div>-->
        <!--                                </div>-->
        <!--                            </div>-->

								
								<!--   @endif-->
								<!--	</div>-->
								<!--	<div class="col-lg-3 col-sm-6 col-6">-->
								<!--	<div class="row">-->
			     <!--                   <div class="col-lg-10 col-10">-->
								<!--	<div class="cart-course-amount">-->
					   <!--                             <ul>-->
					                                

        <!--                                                   @if($cart->offline_tutor!=Null)-->
					   <!--                                 	<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->offline_tutor/$money->amount)*$cart->no_hours_off }}</li>-->
								<!--							@else-->
								<!--							<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->offline_tutor/$money->amount) }}</li>-->
								<!--						   @endif-->
								<!--				   </ul>-->
					   <!--                         </div>-->
				    <!--                       </div>-->
				    <!--                    </div>-->
								<!--	</div>-->
				    <!--            </div>-->
				    <!--            <hr>-->
                                @elseif(!empty($tutoroffid) && $cart->courses->id!=$tutoroffid)
        <!--                        <div class="row no-gutters">-->
								<!--  <div class="col-lg-6 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="offline_tutor">Add offline tutor for this course</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">-->
								<!--	@if($cart->offline_tutor != 0)-->

								<!--	<form id="cart-form" method="post" action="{{url('removeoffline_tutor', $cart->id)}}" -->
					   <!--                         	data-parsley-validate class="form-horizontal form-label-left">-->
					   <!-- 	                        {{ csrf_field() }}-->
					    	                        
					   <!-- 	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>-->
					   <!-- 	                    </form>-->
								<!--	@else-->
								<!--	<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#offlinetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->

									
								<!--	<div class="modal fade" id="offlinetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
        <!--                                <div class="modal-dialog modal-lg" role="document">-->
        <!--                                  <div class="modal-content">-->
        <!--                                    <div class="modal-header">-->
        <!--                                      <h4 class="modal-title" id="myModalLabel">Offline Tutor</h4>-->
        <!--                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--                                    </div>-->
        <!--                                    <div class="box box-primary">-->
        <!--                                      <div class="panel panel-sum">-->
        <!--                                        <div class="modal-body">-->
								<!--				<form id="demo-form2" method="post" action="{{ route('offline_tutor',['course_id' => $cart->courses->id, 'price' =>  round($cart->courses->price/$money->amount), 'discount_price' =>  round($cart->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($cart->courses->offline_tutor/$money->amount) }}" name="offline_tutor">-->
														
								<!--						<div class="row">-->
								<!--							<div class="col-6">-->
								<!--								<div class="form-group">-->
								<!--								<label for="no_hours_off">No. of hours : </label>-->
								<!--								<select name="no_hours_off" id="no_hours_off" class="form-control js-example-basic-single" required>-->
                                                                
        <!--                                                        </select>-->
								<!--								</div>-->
								<!--							</div>-->
								<!--						</div>-->


        <!--                                                <hr>-->
        <!--                                                <div class="box-footer">-->
								<!--						<button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                                    </button>-->
								<!--                       </div>-->
        <!--                                            </form>-->
        <!--                                        </div>-->
        <!--                                      </div>-->
        <!--                                    </div>-->
        <!--                                  </div>-->
        <!--                                </div>-->
        <!--                            </div>-->

								<!--   @endif-->
								<!--	</div>-->
								<!--	<div class="col-lg-3 col-sm-6 col-6">-->
								<!--	<div class="row">-->
			     <!--                   <div class="col-lg-10 col-10">-->
								<!--	<div class="cart-course-amount">-->
					   <!--                             <ul>-->
					                                

        <!--                                                   @if($cart->offline_tutor!=Null)-->
					   <!--                                 	<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->offline_tutor/$money->amount)*$cart->no_hours }}</li>-->
								<!--							@else-->
								<!--							<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->offline_tutor/$money->amount) }}</li>-->
								<!--						   @endif					                 -->
								<!--				    </ul>-->
					   <!--                         </div>-->
				    <!--                       </div>-->
				    <!--                    </div>-->
								<!--	</div>-->
				    <!--            </div>-->
								<!--<hr>-->
								@endif
				                @endif
				                
			                    @if(  round($cart->courses->online_tutor_one/$money->amount) !=Null)
				                @if(empty($tutoronid))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-6 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="online_tutor">Add Live tutor for this course</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">-->
								<!--	@if($cart->online_tutor_one != 0)-->

								<!--	<form id="cart-form" method="post" action="{{url('removeonline_tutor_one', $cart->id)}}" -->
					   <!--                         	data-parsley-validate class="form-horizontal form-label-left">-->
					   <!-- 	                        {{ csrf_field() }}-->
					    	                        
					   <!-- 	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>-->
					   <!-- 	                    </form>-->
								<!--	@else-->
									
								<!--		<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#livetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->


								<!--	<div class="modal fade" id="livetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
        <!--                                <div class="modal-dialog modal-lg" role="document">-->
        <!--                                  <div class="modal-content">-->
        <!--                                    <div class="modal-header">-->
        <!--                                      <h4 class="modal-title" id="myModalLabel">Live Tutor</h4>-->
        <!--                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--                                    </div>-->
        <!--                                    <div class="box box-primary">-->
        <!--                                      <div class="panel panel-sum">-->
        <!--                                        <div class="modal-body">-->
								<!--				<form id="demo-form2" method="post" action="{{ route('online_tutor_one',['course_id' => $cart->courses->id, 'price' =>  round($cart->courses->price/$money->amount), 'discount_price' =>  round($cart->courses->discount_price/$money->amount)
 ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($cart->courses->online_tutor_one/$money->amount) }}" name="online_tutor_one">        -->

								<!--						<div class="row">-->
								<!--							<div class="col-6">-->
								<!--								<div class="form-group">-->
								<!--								<label for="no_hours">No. of hours : </label>-->
								<!--								<select name="no_hours" id="no_hours" class="form-control js-example-basic-single" required>-->
                                                                
        <!--                                                        </select>-->
								<!--								</div>-->
								<!--							</div>-->
								<!--						</div>-->


        <!--                                                <hr>-->
        <!--                                                <div class="box-footer">-->
								<!--						<button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                                    </button>-->
								<!--                       </div>-->
        <!--                                            </form>-->
        <!--                                        </div>-->
        <!--                                      </div>-->
        <!--                                    </div>-->
        <!--                                  </div>-->
        <!--                                </div>-->
        <!--                            </div>-->

									
									
								<!--   @endif-->
								<!--	</div>-->
								<!--	<div class="col-lg-3 col-sm-6 col-6">-->
								<!--	<div class="row">-->
			     <!--                   <div class="col-lg-10 col-10">-->
								<!--	<div class="cart-course-amount">-->
					   <!--                             <ul>-->
					                                

        <!--                                                   @if($cart->online_tutor_one!=Null)-->
					   <!--                                 	<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->online_tutor_one/$money->amount)*$cart->no_hours }}</li>-->
								<!--							@else-->
								<!--							<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->online_tutor_one/$money->amount) }}</li>-->
								<!--						   @endif					                            -->
								<!--					</ul>-->
					   <!--                         </div>-->
				    <!--                       </div>-->
				    <!--                    </div>-->
								<!--	</div>-->
				    <!--            </div>-->
								<!--<hr>-->
                                @elseif(!empty($tutoronid) && $cart->courses->id!=$tutoronid)
        <!--                        <div class="row no-gutters">-->
								<!--  <div class="col-lg-6 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="online_tutor">Add Live tutor for this course</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">-->
								<!--	@if($cart->online_tutor_one != 0)-->

								<!--	<form id="cart-form" method="post" action="{{url('removeonline_tutor_one', $cart->id)}}" -->
					   <!--                         	data-parsley-validate class="form-horizontal form-label-left">-->
					   <!-- 	                        {{ csrf_field() }}-->
					    	                        
					   <!-- 	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>-->
					   <!-- 	                    </form>-->
								<!--	@else-->
									
								<!--		<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#livetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->


								<!--	<div class="modal fade" id="livetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
        <!--                                <div class="modal-dialog modal-lg" role="document">-->
        <!--                                  <div class="modal-content">-->
        <!--                                    <div class="modal-header">-->
        <!--                                      <h4 class="modal-title" id="myModalLabel">Live Tutor</h4>-->
        <!--                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--                                    </div>-->
        <!--                                    <div class="box box-primary">-->
        <!--                                      <div class="panel panel-sum">-->
        <!--                                        <div class="modal-body">-->
								<!--				<form id="demo-form2" method="post" action="{{ route('online_tutor_one',['course_id' => $cart->courses->id, 'price' =>  round($cart->courses->price/$money->amount), 'discount_price' =>  round($cart->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($cart->courses->online_tutor_one/$money->amount) }}" name="online_tutor_one">        -->

								<!--						<div class="row">-->
								<!--							<div class="col-6">-->
								<!--								<div class="form-group">-->
								<!--								<label for="no_hours">No. of hours : </label>-->
								<!--								<select name="no_hours" id="no_hours" class="form-control js-example-basic-single" required>-->
                                                               
        <!--                                                        </select>-->
								<!--								</div>-->
								<!--							</div>-->
								<!--						</div>-->


        <!--                                                <hr>-->
        <!--                                                <div class="box-footer">-->
								<!--						<button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                                    </button>-->
								<!--                       </div>-->
        <!--                                            </form>-->
        <!--                                        </div>-->
        <!--                                      </div>-->
        <!--                                    </div>-->
        <!--                                  </div>-->
        <!--                                </div>-->
        <!--                            </div>-->

									
									
								<!--   @endif-->
								<!--	</div>-->
								<!--	<div class="col-lg-3 col-sm-6 col-6">-->
								<!--	<div class="row">-->
			     <!--                   <div class="col-lg-10 col-10">-->
								<!--	<div class="cart-course-amount">-->
					   <!--                             <ul>-->
					                                
        <!--                                                   @if($cart->online_tutor_one!=Null)-->
					   <!--                                 	<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->online_tutor_one/$money->amount)*$cart->no_hours }}</li>-->
								<!--							@else-->
								<!--							<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->online_tutor_one/$money->amount) }}</li>-->
								<!--						   @endif					                            -->
								<!--					</ul>-->
					   <!--                         </div>-->
				    <!--                       </div>-->
				    <!--                    </div>-->
								<!--	</div>-->
				    <!--            </div>-->
								<!--<hr>-->
								@endif
								@endif
								
			                 
				                
			                    @if( round($cart->courses->hard_course/$money->amount)!=Null)
                                @if(empty($tutorhardid))
         <!--                       <div class="row no-gutters">-->
								 <!-- <div class="col-lg-6 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="hard_course">Get printed Course materials for this course</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">-->
									<!--@if($cart->hard_course != 0)-->

									<!--<form id="cart-form" method="post" action="{{url('removehard_course', $cart->id)}}" -->
					    <!--                        	data-parsley-validate class="form-horizontal form-label-left">-->
					    <!--	                        {{ csrf_field() }}-->
					    	                        
					    <!--	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>-->
					    <!--	                    </form>-->
									<!--@else-->
									<!--<form id="demo-form2" method="post" action="{{ route('hard_course',['course_id' => $cart->courses->id, 'price' =>  round($cart->courses->price/$money->amount), 'discount_price' =>  round($cart->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($cart->courses->hard_course/$money->amount) }}" name="hard_course">-->
									<!--<button type="submit" class="btn btn-primary tutorcart"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

				     <!--              </form>-->
								 <!--  @endif-->
									<!--</div>-->
									<!--<div class="col-lg-3 col-sm-6 col-6">-->
									<!--<div class="row">-->
			      <!--                  <div class="col-lg-10 col-10">-->
									<!--<div class="cart-course-amount">-->
					    <!--                            <ul>-->
					                                 

					    <!--                                	<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->hard_course/$money->amount) }}</li>                              -->
					    <!--                            </ul>-->
					    <!--                        </div>-->
				     <!--                      </div>-->
				     <!--                   </div>-->
									<!--</div>-->
				     <!--           </div>-->
				                @elseif(!empty($tutorhardid) && $cart->courses->id!=$tutorhardid)
				     <!--           <div class="row no-gutters">-->
								 <!-- <div class="col-lg-6 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="hard_course">Get printed Course materials for this course</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-2 offset-lg-1 col-sm-6 col-6">-->
									<!--@if($cart->hard_course != 0)-->

									<!--<form id="cart-form" method="post" action="{{url('removehard_course', $cart->id)}}" -->
					    <!--                        	data-parsley-validate class="form-horizontal form-label-left">-->
					    <!--	                        {{ csrf_field() }}-->
					    	                        
					    <!--	                      <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart">{{ __('frontstaticword.Remove') }}</button>-->
					    <!--	                    </form>-->
									<!--@else-->
									<!--<form id="demo-form2" method="post" action="{{ route('hard_course',['course_id' => $cart->courses->id, 'price' =>  round($cart->courses->price/$money->amount), 'discount_price' =>  round($cart->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($cart->courses->hard_course/$money->amount) }}" name="hard_course">-->
									<!--<button type="submit" class="btn btn-primary tutorcart"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

				     <!--              </form>-->
								 <!--  @endif-->
									<!--</div>-->
									<!--<div class="col-lg-3 col-sm-6 col-6">-->
									<!--<div class="row">-->
			      <!--                  <div class="col-lg-10 col-10">-->
									<!--<div class="cart-course-amount">-->
					    <!--                            <ul>-->
					                                

					    <!--                                	<li><i class="{{ $money->icon }}"></i>{{  round($cart->courses->hard_course/$money->amount) }}</li>                              -->
					    <!--                            </ul>-->
					    <!--                        </div>-->
				     <!--                      </div>-->
				     <!--                   </div>-->
									<!--</div>-->
				     <!--           </div>-->
				                @endif
				                @endif
				        @endif

		                	</div>
	                    @endforeach
	                    <div class="container-fluid" id="adsense">
					        <!-- google adsense code -->
					        <?php
					          if (isset($ad)) {
					           if ($ad->iscart==1 && $ad->status==1) {
					              $code = $ad->code;
					              echo html_entity_decode($code);
					           }
					          }
					        ?>
					    </div>
		            </div>
	                <div class="col-lg-3 col-md-3">
	                	@if(! $carts->isEmpty())
		                	<div class="cart-total">
								@php
			                        $cartitems = App\Cart::where('user_id', Auth::User()->id)->first();
			                        foreach($carts as $cart){
										$coursedis = App\Course::where('discount_price',$cart->offer_price)->first();
									}
									                    
			                    @endphp
			                    @if ($cartitems == NULL)
			                        {{ __('frontstaticword.empty') }}
			                    @else
			                    
			                    <div class="cart-price-detail">
			                		<h4 class="cart-heading">{{ __('frontstaticword.Total') }}:</h4>
			                		<ul>
			                            <li>{{ __('frontstaticword.TotalPrice') }}<span class="categories-count"><i class="{{ $cart->currency_icon }}"></i>{{ $price_total }}</span></li>
			                            <li>{{ __('frontstaticword.OfferDiscount') }}<span class="categories-count">-&nbsp;<i class="{{ $cart->currency_icon }}"></i>{{ $offer_total }}</span></li>
			                            <li>{{ __('frontstaticword.CouponDiscount') }}
			                            	@if( $cpn_discount == !NULL)
			                            		<span class="categories-count">-&nbsp;<i class="{{ $cart->currency_icon }}"></i>{{ $cpn_discount }}</span>
			                            	@else
			                            		<span class="categories-count"><a href="#" data-toggle="modal" data-target="#myModalCoupon" title="report">{{ __('frontstaticword.ApplyCoupon') }}</a></span>
			                            	@endif
			                            </li>
			                            <li>{{ __('frontstaticword.DiscountPercent') }}<span class="categories-count">{{ round($offer_percent, 0) }}% Off</span></li>
			                            <hr>
			                            <li class="cart-total-two"><b>{{ __('frontstaticword.Total') }}:<span class="categories-count"><i class="{{ $cart->currency_icon }}"></i>{{ $cart_total }}</b></span></li>
			                		</ul>
			                	</div>


			                    <div class="course-rate">
			                        
			                        
			                        <div class="checkout-btn">
			                        	<form id="cart-form" method="post" action="{{url('gotocheckout')}}" 
			                            	data-parsley-validate class="form-horizontal form-label-left">
			    	                        {{ csrf_field() }}

			    	                        <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
			    	                        <input type="hidden" name="price_total"  value="{{  $price_total }}" />
			    	                        <input type="hidden" name="offer_total"  value="{{  $offer_total }}" />
			    	                        <input type="hidden" name="offer_percent"  value="{{ round($offer_percent, 2) }}" />
			    	                        <input type="hidden" name="cart_total"  value="{{ $cart_total }}" />
						                    
			    	                        
			    	                      <button class="btn btn-primary" title="checkout" type="submit">{{ __('frontstaticword.Checkout') }}</button>
			    	                    </form>
			    	                    
			                    	</div>
			                    </div>
			                    @endif
			                </div>
			                <hr>
			                <div class="coupon-apply">
								<form id="cart-form" method="post" action="{{url('apply/coupon')}}" 
	                            	data-parsley-validate class="form-horizontal form-label-left">
	    	                        {{ csrf_field() }}

				                	<div class="row no-gutters">
				                		<div class="col-lg-9 col-9">
				                			<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
			                    			<input type="text" name="coupon" value="" placeholder="Enter Coupon" />
			                    		</div>
			                    		<div class="col-lg-3 col-3">
			                    			<button data-purpose="coupon-submit" type="submit" class="btn btn-primary"><span>{{ __('frontstaticword.Apply') }}</span></button>
			                    		</div>
			                    	</div>
			                    </form>
			                </div>

		                    @if(Session::has('fail'))
	                    		<div class="alert alert-danger alert-dismissible fade show">
	                    			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
	                    			{{ Session::get('fail') }}
	                    		</div>
	                		@endif
	                		@if(Session::has('coupanapplied'))
	                    		<form id="demo-form2" method="post" action="{{ route('remove.coupon', Session::get('coupanapplied')['cpnid']) }}">
	                                {{ csrf_field() }}
	                                    
		                            <div class="remove-coupon">
		                             <button type="submit" class="btn btn-primary" title="Remove Coupon"><i class="fa fa-times icon-4x" aria-hidden="true"></i></button>
		                            </div>
		                        </form>
								<div class="coupon-code">   
									{{Session::get('coupanapplied')['msg']}}
								</div>
	                        @endif
		                @endif
	                </div>
		        </div>
		    @else
		    	<div class="cart-no-result">
		    		<i class="fa fa-shopping-cart"></i>
			    	<div class="no-result-courses btm-10">{{ __('frontstaticword.cartempty') }}</div>
			    	<div class="recommendation-btn text-white text-center">
		                <a href="{{ url('/') }}" class="btn btn-primary" title="Keep Shopping"><b>{{ __('frontstaticword.Browse') }}</b></a>
		            </div> 
				</div>
		    @endif
	    </div>
	</div>

	<!--Model start-->
	<div class="modal fade" id="myModalCoupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modal-md" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.CouponCode') }}</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <div class="box box-primary">
	          <div class="panel panel-sum">
	            <div class="modal-body">
	            	<div class="coupon-apply">
						<form id="cart-form" method="post" action="{{url('apply/coupon')}}" 
	                    	data-parsley-validate class="form-horizontal form-label-left">
	                        {{ csrf_field() }}
	                        
		                	<div class="row no-gutters">
		                		<div class="col-lg-9 col-9">
		                			<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
	                    			<input type="text" name="coupon" value="" placeholder="Enter Coupon" />
	                    		</div>
	                    		<div class="col-lg-3 col-3">
	                    			<button data-purpose="coupon-submit" type="submit" class="btn btn-primary"><span>{{ __('frontstaticword.Apply') }}</span></button>
	                    		</div>
	                    	</div>
	                    </form>
	                </div>
	                <hr>
	                @if(! $carts->isEmpty())
	                <div class="available-coupon">
	                	@php
	                		$cpns = App\Coupon::get();
	                	@endphp

	                	@foreach($cpns as $cpn)
	                		<ul>
	                			<li>{{ $cpn->code }}</li>
	                		</ul>
	                	@endforeach
	                	
	                </div>
	                @endif


	            </div>
	          </div>
	        </div>
	      </div>
	    </div> 
	</div>
	<!--Model close -->
</section>

@endsection

@section('custom-script')
<script>
(function($) {
    var $select = $("#no_hours");
    for (i=1;i<=50;i++){
        $select.append($('<option></option>').val(i).html(i))
    }
    
     var $select = $("#no_hours_off");
    for (i=1;i<=50;i++){
        $select.append($('<option></option>').val(i).html(i))
    }
})(jQuery);
</script>
@endsection
