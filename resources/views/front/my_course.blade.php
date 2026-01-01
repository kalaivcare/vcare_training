@extends('theme.master')
@section('title', 'My Courses')
@section('content')
@include('admin.message')

<!-- about-home start -->

@php
    $workorder = App\Order::where('user_id', Auth::User()->id)->first();
@endphp



<section id="wishlist-home" class="mycourse-home-main-block">
    <div class="container">
        <h1 class="mycourse-home-heading text-white">{{ __('frontstaticword.MyCourses') }}</h1>

                <div class="my-courses">
                 
                    <ul class="nav nav-tabs" id="mycourseTab" role="tablist">
                    <li class="btn nav-item" >
                                
                                <a class="nav-item nav-link active" id="coursehome-tab" data-toggle="tab" href="#course-tabs" role="tab"
                                 aria-controls="home"  aria-selected="true">All Courses</a>
                                </li>
                     

                            <li class="btn nav-item" >
                                
                                <a class="nav-item nav-link" id="coursehome-tab" data-toggle="tab" href="#wish-tabs" role="tab"
                                 aria-controls="home" aria-selected="true">Wishlist</a>
                                </li>

                                <li class="btn nav-item" >
                                
                                <a class="nav-item nav-link" id="coursehome-tab" data-toggle="tab" href="#purchase-tabs" role="tab"
                                 aria-controls="home" aria-selected="true">Purchase History</a>
                                </li>

                                <li class="btn nav-item" >
                                
                                <a class="nav-item nav-link" id="coursehome-tab" data-toggle="tab" href="#profile-tabs" role="tab"
                                 aria-controls="home" aria-selected="true">My Profile</a>
                                </li>
                      
                    </ul>
                   
                </div>
               
    </div>
    
</section> 

<div class="tab-content" id="myTabContent">
                  
                  <div class="tab-pane fade show active" id="course-tabs" role="tabpanel" aria-labelledby="coursehome-tab">
                      
                     
@php
    $item = App\Order::where('user_id', Auth::User()->id)->get();
    $course = App\Course::all();
      $enroll = App\Order::where('user_id', Auth::User()->id)->get();
@endphp

