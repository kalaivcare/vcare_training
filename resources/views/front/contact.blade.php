@extends('theme.master')
@section('title', 'Contact Us')
@section('content')

@include('admin.message')

<!-- about-home start -->
<section id="wishlist-home" class="wishlist-home-main-block">
    <div class="container">
        <h1 class="wishlist-home-heading text-white">{{ __('frontstaticword.Contactus') }}</h1>
    </div>
</section> 
<!-- about-home end -->
<!-- contact-us start-->
<section id="contact-us" class="contact-us-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-6">
                <!--@if($gsetting->map_enable == 'map')-->
               
                <!--    <section id="location" class="map-location btm-30"></section>-->
               
                <!--@elseif($gsetting->map_enable == 'image')-->
                <!--    <img src="{{ asset('images/contact/'.$gsetting->contact_image) }}" class="img-fluid">-->
                <!--@endif-->
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.0633408569033!2d80.16634107479551!3d13.09517221215762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a526324c58be91f%3A0x40f6a90a4bf84ae7!2sVCare%20Group%20-%20Corporate%20Office!5e0!3m2!1sen!2sin!4v1755784011673!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
            <div class="col-lg-5 col-md-6">
                <h4 class="contact-us-heading">{{ __('frontstaticword.KeepinTouch') }}</h4>
                <form id="demo-form2" method="post" action="{{ route('contact.user') }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if(Auth::check())
                    <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                    @else
                    <input type="hidden" name="user_id"  value="guest" />
                    @endif
                    <?php $check = encrypt('nihaws'); ?>
                    	<input name="check" id="check" type="hidden" placeholder="Enter your name" value="{{$check}}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Name" value="{{old('fname')}}">
                          @error('fname')
                            <span class="text-danger">{{$message}}</span>
                          @enderror
                          
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Phone" value="{{old('mobile')}}">
                        @error('mobile')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" value="{{old('email')}}">
                          @error('email')
                            <span class="text-danger">{{$message}}</span>
                          @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="{{old('subject')}}">
                          @error('subject')
                            <span class="text-danger">{{$message}}</span>
                          @enderror
                    </div>
                    <div class="comment btm-20">
                        <textarea id="comment" name="message" class="form-control" rows="6" placeholder="Your Message">{{old('message')}}</textarea>
                        @error('message')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                     {{-- @if($gsetting->captcha_enable == 1)
                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        {!! app('captcha')->display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                    @endif --}}
                    
                    <div class="contact-form-btn">
                        <button type="submit" class="btn btn-primary" title="Send Message">{{ __('frontstaticword.Message') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="contact-dtl">
            <h4 class="contact-us-heading btm-40">{{ __('frontstaticword.ContactDetails') }}</h4>
            <div class="row">
                <div class="offset-lg-1 col-lg-3 col-md-4">
                    <ul>
                        <li class="btm-10"><i class="fa fa-map-marker"></i></li>
                        <li class="btm-10 caps">{{ __('frontstaticword.address') }}</li>
                        <li class="btm-40">{{ $gsetting->default_address }}</li>
                    </ul>
                </div>
                <div class="offset-lg-1 col-lg-3 col-md-4">
                    <ul>
                        <li class="btm-10"><i class="fa fa-envelope"></i></li>
                        <li class="btm-10 caps">{{ __('frontstaticword.Email') }} </li>
                        <li class="btm-40">{{ $gsetting->wel_email }}</li>
                    </ul>
                </div>
                <div class="offset-lg-1 col-lg-3 col-md-4">
                    <ul>
                        <li class="btm-10"><i class="fa fa-phone"></i></li>
                        <li class="btm-10 caps">{{ __('frontstaticword.Phone') }}</li>
                        <li class="btm-40">{{ $gsetting->default_phone }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact us end -->

@endsection

@section('custom-script')


<script>
    
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
   script.src = "https://maps.googleapis.com/maps/api/js?key={{ $gsetting['map_api'] }}&libraries=places&callback=initialize";
    //script.src="https://www.google.com/maps/place/HDFC+BANK/@13.0955389,80.1675785,17z/data=!4m12!1m6!3m5!1s0x3a5267d4463a2ccd:0xde415ed07c1663da!2sNIHAWS+-+National+Institute+Of+Health+And+Wellness!8m2!3d13.0955337!4d80.1697672!3m4!1s0x3a5263ebe3c62e97:0x3f1e65420108b1c5!8m2!3d13.0956292!4d80.1697538?hl=en"
    document.body.appendChild(script);
  });
  function initialize(){
    var myLatLng = {lat: {{ $gsetting['map_lat'] }}, lng: {{ $gsetting['map_long'] }}}; // Insert Your Latitude and Longitude For Footer Wiget Map
    var mapOptions = {
      center: myLatLng, 
      zoom: 15,
      disableDefaultUI: true,
      scrollwheel: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]     
    }
    // For Footer Widget Map
    var map = new google.maps.Map(document.getElementById("location"), mapOptions);
    var image = 'images/icons/map.png';
    var beachMarker = new google.maps.Marker({
      position: myLatLng, 
      map: map,   
      icon: image
    });    
  }
</script>
<!-- end jquery -->

@endsection
