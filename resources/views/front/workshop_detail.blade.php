@extends('theme.master')
@section('title', "$course->title")
@section('content')

@include('admin.message')
<!-- course detail header start -->
<section id="about-home" class="about-home-main-block">
    <div class="container">
        
          
        <div class="row">
            <div class="col-lg-8">
                <div class="about-home-block text-white">
                    <h1 class="about-home-heading text-white">{{ $course['title'] }}</h1>
                    <p>{{ $course['short_detail'] }}</p> 

                  
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">
                <div class="about-home-icon text-white text-right" >
                   
                </div>
                
                <div class="about-home-product" style="width:100%;">
                    <div class="video-item hidden-xs">
                        <script type="text/javascript">
                        @if($course->video !="")
                        //var video_url = '<iframe src="{{ asset('video/preview/'.$course['video']) }}" frameborder="0" allowfullscreen></iframe>';
                        var video_url = '<iframe src="{{ env('AWS_URL').('video/preview/'.$course['video']) }}" frameborder="0" allowfullscreen></iframe>';
                        @endif
                        @if($course->url !="")
                        var video_url = '<iframe src="{{ str_replace('watch?v=','embed/',$course['url']) }}" frameborder="0" allowfullscreen></iframe>';
                        @endif
                        </script>

                        <div class="video-device">
                            @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                                {{--<img src="{{ asset('images/workshop/'.$course['preview_image']) }}" class="bg_img img-fluid" alt="Background">--}}
                                <img src="{{ env('AWS_URL').('Storage/images/workshop/'.$course['preview_image']) }}" class="bg_img img-fluid" alt="Background">
                            @else
                                <img src="{{ Avatar::create($course->title)->toBase64() }}" class="bg_img img-fluid" alt="Background">
                            @endif
                            @if($course->video !="" || $course->url !="")
                            <div class="video-preview">
                                <a href="javascript:void(0);" class="btn-video-play"><i class="fa fa-play"></i></a>
                            </div>
                            @endif
                        </div>
                    </div>
               
                     
                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">
                        @if($course->type == 1)
                            <div class="about-home-rate mb-3">
                                <ul>
                                    
                                    @if( round($course->discount_price/$money->amount) == !NULL) 
                                        <li><i class="{{ $money['icon'] }}"></i>{{  round($course->discount_price/$money->amount) }}</li>
                                        <li><span><s><i class="{{ $money->icon }}"></i>{{  round($course->price/$money->amount) }}</s></span></li>
                                    @else
                                        <li><i class="{{ $money['icon'] }}"></i>{{  round($course->price/$money->amount) }}</li>
                                    @endif

                                </ul>
                            </div>
                            @if(Auth::check())
                                @if(Auth::User()->role == "admin")
                                    <div class="about-home-btn btm-20">
                                        <!--<a href="" class="btn btn-secondary" title="course">{{ __('frontstaticword.GoToCourse') }}</a>-->
                                    </div>
                                @else
                                    @if(isset($course->duration))
                                    <div class="course-duration btm-10">{{ __('frontstaticword.EnrollDuration') }}: {{ $course->duration }} Months</div>
                                    @endif

                                    
                                    @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('workshop_id', $course->id)->first();
                                    @endphp
                                   

                                    @if(!empty($order) && $order->status == 1)
                                       
                                        <div class="about-home-btn btm-20">
                                            <a href="" class="btn btn-secondary" title="course">You are enrolled</a>
                                        </div>
                                    
                                    @elseif(!empty($order) && $order->status == 0)
                                     <div class="about-home-btn btm-20">
                                            <a href="" class="btn btn-secondary" title="course">Order Confirmation Pending</a>
                                     </div>
                                    @else
                                        @php
                                            $cart = App\Cart::where('user_id', Auth::User()->id)->where('workshop_id', $course->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                            <div class="about-home-btn btm-20">
                                                <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                    {{ csrf_field() }}
                                                            
                                                    <div class="box-footer">
                                                     <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.RemoveFromCart') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="about-home-btn btm-20">
                                                <form id="demo-form2" method="post" action="{{ route('addtocart',['workshop_id' => $course->id, 'price' =>  round($course->price/$money->amount), 'discount_price' =>  round($course->discount_price/$money->amount)]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                    <input type="hidden" name="workshop_id"  value="{{ $course->id }}" />
                                                           
                                                    <div class="box-footer">
                                                     @if($course->featured != 0)
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.AddToCart') }}</button>
                                                     @endif    
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    
                                    @endif


                                @endif
                            @else
                                <div class="about-home-btn btm-20">
                                    <a href="{{ route('login') }}" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.AddToCart') }}</a>
                                </div>
                            @endif
                        @else
                            <div class="about-home-rate">
                                <ul>
                                    <li>Free</li>
                                </ul>
                            </div>
                            @if(Auth::check())
                                @if(Auth::User()->role == "admin")
                                    <div class="about-home-btn btm-20">
                                        <!--<a href="" class="btn btn-secondary" title="course">{{ __('frontstaticword.GoToCourse') }}</a>-->
                                    </div>
                                @else
                                    @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('workshop_id', $course->id)->first();
                                    @endphp
                                    @if($enroll == NULL)
                                        <div class="about-home-btn btm-20">
                                            <a href="{{url('enroll/show',$course->id)}}" class="btn btn-primary" title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                        </div>
                                    @else
                                        <div class="about-home-btn btm-20">
                                            <!--<a href="" class="btn btn-secondary" title="Cart">{{ __('frontstaticword.GoToCourse') }}            -->
                                             </a>
                                        </div>
                                    @endif
                                @endif
                            @else
                                <div class="about-home-btn btm-20">
                                    <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                </div>
                            @endif
                        @endif
                            <div class="about-home-includes-list btm-40">
                                <ul class="btm-40">
                                    @if($workshopinclude->isNotEmpty())
                                        <li><span>Workshop Includes</span></li>
                                        @foreach($course->include as $in)
                                            @if($in->status ==1)
                                                <li><i class="fa {{ $in->icon }}"></i>{{ str_limit($in->detail, $limit = 50, $end = '...') }}</li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <hr>
                                   

                        </div>
                    </div>
                    
                    <div class="container-fluid" id="adsense">
                        <!-- google adsense code -->
                        <?php
                          if (isset($ad)) {
                           if ($ad->isdetail==1 && $ad->status==1) {
                              $code = $ad->code;
                              echo html_entity_decode($code);
                           }
                          }
                        ?>
                    </div>
                </div>
                <br>
                
            </div>
        </div>
    </div>
</section>
<!-- course header end -->
<!-- course detail start -->



<section id="about-product" class="about-product-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($workwhatlearn->isNotEmpty())
                    <div class="product-learn-block">
                        <h3 class="product-learn-heading">{{ __('frontstaticword.Whatlearn') }}</h2>
                        <div class="row">
                            @foreach($course['whatlearns'] as $wl)
                            @if($wl->status ==1)
                            <div class="col-lg-10 col-md-6">
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i class="fa fa-check"></i>{{ str_limit($wl['detail'], $limit = 320, $end = '...') }}</li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="requirements">
                    <h3>{{ __('frontstaticword.Eligible') }}</h3>
                    <ul>
                        <li class="comment more">
                            @if(strlen($course->requirement) > 400)
                            {{substr($course->requirement,0,400)}}
                            <span class="read-more-show hide_content"><br>+&nbsp;See More</span>
                            <span class="read-more-content"> {{substr($course->requirement,400,strlen($course->requirement))}}
                            <span class="read-more-hide hide_content"><br>-&nbsp;See Less</span> </span>
                            @else
                            {{$course->requirement}}
                            @endif
                        </li>
                       
                    </ul>
                </div>
                <div class="description-block btm-30">
                    <h3>{{ __('frontstaticword.Description') }}</h3>

                    <p>{!! $course->detail !!}</p>
               
                </div>

               
            </div>

        </div>
    </div>
</section>
<!-- course detail end -->
@endsection


@section('custom-script')


<script>
// Hide the extra content initially, using JS so that if JS is disabled, no problemo:
    $('.read-more-content').addClass('hide_content')
    $('.read-more-show, .read-more-hide').removeClass('hide_content')

    // Set up the toggle effect:
    $('.read-more-show').on('click', function(e) {
      $(this).next('.read-more-content').removeClass('hide_content');
      $(this).addClass('hide_content');
      e.preventDefault();
    });

    // Changes contributed by @diego-rzg
    $('.read-more-hide').on('click', function(e) {
      var p = $(this).parent('.read-more-content');
      p.addClass('hide_content');
      p.prev('.read-more-show').removeClass('hide_content'); // Hide only the preceding "Read More"
      e.preventDefault();
    });
</script>

<script>
(function($) {
  "use strict";
  $(document).ready(function(){
    
    $(".group1").colorbox({rel:'group1'});
    $(".group2").colorbox({rel:'group2', transition:"fade"});
    $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
    $(".group4").colorbox({rel:'group4', slideshow:true});
    $(".ajax").colorbox();
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
    $(".iframe").colorbox({iframe:true, width:"50%", height:"50%"});
    $(".inline").colorbox({inline:true, width:"50%"});
    $(".callbacks").colorbox({
      onOpen:function(){ alert('onOpen: colorbox is about to open'); },
      onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
      onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
      onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
      onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
    });

    $('.non-retina').colorbox({rel:'group5', transition:'none'})
    $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
    
    
    $("#click").click(function(){ 
      $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
      return false;
    });
  });
})(jQuery);
</script>


<script type="text/javascript">
    $(document).ready(function() {
  $(this).on("click", ".koh-faq-question", function() {
    $(this).parent().find(".koh-faq-answer").toggle();
    $(this).find(".fa").toggleClass('active');
  });
});
</script>
@endsection


<style type="text/css">
    .read-more-show{
      cursor:pointer;
      color: #0284A2;
    }
    .read-more-hide{
      cursor:pointer;
      color: #0284A2;
    }

    .hide_content{
      display: none;
    }

</style>