@if(count($item) > 0)
    <section id="learning-courses" class="learning-courses-main-block">
        <div class="container">
            <div class="row">
            	@foreach($enroll as $enrol)
            	   @if($enrol->workshop_id == NULL)
                    @if($enrol->course_id != NULL)
                    
                        @if($enrol->status == 1)
                        	@if($enrol->user_id == Auth::User()->id)
                             <?php $course_id = $enrol->courses->id;
                                   $order = App\Order::where('user_id',Auth::user()->id)->where('course_id',$course_id)->first();
                                   $cart = App\Cart::where('user_id',Auth::user()->id)->where('course_id',$course_id)->first();
                            ?>
                                <div class="col-lg-3 col-sm-6">
                                    
                                    <div class="view-block">
                                        <div class="view-img">
                                            @if($enrol->courses['preview_image'] !== NULL && $enrol->courses['preview_image'] !== '')
                                                <a href="{{url('show/coursecontent',$enrol->courses->id)}}"><img src="{{ asset('images/course/'.$enrol->courses->preview_image) }}" class="img-fluid" alt="student">
                                                </a>
                                            @else
                                                <a href="{{url('show/coursecontent',$enrol->courses->id)}}"><img src="{{ Avatar::create($enrol->courses->title)->toBase64() }}" class="img-fluid" alt="student"></a>
                                            @endif
                                        </div>
                                        <div class="view-dtl" style="height: auto">
                                            <div class="view-heading btm-10"><a href="{{url('show/coursecontent',$enrol->courses->id)}}">{{ str_limit($enrol->courses->title, $limit = 50, $end = '...') }}</a>
                                            </div>
                                            <!--<p class="btm-10"><a href="#">by {{ $enrol->courses->user->fname }}</a></p>-->
                                            <div class="rating">
                                                <ul>
                                                    <li>
                                                        <!-- star rating -->
                                                        @php
                                                        $learn = 0;
                                                        $price = 0;
                                                        $value = 0;
                                                        $sub_total = 0;
                                                        $sub_total = 0;
                                                        $reviews = App\ReviewRating::where('course_id',$enrol->courses->id)->where('status','1')->get();
                                                        @endphp
                                                        @if(!empty($reviews[0]))
                                                            @php
                                                            $count =  App\ReviewRating::where('course_id',$enrol->courses->id)->count();

                                                            foreach($reviews as $review){
                                                                $learn = $review->price*5;
                                                                $price = $review->price*5;
                                                                $value = $review->value*5;
                                                                $sub_total =$learn + $price + $value;
                                                            }

                                                            $count = ($count*3) * 5;
                                                            $rat =$sub_total/$count;
                                                            $ratings_var = ($rat*100)/5;
                                                            @endphp
                                            
                                                            <div class="pull-left">
                                                                <div class="star-ratings-sprite"><span style="width:{{$ratings_var}} ?>%" class="star-ratings-sprite-rating"></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="pull-left">
                                                                {{ __('frontstaticword.NoRating') }}
                                                            </div>
                                                        @endif
                                                    </li>
                                                    <!-- overall rating -->
                                                    @php
                                                    $reviews = App\ReviewRating::where('course_id' ,$enrol->courses->id)->get();
                                                    @endphp
                                                    <?php 
                                                    $learn = 0;
                                                    $price = 0;
                                                    $value = 0;
                                                    $sub_total = 0;
                                                    $count =  count($reviews);
                                                    $onlyrev = array();

                                                    $reviewcount = App\ReviewRating::where('course_id', $enrol->courses->id)->where('status',"1")->WhereNotNull('review')->get();

                                                    foreach($reviewcount as $review){

                                                        $learn = $review->learn*5;
                                                        $price = $review->price*5;
                                                        $value = $review->value*5;
                                                        $sub_total = $sub_total + $learn + $price + $value;
                                                    }

                                                    $count = ($count*3) * 5;
                                                    if($count > 0)
                                                    {
                                                        $rat = $sub_total/$count;
                                                        //print_r($rat);
                                                        $ratings_var = ($rat*100)/5;
                                                        
                                                        $overallrating = ($ratings_var/2)/10;
                                                    }
                                                    ?>

                                                    @php
                                                        $reviewsrating = App\ReviewRating::where('course_id', $enrol->courses->id)->first();
                                                    @endphp
                                                    @if(!empty($reviewsrating))
                                                    <li>
                                                        <b>{{ round($overallrating, 1) }}</b>
                                                    </li>
                                                    @endif

                                                    <li style="display:none;">
                                                        (@php
                                                            $data = App\Order::where('course_id', $enrol->courses->id)->get();
                                                            if(count($data)>0){

                                                                echo count($data);
                                                            }
                                                            else{

                                                                echo "0";
                                                            }
                                                        @endphp)
                                                    </li> 
                                                </ul>
                                            </div>
                       

                                            <div class="mycourse-progress">

                                                <?php
                                                    $progress = App\CourseProgress::where('course_id', $enrol->course_id)->where('user_id', Auth::User()->id)->first();
                                                ?>
                                                @if(!empty($progress))
                                                        
                                                    <?php
                                                    
                                                    $total_class = $progress->all_chapter_id;
                                                    $total_count = count($total_class);

                                                    $total_per = 100;

                                                    $read_class = $progress->mark_chapter_id;
                                                    $read_count =  count($read_class);

                                                    $progres = ($read_count/$total_count) * 100;
                                                    ?>

                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $progres; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="complete"><?php echo round($progres); ?>% Complete</div>
                                                @else
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="complete"><a href="{{url('show/coursecontent',$enrol->courses->id)}}">Start Course</a></div>
                                                @endif
                                                

                                            </div>
                                            <hr>
                            @php 
                            $ordertutor = App\Order::where('user_id', Auth::User()->id)->where('course_id', $enrol->courses->id)->get();
                                foreach($ordertutor as $ordertutors){
                                  if ($ordertutors->offline_tutor ==  round($enrol->courses->offline_tutor/$money->amount)) {
                                          $tutoroffid = $ordertutors->course_id;
                                   }
                                   
                                   if ($ordertutors->online_tutor_one == !Null) {
                                           $tutoronid = $ordertutors->course_id;
                                    }
                                    
                                    if ($ordertutors->hard_course ==  round($enrol->courses->hard_course/$money->amount)) {
                                                $tutorhardid = $ordertutors->course_id;
                                    }
                                   
                                    }
                                    
                            @endphp
                            @if(Auth::user()->role == 'user' &&  round($enrol->courses->offline_tutor/$money->amount) !=Null)
                              @if(empty($tutoroffid))
	                            @if(empty($cart))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-7 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="offline_tutor">Add offline tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->offline_tutor/$money->amount) }}</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-5 col-sm-6 col-6">-->
									    
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
								<!--				<form id="demo-form2" method="post" action="{{ route('offline_tutor',['course_id' => $course_id, 'price' => round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($enrol->courses->offline_tutor/$money->amount) }}" name="offline_tutor">-->
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


								
								<!--	</div>-->
								
				    <!--            </div>-->
                                @elseif(isset($cart) && $cart->offline_tutor == 0)
         <!--                       <div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="offline_tutor">Add offline tutor for 1 hour for<i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->offline_tutor/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->

									<!--<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#offlinetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

									
									<!--<div class="modal fade" id="offlinetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
         <!--                               <div class="modal-dialog modal-lg" role="document">-->
         <!--                                 <div class="modal-content">-->
         <!--                                   <div class="modal-header">-->
         <!--                                     <h4 class="modal-title" id="myModalLabel">Offline Tutor</h4>-->
         <!--                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
         <!--                                   </div>-->
         <!--                                   <div class="box box-primary">-->
         <!--                                     <div class="panel panel-sum">-->
         <!--                                       <div class="modal-body">-->
									<!--			<form id="demo-form2" method="post" action="{{ route('offline_tutor',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->offline_tutor/$money->amount) }}" name="offline_tutor">-->
									<!--					<div class="row">-->
									<!--						<div class="col-6">-->
									<!--							<div class="form-group">-->
									<!--							<label for="no_hours_off">No. of hours : </label>-->
									<!--							<select name="no_hours_off" id="no_hours_off" class="form-control js-example-basic-single" required>-->
                                                                
         <!--                                                       </select>-->
									<!--							</div>-->
									<!--						</div>-->
									<!--					</div>-->


         <!--                                               <hr>-->
         <!--                                               <div class="box-footer">-->
									<!--					<button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--                                   </button>-->
								 <!--                      </div>-->
         <!--                                           </form>-->
         <!--                                       </div>-->
         <!--                                     </div>-->
         <!--                                   </div>-->
         <!--                                 </div>-->
         <!--                               </div>-->
         <!--                           </div>-->

									<!--</div>-->
								
				     <!--           </div>-->
				                @endif
    				          @elseif(!empty($tutoroffid) && $enrol->courses->id!=$tutoroffid)
    				             @if(empty($cart))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-7 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="offline_tutor">Add offline tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->offline_tutor/$money->amount) }}</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-5 col-sm-6 col-6">-->

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
								<!--				<form id="demo-form2" method="post" action="{{ route('offline_tutor',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($enrol->courses->offline_tutor/$money->amount) }}" name="offline_tutor">-->
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

								<!--	</div>-->
								
				    <!--            </div>-->
                                @elseif(isset($cart) && $cart->offline_tutor == 0)
         <!--                       <div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="offline_tutor">Add offline tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->offline_tutor/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->

									<!--<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#offlinetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

									
									<!--<div class="modal fade" id="offlinetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
         <!--                               <div class="modal-dialog modal-lg" role="document">-->
         <!--                                 <div class="modal-content">-->
         <!--                                   <div class="modal-header">-->
         <!--                                     <h4 class="modal-title" id="myModalLabel">Offline Tutor</h4>-->
         <!--                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
         <!--                                   </div>-->
         <!--                                   <div class="box box-primary">-->
         <!--                                     <div class="panel panel-sum">-->
         <!--                                       <div class="modal-body">-->
									<!--			<form id="demo-form2" method="post" action="{{ route('offline_tutor',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->offline_tutor/$money->amount) }}" name="offline_tutor">-->
									<!--					<div class="row">-->
									<!--						<div class="col-6">-->
									<!--							<div class="form-group">-->
									<!--							<label for="no_hours_off">No. of hours : </label>-->
									<!--							<select name="no_hours_off" id="no_hours_off" class="form-control js-example-basic-single" required>-->
                                                                
         <!--                                                       </select>-->
									<!--							</div>-->
									<!--						</div>-->
									<!--					</div>-->


         <!--                                               <hr>-->
         <!--                                               <div class="box-footer">-->
									<!--					<button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--                                   </button>-->
								 <!--                      </div>-->
         <!--                                           </form>-->
         <!--                                       </div>-->
         <!--                                     </div>-->
         <!--                                   </div>-->
         <!--                                 </div>-->
         <!--                               </div>-->
         <!--                           </div>-->

									<!--</div>-->
								
				     <!--           </div>-->
				                @endif
							 @endif
				            @endif
				            @if(Auth::user()->role == 'user' &&  round($enrol->courses->online_tutor_one/$money->amount) !=Null)
                              
                              @if(empty($tutoronid))
	                            @if(empty($cart))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-7 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="online_tutor_one">Add Live tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->online_tutor_one/$money->amount) }}</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-5 col-sm-6 col-6">-->
									    
								<!--	 <button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#livetutor{{ $enrol->courses->id }}"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->
 
								<!--	<div class="modal fade" id="livetutor{{ $enrol->courses->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
        <!--                                <div class="modal-dialog modal-lg" role="document">-->
        <!--                                  <div class="modal-content">-->
        <!--                                    <div class="modal-header">-->
        <!--                                      <h4 class="modal-title" id="myModalLabel">Live Tutor</h4>-->
        <!--                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--                                    </div>-->
        <!--                                    <div class="box box-primary">-->
        <!--                                      <div class="panel panel-sum">-->
        <!--                                        <div class="modal-body">-->
        <!--                                       <form id="demo-form2" method="post" action="{{ route('online_tutor_one',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($enrol->courses->online_tutor_one/$money->amount) }}" name="online_tutor_one">-->

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
        <!--                                                <button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                                   </button>-->

								<!--                       </div>-->
        <!--                                            </form>-->
        <!--                                        </div>-->
        <!--                                      </div>-->
        <!--                                    </div>-->
        <!--                                  </div>-->
        <!--                                </div>-->
        <!--                            </div>-->
									
								<!--	</div>-->
								
				    <!--            </div>-->
                                @elseif(isset($cart) && $cart->online_tutor_one == 0)
         <!--                        <div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="online_tutor_one">Add Live tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->online_tutor_one/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->
									    
									<!--    	<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#livetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->


									<!--<div class="modal fade" id="livetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
         <!--                               <div class="modal-dialog modal-lg" role="document">-->
         <!--                                 <div class="modal-content">-->
         <!--                                   <div class="modal-header">-->
         <!--                                     <h4 class="modal-title" id="myModalLabel">Live Tutor</h4>-->
         <!--                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
         <!--                                   </div>-->
         <!--                                   <div class="box box-primary">-->
         <!--                                     <div class="panel panel-sum">-->
         <!--                                       <div class="modal-body">-->
         <!--                                       <form id="demo-form2" method="post" action="{{ route('online_tutor_one',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->online_tutor_one/$money->amount) }}" name="online_tutor_one">-->


									<!--					<div class="row">-->
									<!--						<div class="col-6">-->
									<!--							<div class="form-group">-->
									<!--							<label for="no_hours">No. of hours : </label>-->
									<!--							<select name="no_hours" id="no_hours" class="form-control js-example-basic-single" required>-->
                                                                
         <!--                                                       </select>-->
									<!--							</div>-->
									<!--						</div>-->
									<!--					</div>-->


         <!--                                               <hr>-->
         <!--                                               <div class="box-footer">-->
         <!--                                               <button type="submit" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--                                  </button>-->

								 <!--                      </div>-->
         <!--                                           </form>-->
         <!--                                       </div>-->
         <!--                                     </div>-->
         <!--                                   </div>-->
         <!--                                 </div>-->
         <!--                               </div>-->
         <!--                           </div>-->
									<!--</div>-->
								
				     <!--           </div>-->
				                @endif
    						 @elseif(!empty($tutoronid) && $enrol->courses->id!=$tutoronid)
    							@if(empty($cart))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-7 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="online_tutor_one">Add Live tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->online_tutor_one/$money->amount) }}</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-5 col-sm-6 col-6">-->
									    
								<!--	 <button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#livetutor{{ $enrol->courses->id }}"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->
 
								<!--	<div class="modal fade" id="livetutor{{ $enrol->courses->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
        <!--                                <div class="modal-dialog modal-lg" role="document">-->
        <!--                                  <div class="modal-content">-->
        <!--                                    <div class="modal-header">-->
        <!--                                      <h4 class="modal-title" id="myModalLabel">Live Tutor</h4>-->
        <!--                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--                                    </div>-->
        <!--                                    <div class="box box-primary">-->
        <!--                                      <div class="panel panel-sum">-->
        <!--                                        <div class="modal-body">-->
        <!--                                       <form id="demo-form2" method="post" action="{{ route('online_tutor_one',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($enrol->courses->online_tutor_one/$money->amount) }}" name="online_tutor_one">-->

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
        <!--                                                <button type="submit" class="btn btn-primary "><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                                   </button>-->

								<!--                       </div>-->
        <!--                                            </form>-->
        <!--                                        </div>-->
        <!--                                      </div>-->
        <!--                                    </div>-->
        <!--                                  </div>-->
        <!--                                </div>-->
        <!--                            </div>-->
									
								<!--	</div>-->
								
				    <!--            </div>-->
                                @elseif(isset($cart) && $cart->online_tutor_one == 0)
         <!--                        <div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="online_tutor_one">Add Live tutor for 1 hour for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->online_tutor_one/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->
									    
									<!--    	<button type="submit" class="btn btn-primary tutorcart" data-toggle="modal" data-target="#livetutor"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->


									<!--<div class="modal fade" id="livetutor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
         <!--                               <div class="modal-dialog modal-lg" role="document">-->
         <!--                                 <div class="modal-content">-->
         <!--                                   <div class="modal-header">-->
         <!--                                     <h4 class="modal-title" id="myModalLabel">Live Tutor</h4>-->
         <!--                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
         <!--                                   </div>-->
         <!--                                   <div class="box box-primary">-->
         <!--                                     <div class="panel panel-sum">-->
         <!--                                       <div class="modal-body">-->
         <!--                                       <form id="demo-form2" method="post" action="{{ route('online_tutor_one',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->online_tutor_one/$money->amount) }}" name="online_tutor_one">-->


									<!--					<div class="row">-->
									<!--						<div class="col-6">-->
									<!--							<div class="form-group">-->
									<!--							<label for="no_hours">No. of hours : </label>-->
									<!--							<select name="no_hours" id="no_hours" class="form-control js-example-basic-single" required>-->
                                                                
         <!--                                                       </select>-->
									<!--							</div>-->
									<!--						</div>-->
									<!--					</div>-->


         <!--                                               <hr>-->
         <!--                                               <div class="box-footer">-->
         <!--                                               <button type="submit" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--                                  </button>-->

								 <!--                      </div>-->
         <!--                                           </form>-->
         <!--                                       </div>-->
         <!--                                     </div>-->
         <!--                                   </div>-->
         <!--                                 </div>-->
         <!--                               </div>-->
         <!--                           </div>-->
									<!--</div>-->
								
				     <!--           </div>-->
				                @endif
							 @endif
				            @endif
				            
				             @if(Auth::user()->role == 'user' &&  round($enrol->courses->hard_course/$money->amount) !=Null)
                               @if(empty($tutorhardid))
	                            @if(empty($cart))
								<!--<div class="row no-gutters">-->
								<!--  <div class="col-lg-7 col-sm-6 col-6">-->
			     <!--                   	<div class="cart-course-detail">										-->
								<!--				  <div class="cart-course-update">-->
								<!--					<label for="hard_course">Get Hard copy of course materials for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->hard_course/$money->amount) }}</label>-->
				    <!--                              </div>				                        -->
				    <!--                    </div>-->
			     <!--                   </div>-->
								<!--	<div class="col-lg-5 col-sm-6 col-6">-->

								<!--	<form id="demo-form2" method="post" action="{{ route('hard_course',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
        <!--                                            data-parsley-validate class="form-horizontal form-label-left">-->
        <!--                                                {{ csrf_field() }}-->
								<!--						<input type="hidden" value="{{  round($enrol->courses->hard_course/$money->amount) }}" name="hard_course">-->
								<!--	<button type="submit" class="btn btn-primary tutorcart"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
        <!--                                             {{ __('frontstaticword.AddToCart') }}-->
				    <!--                </button>-->

				    <!--               </form>-->
								<!--	</div>-->
								
				    <!--            </div>-->
                                @elseif(isset($cart) && $cart->hard_course == 0)
         <!--                   	<div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="hard_course">Get Hard copy of course materials for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->hard_course/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->

									<!--<form id="demo-form2" method="post" action="{{ route('hard_course',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->hard_course/$money->amount) }}" name="hard_course">-->
									<!--<button type="submit" class="btn btn-primary tutorcart"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

				     <!--              </form>-->
									<!--</div>-->
								
				     <!--           </div>-->
				                @endif
  							  @elseif(!empty($tutorhardid) && $enrol->courses->id!=$tutorhardid)
  							     @if(empty($cart))
							  <!--  	<div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="hard_course">Get Hard copy of course materials for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->hard_course/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->

									<!--<form id="demo-form2" method="post" action="{{ route('hard_course',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->hard_course/$money->amount) }}" name="hard_course">-->
									<!--<button type="submit" class="btn btn-primary tutorcart"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

				     <!--              </form>-->
									<!--</div>-->
								
				     <!--           </div>-->
                                 @elseif(isset($cart) && $cart->hard_course == 0)
         <!--                       	<div class="row no-gutters">-->
								 <!-- <div class="col-lg-7 col-sm-6 col-6">-->
			      <!--                  	<div class="cart-course-detail">										-->
									<!--			  <div class="cart-course-update">-->
									<!--				<label for="hard_course">Get Hard copy of course materials for <i class="{{ $money['icon'] }}"></i> {{  round($enrol->courses->hard_course/$money->amount) }}</label>-->
				     <!--                             </div>				                        -->
				     <!--                   </div>-->
			      <!--                  </div>-->
									<!--<div class="col-lg-5 col-sm-6 col-6">-->

									<!--<form id="demo-form2" method="post" action="{{ route('hard_course',['course_id' => $course_id, 'price' =>  round($enrol->courses->price/$money->amount), 'discount_price' =>  round($enrol->courses->discount_price/$money->amount) ]) }}"-->
         <!--                                           data-parsley-validate class="form-horizontal form-label-left">-->
         <!--                                               {{ csrf_field() }}-->
									<!--					<input type="hidden" value="{{  round($enrol->courses->hard_course/$money->amount) }}" name="hard_course">-->
									<!--<button type="submit" class="btn btn-primary tutorcart"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;-->
         <!--                                            {{ __('frontstaticword.AddToCart') }}-->
				     <!--               </button>-->

				     <!--              </form>-->
									<!--</div>-->
								
				     <!--           </div>-->
				                 @endif
							  @endif
				            @endif
				             <?php
                                                    $progress = App\CourseProgress::where('course_id', $enrol->course_id)->where('user_id', Auth::User()->id)->first();
                                                    $review = App\ReviewRating::where('user_id', Auth::User()->id)->where('course_id', $enrol->course_id)->first();
                                                    if(!empty($progress)){
                                                    $total_class = $progress->all_chapter_id;
                                                    $total_count = count($total_class);

                                                    $total_per = 100;

                                                    $read_class = $progress->mark_chapter_id;
                                                    $read_count =  count($read_class);

                                                    $progres = ($read_count/$total_count) * 100;
                                                    }
                                                    else{
                                                        $progres = 0;
                                                    }
                                                    ?>
                                                   
				               @if(!empty($progress))
                      @if($progres == 100)
                      
                     @if(isset($review))
                     <a href="{{route('cirtificate.download',$enrol->course_id)}}" target="_blank"  class="btn btn-danger btm-20">Download Certificate</a>

                     @else            
                                  
                    <button type="submit" data-toggle="modal" data-target="#downloadCertificate" class="btn btn-danger btm-20">Download Certificate</button>
                    
                    
                     <div class="modal fade" id="downloadCertificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">Feedback Form</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="box box-primary">
                          <div class="panel panel-sum">
                            <div class="modal-body">
                           <div class="review-block">
                            <div class="row">
                                <div class="col-lg-2">
                                    <h5 class="top-20">{{ __('frontstaticword.Reviews') }}</h5>
                                </div>
                                <div class="col-lg-10 col-12">
                                    <form id="demo-form2" method="post" action="{{route('coursecert.rating',$enrol->course_id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        <div class="review-table top-20">
                                            <table class="table">
                                              <thead>
                                                <tr>
                                                  <th scope="col"></th>
                                                  <th scope="col">1 {{ __('frontstaticword.Star') }}</th>
                                                  <th scope="col">2 {{ __('frontstaticword.Star') }}</th>
                                                  <th scope="col">3 {{ __('frontstaticword.Star') }}</th>
                                                  <th scope="col">4 {{ __('frontstaticword.Star') }}</th>
                                                  <th scope="col">5 {{ __('frontstaticword.Star') }}</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <th scope="row">Accessibility</th>
                                                  <td><input type="radio" name="learn" value="1" id="option1" autocomplete="off"></td>
                                                  <td><input type="radio" name="learn" value="2" id="option2" autocomplete="off"></td>
                                                  <td><input type="radio" name="learn" value="3" id="option3" autocomplete="off"></td>
                                                  <td><input type="radio" name="learn" value="4" id="option4" autocomplete="off"></td>
                                                  <td><input type="radio" name="learn" value="5" id="option5" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                  <th scope="row">Quality</th>
                                                  <td><input type="radio" name="price" value="1" id="option6" autocomplete="off"></td>
                                                  <td><input type="radio" name="price" value="2" id="option7" autocomplete="off"></td>
                                                  <td><input type="radio" name="price" value="3" id="option8" autocomplete="off"></td>
                                                  <td><input type="radio" name="price" value="4" id="option9" autocomplete="off"></td>
                                                  <td><input type="radio" name="price" value="5" id="option10" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                  <th scope="row">Support</th>
                                                  <td><input type="radio" name="value" value="1" id="option11" autocomplete="off"></td>
                                                  <td><input type="radio" name="value" value="2" id="option12" autocomplete="off"></td>
                                                  <td><input type="radio" name="value" value="3" id="option13" autocomplete="off"></td>
                                                  <td><input type="radio" name="value" value="4" id="option14" autocomplete="off"></td>
                                                  <td><input type="radio" name="value" value="5" id="option15" autocomplete="off"></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <div class="review-text btm-30">
                                                <label for="review">{{ __('frontstaticword.Writereview') }}:</label>
                                                <textarea name="review" rows="4" class="form-control" placeholder=""></textarea>
                                            </div>
                                            <div class="review-rating-btn text-right">
                                                <button type="submit" class="btn btn-success" title="Review">{{ __('frontstaticword.Submit') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> 
                </div>
                     @endif
                     @endif
                  @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else

                        @php
                            $bundle_order = App\BundleCourse::where('id', $enrol->bundle_id)->first();
                        @endphp

                        @foreach($bundle_order->course_id as $bundle_course)
                          @php

                            $coursess = App\Course::where('id', $bundle_course)->first();

                          @endphp
                           
                            <div class="col-lg-3 col-sm-6">
                                        
                                <div class="view-block">
                                    <div class="view-img">
                                        @if($coursess['preview_image'] !== NULL && $coursess['preview_image'] !== '')
                                            <a href="{{url('show/coursecontent',$coursess->id)}}"><img src="{{ asset('images/course/'.$coursess->preview_image) }}" class="img-fluid" alt="student">
                                            </a>
                                        @else
                                            <a href="{{url('show/coursecontent',$coursess->id)}}"><img src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid" alt="student"></a>
                                        @endif
                                    </div>
                                    <div class="view-dtl" style="height: 170px">
                                        <div class="view-heading btm-10"><a href="{{url('show/coursecontent',$coursess->id)}}">{{ str_limit($coursess->title, $limit = 35, $end = '...') }}</a></div>
                                        <p class="btm-10"><a href="#">by {{ $coursess->user->fname }}</a></p>
                                        <div class="rating">
                                            <ul>
                                                <li>
                                                    <!-- star rating -->
                                                    <?php 
                                                    $learn = 0;
                                                    $price = 0;
                                                    $value = 0;
                                                    $sub_total = 0;
                                                    $sub_total = 0;
                                                    $reviews = App\ReviewRating::where('course_id',$coursess->id)->where('status','1')->get();
                                                    ?> 
                                                    @if(!empty($reviews[0]))
                                                        <?php
                                                        $count =  App\ReviewRating::where('course_id',$coursess->id)->count();

                                                        foreach($reviews as $review){
                                                            $learn = $review->price*5;
                                                            $price = $review->price*5;
                                                            $value = $review->value*5;
                                                            $sub_total = $sub_total + $learn + $price + $value;
                                                        }

                                                        $count = ($count*3) * 5;
                                                        $rat = $sub_total/$count;
                                                        $ratings_var = ($rat*100)/5;
                                                        ?>
                                        
                                                        <div class="pull-left">
                                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="pull-left">
                                                            {{ __('frontstaticword.NoRating') }}
                                                        </div>
                                                    @endif
                                                </li>
                                                <!-- overall rating -->
                                                @php
                                                $reviews = App\ReviewRating::where('course_id' ,$coursess->id)->get();
                                                @endphp
                                                <?php 
                                                $learn = 0;
                                                $price = 0;
                                                $value = 0;
                                                $sub_total = 0;
                                                $count =  count($reviews);
                                                $onlyrev = array();

                                                $reviewcount = App\ReviewRating::where('course_id', $coursess->id)->where('status',"1")->WhereNotNull('review')->get();

                                                foreach($reviewcount as $review){

                                                    $learn = $review->learn*5;
                                                    $price = $review->price*5;
                                                    $value = $review->value*5;
                                                    $sub_total = $sub_total + $learn + $price + $value;
                                                }

                                                $count = ($count*3) * 5;
                                                 
                                                if($count != "")
                                                {
                                                    $rat = $sub_total/$count;
                                             
                                                    $ratings_var = ($rat*100)/5;
                                           
                                                    $overallrating = ($ratings_var/2)/10;
                                                }
                                                 
                                                ?>

                                                @php
                                                    $reviewsrating = App\ReviewRating::where('course_id', $coursess->id)->first();
                                                @endphp
                                                @if(!empty($reviewsrating))
                                                <li>
                                                    <b>{{ round($overallrating, 1) }}</b>
                                                </li>
                                                @endif

                                                <li>
                                                    (@php
                                                        $data = App\Order::where('course_id', $coursess->id)->get();
                                                        if(count($data)>0){

                                                            echo count($data);
                                                        }
                                                        else{

                                                            echo "0";
                                                        }
                                                    @endphp)
                                                </li> 
                                            </ul>
                                        </div>

                                        <div class="mycourse-progress">

                                            <?php
                                                $progress = App\CourseProgress::where('course_id', $coursess->id)->where('user_id', Auth::User()->id)->first();
                                            ?>
                                            @if(!empty($progress))
                                                    
                                                <?php
                                                
                                                $total_class = $progress->all_chapter_id;
                                                $total_count = count($total_class);

                                                $total_per = 100;

                                                $read_class = $progress->mark_chapter_id;
                                                $read_count =  count($read_class);

                                                $progres = ($read_count/$total_count) * 100;
                                                ?>

                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $progres; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="complete"><?php echo $progres; ?>% Complete</div>
                                            @else
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="complete">Start Course</div>
                                            @endif

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @endif
                    
                    @else
    <section id="no-result-block" class="no-result-block">
        <div class="container">
            <div class="no-result-courses">{{ __('frontstaticword.whenenroll') }}&nbsp;<a href="{{ url('/') }}"><b>{{ __('frontstaticword.Browse') }}</b></a></div>
        </div>
    </section>
                    @endif




                @endforeach
            </div>
        </div>
    </section>
@else
    <section id="no-result-block" class="no-result-block">
        <div class="container">
            <div class="no-result-courses">{{ __('frontstaticword.whenenroll') }}&nbsp;<a href="{{ url('/') }}"><b>{{ __('frontstaticword.Browse') }}</b></a></div>
        </div>
    </section>
@endif
                     
                      
                      
                  </div>

                  <div class="tab-pane fade show" id="wish-tabs" role="tabpanel" aria-labelledby="coursehome-tab">
                      
@php
    $item = App\Wishlist::where('user_id', Auth::User()->id)->get();
    $course = App\Course::all();
        $wishlist = App\Wishlist::get();
        $ad = App\Adsense::first();
@endphp

@if(count($item) > 0)
<section id="learning-courses" class="learning-courses-main-block">
    <div class="container">
        <div class="row">
        	@foreach($wishlist as $wish)
        	 
        	@if($wish->user_id == Auth::User()->id)
                <div class="col-lg-3 col-sm-6 col-md-4">
                    <div class="view-block">
                        <div class="view-img">
                            @if($wish->courses['preview_image'] !== NULL && $wish->courses['preview_image'] !== '')
                                <a href="{{ route('user.course.show',['id' => $wish->courses->id, 'slug' => $wish->courses->slug ]) }}"><img src="{{ asset('images/course/'.$wish->courses->preview_image) }}" class="img-fluid" alt="course">
                            @else
                                <a href="{{ route('user.course.show',['id' => $wish->courses->id, 'slug' => $wish->courses->slug ]) }}"><img src="{{ Avatar::create($wish->courses->title)->toBase64() }}" class="img-fluid" alt="course">
                            @endif
                            </a>
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading btm-10"><a href="{{ route('user.course.show',['id' => $wish->courses->id, 'slug' => $wish->courses->slug ]) }}">{{ str_limit($wish->courses->title, $limit = 35, $end = '...') }}</a></div>
                            <!--<p class="btm-10"><a href="#">by {{ $wish->courses->user->fname }}</a></p>-->
                            <div class="rating">
                                <ul>
                                    <li>
                                        {{-- star rating --}}
                                        <?php 
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id',$wish->courses->id)->where('status','1')->get();
                                        ?> 
                                        @if(!empty($reviews[0]))
                                            <?php
                                            $count =  App\ReviewRating::where('course_id',$wish->courses->id)->count();

                                            foreach($reviews as $review){
                                                $learn = $review->price*5;
                                                $price = $review->price*5;
                                                $value = $review->value*5;
                                                $sub_total = $sub_total + $learn + $price + $value;
                                            }

                                            $count = ($count*3) * 5;
                                            $rat = $sub_total/$count;
                                            $ratings_var = ($rat*100)/5;
                                            ?>
                            
                                            <div class="pull-left">
                                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="pull-left">
                                                {{ __('frontstaticword.NoRating') }}
                                            </div>
                                        @endif
                                    </li>

                                    @php
                                    $reviews = App\ReviewRating::where('course_id' ,$wish->courses->id)->get();
                                    @endphp
                                    <?php 
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $wish->courses->id)->where('status',"1")->WhereNotNull('review')->get();

                                    foreach($reviewcount as $review){

                                        $learn = $review->learn*5;
                                        $price = $review->price*5;
                                        $value = $review->value*5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count*3) * 5;
                                     echo $count;
                                    if($count != "")
                                    {
                                        $rat = $sub_total;
                                        
                                          $ratings_var = ($rat*100)/5;
                                         $overallrating = ($ratings_var/2)/10;
                                    }
                                     
                                    ?>

                                    @php
                                        $reviewsrating = App\ReviewRating::where('course_id', $wish->courses->id)->first();
                                    @endphp
                                    @if(!empty($reviewsrating))
                                    <li >
                                        <b>{{ round($overallrating, 1) }}</b>
                                    </li>
                                    @endif
                                  
                                    <li style="display:none;">({{ $wish->order->count() }})</li> 
                                </ul>
                            </div>
                            @if($wish->courses->type == 1)
                            <div class="rate text-right">
                                <ul>
                                  
                                     @if( round($wish->courses->discount_price/$money->amount) == !NULL)

                                        <li class="rate-r"><s><i class="{{ $money['icon'] }}"></i>{{  round($wish->courses->price/$money->amount) }}</s></li>
                                        <li><b><i class="{{ $money['icon'] }}"></i>{{  round($wish->courses->discount_price/$money->amount) }}</b></li>
                                    @else
                                        <li><b><i class="{{ $money['icon'] }}"></i>{{  round($wish->courses->price/$money->amount) }}</b></li>
                                    @endif
                                </ul>
                            </div>
                            @else
                            <div class="rate text-right">
                                <ul>
                                  <li><b>{{ __('frontstaticword.Free') }}</b></li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="wishlist-action">
                        <div class="row">
                        	<div class="col-md-6 col-6">
                               
                                @if($wish->courses->type == 1)
                                <div class="cart-btn">
                                    <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $wish->courses->id, 'price' => $wish->courses->price, 'discount_price' => $wish->courses->discount_price ]) }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            
                                            <input type="hidden" name="category_id"  value="{{$wish->courses->category['id']}}" />
                                                
                                        
                                         <button type="submit" class="btn btn-primary"  title="Add To Cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                                @endif
                        	</div>
                        	<div class="col-md-6 col-6">
                                <div class="wishlist-btn txt-rgt">
                                    <form  method="post" action="{{url('delete/wishlist', $wish->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            	                        {{ csrf_field() }}
            	                        
            	                      <button type="submit" class="btn btn-primary " title="Remove From Wishlist"><i class="fa fa-trash"></i></button>
            	                    </form>
                                </div>
                        	</div>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="container-fluid" id="adsense">
        <!-- google adsense code -->
        <?php
          if (isset($ad)) {
           if ($ad->iswishlist==1 && $ad->status==1) {
              $code = $ad->code;
              echo html_entity_decode($code);
           }
          }
        ?>
    </div>
</section>
@else
    <section id="search-block" class="search-main-block search-block-no-result text-center">
        <div class="container">
            <div class="no-result-courses btm-10">{{ __('frontstaticword.emptywishlist') }}</div>
            <div class="recommendation-btn text-white text-center">
                <a href="{{ url('/') }}" class="btn btn-primary" title="search"><b>{{ __('frontstaticword.Browse') }}</b></a>
            </div> 
        </div>
    </section>
@endif
                      
                      
                  </div>

                  <div class="tab-pane fade show" id="purchase-tabs" role="tabpanel" aria-labelledby="coursehome-tab">
        @php
        $course = App\Course::where('user_id',Auth::User()->id)->get();
        $orders = App\Order::where('user_id',Auth::User()->id)->get();
        @endphp
        
<section id="purchase-block" class="purchase-main-block">
	<div class="container">
		<div class="purchase-table table-responsive">
	        <table class="table">
			  <thead>
			    <tr>
	                <th class="purchase-history-heading">{{ __('frontstaticword.PurchaseHistory') }}</th>
				    <th class="purchase-text">{{ __('frontstaticword.Enrollon') }}</th>
				    <th class="purchase-text">{{ __('frontstaticword.Enrollstart') }}</th>
				    <th class="purchase-text">{{ __('frontstaticword.Duedate') }}</th>
				    <!--<th class="purchase-text">{{ __('frontstaticword.EnrollEnd') }}</th>-->
				    <th class="purchase-text">{{ __('frontstaticword.PaymentMode') }}</th>
				    <th class="purchase-text">{{ __('frontstaticword.TotalPrice') }}</th>
				    <th class="purchase-text">{{ __('frontstaticword.PaymentStatus') }}</th>
				    <th class="purchase-text">{{ __('frontstaticword.Actions') }}</th>
				    
			    </tr>
			  </thead>
				
				@foreach($orders as $order)
				@if($order->user_id == Auth::User()->id)
		            <div class="purchase-history-table">
		            	<tbody>
			            	<tr>
				    			<td >
				                    <div class="purchase-history-course-img">
				                        @if($order->workshop_id != Null)
									        @if($order->workshops['preview_image'] !== NULL && $order->workshops['preview_image'] !== '')
				            					<a href="{{ route('detail.workshop.show',['id' => $order->workshops->id, 'slug' => $order->workshops->slug ]) }}"><img src="{{ asset('images/workshop/'. $order->workshops->preview_image) }}" class="img-fluid" alt="course"></a>
				            				@else
												<a href="{{ route('detail.workshop.show',['id' => $order->workshops->id, 'slug' => $order->workshops->slug ]) }}"><img src="{{ Avatar::create($order->workshops->title)->toBase64() }}" class="img-fluid" alt="course"></a>
				            				@endif
                                        @endif
				                    	@if($order->course_id != NULL)
					                    	@if($order->courses['preview_image'] !== NULL && $order->courses['preview_image'] !== '')
					                        	<a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}"><img src="{{ asset('images/course/'. $order->courses->preview_image) }}" class="img-fluid" alt="course"></a>
					                        @else
					                        	<a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}"><img src="{{ Avatar::create($order->courses->title)->toBase64() }}" class="img-fluid" alt="course"></a>
					                        @endif
										@elseif($order->bundle_id != Null)
				                        	@if($order->bundle['preview_image'] !== NULL && $order->bundle['preview_image'] !== '')
					                        	<a href="{{ route('bundle.detail', $order->bundle->id) }}"><img src="{{ asset('images/bundle/'. $order->bundle->preview_image) }}" class="img-fluid" alt="course"></a>
					                        @else
					                        	<a href="{{ route('bundle.detail', $order->bundle->id) }}"><img src="{{ Avatar::create($order->bundle->title)->toBase64() }}" class="img-fluid" alt="course"></a>
					                        @endif
					                    @endif

				                    </div>
				                    <div class="purchase-history-course-title">
				                        @if($order->workshop_id != Null)
										<a href="{{ route('detail.workshop.show',['id' => $order->workshops->id, 'slug' => $order->workshops->slug ]) }}">{{ $order->workshops->title }}</a>
                                        @endif
				                    	@if($order->course_id != NULL)
				                        <a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}">{{ $order->courses->title }}</a>
				                        @elseif($order->bundle_id != Null)
				                        <a href="{{ route('bundle.detail', $order->bundle->id) }}">{{ $order->bundle->title }}</a>
				                        @endif
				                    </div>
				                </td>
				                <td>
				                   	<div class="purchase-text">{{ date('jS F Y', strtotime($order->created_at)) }}</div>			                   	
				                </td>
                                <td>
				                   	<div class="purchase-text">
                                    	@if($order->course_id != NULL)
				                		@if($order->enroll_expire != NULL)
				                            {{ date('jS F Y', strtotime($order->enroll_start)) }}
				                        @else
				                            -
				                        @endif
				                        @endif				                   	</div>			                   	
				                </td>
				                <td>
				                	<div class="purchase-text">
				                		@if($order->course_id != NULL)
				                		@if($order->enroll_expire != NULL)
				                            {{ date('jS F Y', strtotime($order->enroll_expire)) }}
				                        @else
				                            -
				                        @endif
				                        @endif
				                	</div>
				                </td>

				                <td>   
				                    <div class="purchase-text">{{ $order->payment_method }}</div>
				                </td>

				              
				                
				                <td>
				                	@if($order->coupon_discount == !NULL)
				                    	<div class="purchase-text"><b><i class="fa {{ $order->currency_icon }}"></i>{{ $order->total_amount - $order->coupon_discount }}</b></div>
				                    @else
				                    	<div class="purchase-text"><b><i class="fa {{ $order->currency_icon }}"></i>{{ $order->total_amount }}</b></div>
				                    @endif

				                </td>

				                <td>
				                	<div class="purchase-text">
				                		@if($order->status ==1)
				                            {{ __('frontstaticword.Recieved') }}
				                        @else
				                            {{ __('frontstaticword.Pending') }}
				                        @endif
				                	</div>
				                </td>
				               
				                <td>
				                    <div class="invoice-btn">
				                    	
				                    	<a href="{{route('invoice.show',$order->id)}}"  class="btn btn-secondary">{{ __('frontstaticword.Invoice') }}</a>
				                    	
				                    </div>

				                </td>
				                
				               
				            </tr>
				        </tbody>
		            </div>
	            @endif
	            @endforeach
	        </table>
        </div>
	</div>
</section>
        
                </div>

                <div class="tab-pane fade show" id="profile-tabs" role="tabpanel" aria-labelledby="coursehome-tab">
        
        @php
        $course = App\Course::all();
            $countries = App\Country::all();
            $states = App\State::all();
            $cities = App\City::all();
            $orders = App\User::where('id', Auth::User()->id)->first();
        @endphp

<section id="profile-item" class="profile-item-block">
    <div class="container">
    	<form action="{{ route('user.profile',$orders->id) }}" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }}
            {{ method_field('PUT') }}

	        <div class="row">
	            <div class="col-xl-3 col-lg-4">
	                <div class="dashboard-author-block text-center">
	                    <div class="author-image">
						    <div class="avatar-upload">
						        <div class="avatar-edit">
						            <input type='file' id="imageUpload" name="user_img" accept=".png, .jpg, .jpeg" />
						            <label for="imageUpload"><i class="fa fa-pencil"></i></label>
						        </div>
						        <div class="avatar-preview">
						        	@if(Auth::User()->user_img != null || Auth::User()->user_img !='')
							            <div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ url('/images/user_img/'.Auth::User()->user_img) }});">
							            </div>
							        @else
							        	<div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ asset('images/default/user.jpg')}});">
							            </div>
							        @endif
						        </div>
						         @error('user_img')
                                  <span class="text-danger">{{$message}}</span>
                                 @enderror
						    </div>
	                    </div>
	                    <div class="author-name">{{ Auth::User()->fname }}&nbsp;{{ Auth::User()->lname }}</div>
	                </div>
	                <div class="dashboard-items">
	                    <ul>
	                        <li><i class="fa fa-bookmark"></i><a href="{{ route('mycourse.show') }}" title="Dashboard">{{ __('frontstaticword.MyCourses') }}</a></li>
	                        <li><i class="fa fa-heart"></i><a href="{{ route('wishlist.show') }}" title="Profile Update">{{ __('frontstaticword.MyWishlist') }}</a></li>
	                        <li><i class="fa fa-history"></i><a href="{{ route('purchase.show') }}" title="Followers">{{ __('frontstaticword.PurchaseHistory') }}</a></li>
	                        <li><i class="fa fa-user"></i><a href="{{route('profile.show',Auth::User()->id)}}" title="Upload Items">{{ __('frontstaticword.UserProfile') }}</a></li>
	                        @if(Auth::User()->role == "user")
	                        <!--<li><i class="fas fa-chalkboard-teacher"></i><a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a></li>-->
	                        @endif
	                         <li><i class="fa fa-gift"></i>
							<a href="{{route('rewards.show',Auth::user()->id)}}">Refer a friend</a>
						    </li>
	                    </ul>
	                </div>
	            </div>
	            <div class="col-xl-9 col-lg-8">

	                <div class="profile-info-block">
	                    <div class="profile-heading">{{ __('frontstaticword.PersonalInfo') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="name">{{ __('frontstaticword.FirstName') }}</label>
	                                <input type="text" id="name" name="fname" class="form-control form-control-sm" placeholder="Enter First Name" value="{{ $orders->fname }}">
	                                <small class="text-danger">* Enter name as per your SSLC certificate</small>
	                            </div>
	                            <div class="form-group">
	                                <label for="email">{{ __('frontstaticword.Email') }}</label>
	                                <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="info@example.com" value="{{ $orders->email }}" >
	                            </div>
	                            <div class="form-group">
	                                <label for="email">{{ __('frontstaticword.DateofBirth') }}</label>
	                                <input type="date" id="date" name="dob" class="form-control form-control-sm" placeholder="" value="{{ $orders->dob }}" >
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="Username">{{ __('frontstaticword.LastName') }}</label>
	                                <input type="text" id="lname" name="lname" class="form-control form-control-sm" placeholder="Enter Last Name" value="{{ $orders->lname }}">
	                            </div>
	                            <div class="form-group">
	                                <label for="mobile">{{ __('frontstaticword.Mobile') }}</label>
	                                <input type="text" name="mobile" id="mobile" value="{{ $orders->mobile }}" class="form-control form-control-sm" placeholder="Enter Mobile No.">
	                            </div>
	                            <div class="form-group">
					               <label for="gender">{{ __('frontstaticword.ChooseGender') }}:</label>
					                <br>
					                <input type="radio" name="gender" id="ch1" value="m" {{ $orders->gender == 'm' ? 'checked' : '' }}> {{ __('frontstaticword.Male') }}
					                <br>
					                <input type="radio" name="gender" id="ch2" value="f" {{ $orders->gender == 'f' ? 'checked' : '' }}> {{ __('frontstaticword.Female') }}
					                <br>
					                <input type="radio" name="gender" id="ch3" value="o" {{ $orders->gender == 'o' ? 'checked' : '' }}> {{ __('frontstaticword.Other') }}
					            </div>
	                            
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="bio">{{ __('frontstaticword.address') }}</label>
	                        <textarea id="address" name="address" class="form-control form-control-sm" placeholder="Enter your Address" value="">{{ $orders->address }}</textarea>
	                    </div>
	                    <br>

	                    <div class="row">
	                       <div class="col-lg-4">
	                        	<div class="form-group">
	                                <label for="city_id">{{ __('frontstaticword.Country') }}:</label>
					                <select id="country_id" class="form-control form-control-sm custom-select js-example-basic-single my_select" name="country_id">
					                  	<option value="none" selected disabled hidden> 
					                      {{ __('frontstaticword.SelectanOption') }}
					                    </option>
					                  
					                  @foreach ($countries as $coun)
					                    <option value="{{ $coun->country_id }}" {{ $orders->country_id == $coun->country_id ? 'selected' : ''}}>{{ $coun->nicename }}
					                    </option>
					                  @endforeach
					                </select>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                        		<label for="city_id">{{ __('frontstaticword.State') }}:</label>
					                <select id="upload_id" class="form-control form-control-sm js-example-basic-single my_select" name="state_id">
					                  <option value="none" selected disabled hidden> 
					                    {{ __('frontstaticword.SelectanOption') }}
					                  </option>
					                  @foreach ($states as $s)
					                    <option value="{{ $s->id}}" {{ $orders->state_id==$s->id ? 'selected' : '' }}>{{ $s->name}}</option>
					                  @endforeach

					                </select>
	                        	</div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                        		<label for="city_id">{{ __('frontstaticword.City') }}:</label>
					                <select id="grand" class="form-control form-control-sm js-example-basic-single my_select" name="city_id">
					                  <option value="none" selected disabled hidden> 
					                    {{ __('frontstaticword.SelectanOption') }}
					                  </option>
					                  @foreach ($cities as $c)
					                    <option value="{{ $c->id }}" {{ $orders->city_id == $c->id ? 'selected' : ''}}>{{ $c->name }}
					                    </option>
					                  @endforeach
					                </select>
	                        	</div>
	                        </div>
	                    </div>
	                    <!--<div class="form-group">-->
	                    <!--    <label for="bio">{{ __('frontstaticword.AuthorBio') }}</label>-->
	                    <!--    <textarea id="detail" name="detail" class="form-control form-control-sm" placeholder="Enter your details" value="">{{ $orders->detail }}</textarea>-->
	                    <!--</div>-->
	                    <br>
	                    
	                    <label for="">Education Details : </label>
						<div class="row">
							<div class="col-lg-4">
							<label for="qualification">Highest Qualification : </label>
							<input type="text" id="qualification" name="qualification" class="form-control" placeholder="Highest Qualification" value="{{ $orders->qualification }}">

							</div>
							<div class="col-lg-4">
							<label for="school_name">University/School Name : </label>
							<input type="text" id="school_name" name="school_name" class="form-control" placeholder="University/School Name" value="{{ $orders->school_name }}">

							</div>
							<div class="col-lg-4">
							<label for="education_city">City : </label>
							<input type="text" id="education_city" name="education_city" class="form-control" placeholder="University/School City" value="{{ $orders->education_city }}">

							</div>
						</div>
						<br>
						<label for="">Employment Details : </label>
						<div class="row">
							<div class="col-lg-6">
							<label for="organization">Organization : </label>
							<input type="text" id="organization" name="organization" class="form-control" placeholder="Organization name" value="{{ $orders->organization }}">
							</div>
							<div class="col-lg-6">
							<label for="designation">Designation : </label>
							<input type="text" id="designation" name="designation" class="form-control" placeholder="Designation" value="{{ $orders->designation }}">
							</div>
						</div>
						<br>


	                    <div class="row">
		                    <div class="col-lg-12">
		                      <div class="update-password">
		                        <label for="box1"><b>{{ __('frontstaticword.UpdatePassword') }}:</b></label>
		                        <input type="checkbox" name="update_pass" id="myCheck" onclick="myFunction()">
		                      </div>
		                    </div>
		                </div>
		                <div class="password display-none" id="update-password">
			                <div class="row">
				                <div class="col-lg-6">
					                <div class="form-group">
						                <label for="confirmpassword">{{ __('frontstaticword.Password') }}:</label>
										  <input name="password" class="form-control form-control-sm" id="password" type="password" placeholder="Enter Password" onkeyup='check();' />
										</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>{{ __('frontstaticword.ConfirmPassword') }}:</label>
										  <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-sm" placeholder="Confirm Password" onkeyup='check();' /> 
										  <span id='message'></span>
										</label>
									</div>
								</div>
							</div>
		            	</div>
		                <br>
	                </div>
	                <div class="social-profile-block">
	                    <div class="social-profile-heading">{{ __('frontstaticword.SocialProfile') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="facebook">{{ __('frontstaticword.FacebookUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="https://www.facebook.com/{{ $orders->fb_url }}" target="_blank" title="facebook"><i class="fa fa-facebook facebook"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="fb_url" value="{{ $orders->fb_url }}" id="facebook" class="form-control form-control-sm" placeholder="Facebook.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="behance2">{{ __('frontstaticword.YoutubeUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="https://www.youtube.com/
{{ $orders->youtube_url }}" target="_blank" title="googleplus"><i class="fab fa-youtube youtube"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="youtube_url" value="{{ $orders->youtube_url }}" id="behance2" class="form-control form-control-sm" placeholder="youtube.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="twitter">{{ __('frontstaticword.TwitterUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="https://www.twitter.com/{{ $orders->twitter_url }}" target="_blank" title="twitter"><i class="fab fa-twitter twitter"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="twitter_url" value="{{ $orders->twitter_url }}" id="twitter" class="form-control form-control-sm" placeholder="Twitter.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="dribbble2">{{ __('frontstaticword.LinkedInUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="https://in.linkedin.com/{{ $orders->linkedin_url }}" target="_blank" title="linkedin"><i class="fab fa-linkedin-in linkedin"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="linkedin_url" value="{{ $orders->linkedin_url }}" id="dribbble2" class="form-control form-control-sm" placeholder="Linkedin.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <div class="upload-items text-right">
	                    <button type="submit" class="btn btn-primary" title="upload items">{{ __('frontstaticword.UpdateProfile') }}</button>
	                </div>
	                
	            </div>
	        </div>

        </form>
    </div>
</section>

                </div>
           
      </div>
  

<!-- about-home end -->




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

<script>
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/dropdown') }}';
    $('#country_id').change(function() {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });
  })(jQuery);

</script>

<script>
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/gcity') }}';
    $('#upload_id').change(function() {
      var up = $('#grand').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });
  })(jQuery);

</script>
@endsection

