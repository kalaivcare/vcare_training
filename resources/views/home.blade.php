@extends('theme.master')
@section('title', 'Online Courses')
@section('content')

    @include('admin.message')
    <!-- categories-tab start-->
    <!-- categories-tab end-->
    @php
        $sliders = App\Slider::orderBy('position', 'ASC')->get();
    @endphp
    @if (isset($sliders))
        <!--<section id="home-background-slider" class="background-slider-block owl-carousel">-->
        <!--    <div class="item home-slider-img">-->
        <!--        @foreach ($sliders as $slider)
    -->
        <!--        @if ($slider->status == 1)
    -->
        <!--        <div id="home" class="home-main-block" style="background-image: url('{{ asset('images/slider/' . $slider['image']) }}')">-->
        <!--            <div class="container">-->
        <!--                <div class="row">-->
        <!--                    <div class="col-lg-12">-->
        <!--                        <div class="home-dtl">-->
        <!--                            <div class="home-heading text-white">{{ $slider['heading'] }}</div>-->
        <!--                            <p class="text-white btm-10">{{ $slider['sub_heading'] }}</p>-->
        <!--                            <p class="text-white btm-20">{{ $slider['detail'] }}</div>-->

        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--
    @endif-->
        <!--
    @endforeach-->
        <!--    </div>-->
        <!--</section>-->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($sliders as $slider)
                    @if ($slider->status == 1)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ asset('images/slider/' . $slider['image']) }}"
                                alt="Integrated Development Program" width="100%" height="100%">
                            {{-- <img class="d-block w-100" src="{{ env('AWS_URL').('Storage/images/slider/'.$slider['image']) }}"  alt="Nihaws Banner" width="100%" height="100%"> --}}
                        </div>
                    @endif
                @endforeach

            </div>
        </div>

    @endif

    <!-- home end -->
    <!-- learning-work start -->
    @php
        $facts = App\SliderFacts::limit(3)->get();
    @endphp
    @if (isset($facts))
        {{-- <section id="learning-work" class="learning-work-main-block">
    <div class="container">
        <div class="row">
            @foreach ($facts as $fact)
            <div class="col-lg-4 col-sm-6 fact-margin">
                <div class="learning-work-block text-white">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="learning-work-icon">
                                <i class="fa {{ $fact['icon'] }}"></i>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9" style="padding-left: 0px;">
                            <div class="learning-work-dtl">
                                <div class="work-heading">{{ $fact['heading'] }}</div>
                                <p>{{ $fact['sub_heading'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section> --}}
    @endif
    <!-- learning-work end -->
    <!-- learning-courses start -->
    @php
        $categories = App\CategorySlider::first();
        // @dd($categories);
    @endphp
    @if (isset($categories))
        <section id="learning-courses" class="learning-courses-main-block">
            <div class="container">
                <div class="row">
                    @php
                        $items = App\CourseText::first();
                    @endphp
                    @if (isset($items))
                        <!--<div class="col-lg-3">-->
                        <!--    <div class="learning-selection">-->
                        <!--        <div class="selection-heading">{{ $items['heading'] }}</div>-->
                        <!--        <p>{{ $items['sub_heading'] }}</p>-->
                        <!--    </div>-->
                        <!--</div>-->
                    @endif
                    <div class="col-lg-12">
                        <div class="learning-courses">
                            @php
                                $categories = App\CategorySlider::first();
                                // print_r($categories);
                            @endphp
                            @if (isset($categories->category_id))
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($categories->category_id as $cate)
                                        @php
                                            $cats = App\Categories::find($cate);
                                        @endphp
                                        @if ($cats && $cats['status'] == 1)
                                            <li class="btn nav-item">
                                                <a class="nav-item nav-link" id="home-tab" data-toggle="tab"
                                                    href="#content-tabs" role="tab" aria-controls="home"
                                                    onclick="showtab('{{ $cats->id }}')" aria-selected="true">
                                                    {{-- {{ $cats['title'] }} --}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="tab-content" id="myTabContent">
                            @if (!empty($categories))
                                @foreach ($categories->category_id as $cate)
                                    <div class="tab-pane fade show active" id="content-tabs" role="tabpanel"
                                        aria-labelledby="home-tab">

                                        <div id="tabShow">

                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- learning-courses end -->
    <!-- Student start -->
    <!-- Students end -->

    <!-- Bundle start -->
    <section id="student" class="student-main-block">
        <div class="container">

            @php
                $bundles = App\BundleCourse::get();
                // print_r($bundles)
            @endphp

            @if (!$bundles->isEmpty())
                <h4 class="student-heading">{{ __('frontstaticword.BundleCourses') }}</h4>
                <div id="bundle-view-slider" class="student-view-slider-main-block owl-carousel">
                    @foreach ($bundles as $bundle)
                        @if ($bundle->status == 1)

                            <div class="item student-view-block student-view-block-1">
                                <div class="genre-slide-image protip" data-pt-placement="outside"
                                    data-pt-interactive="false"
                                    data-pt-title="#prime-next-item-description-block-3{{ $bundle->id }}">
                                    <div class="view-block">
                                        <div class="view-img">
                                            @if ($bundle['preview_image'] !== null && $bundle['preview_image'] !== '')
                                                <a href="{{ route('bundle.detail', $bundle->id) }}">
                                                    <!--<img src="{{ asset('images/bundle/' . $bundle['preview_image']) }}" alt="course" class="img-fluid">-->
                                                    <img src="{{ env('AWS_URL') . ('Storage/images/bundle/' . $bundle['preview_image']) }}"
                                                        alt="course" class="img-fluid">
                                                </a>
                                            @else
                                                <a href="{{ route('bundle.detail', $bundle->id) }}"><img
                                                        src="{{ Avatar::create($bundle->title)->toBase64() }}"
                                                        alt="course" class="img-fluid"></a>
                                            @endif
                                        </div>
                                        <div class="view-dtl">
                                            <div class="view-heading btm-10"><a
                                                    href="{{ route('bundle.detail', $bundle->id) }}">{{ str_limit($bundle->title, $limit = 30, $end = '...') }}</a>
                                            </div>
                                            <!--<p class="btm-10"><a herf="#">by {{ $bundle->user['fname'] }}</a></p>-->

                                            <!--<p class="btm-10"><a herf="#">Created At: {{ date('d-m-Y', strtotime($bundle['created_at'])) }}</a></p>-->

                                            @if ($bundle->type == 1)
                                                <div class="rate text-right">
                                                    <ul>
                                                        @php
                                                            $currency_value = Session::get('currency_value');
                                                            $money = App\Currency::where(
                                                                'currency',
                                                                $currency_value,
                                                            )->first();
                                                            if (empty($money)) {
                                                                $money = App\Currency::where(
                                                                    'countrycode',
                                                                    'IN',
                                                                )->first();
                                                            }
                                                        @endphp

                                                        @if ($bundle->discount_price == !null)
                                                            <li><a><b><i
                                                                            class="{{ $money->icon }}"></i>{{ ceil($bundle->discount_price / $money->amount) }}</b></a>
                                                            </li>&nbsp;
                                                            <li><a><b><strike><i
                                                                                class="{{ $money->icon }}"></i>{{ ceil($bundle->price / $money->amount) }}</strike></b></a>
                                                            </li>
                                                        @else
                                                            <li><a><b><i
                                                                            class="{{ $money->icon }}"></i>{{ ceil($bundle->price / $money->amount) }}</b></a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="rate text-right">
                                                    <ul>
                                                        <li><a><b>{{ __('frontstaticword.Free') }}</b></a></li>
                                                    </ul>
                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                </div>
                                <div id="prime-next-item-description-block-3{{ $bundle->id }}"
                                    class="prime-description-block">
                                    <div class="prime-description-under-block">
                                        <div class="prime-description-under-block">
                                            <h5 class="description-heading">{{ $bundle['title'] }}</h5>
                                            <div class="protip-img">
                                                @if ($bundle['preview_image'] !== null && $bundle['preview_image'] !== '')
                                                    <a href="{{ route('bundle.detail', $bundle->id) }}">
                                                        <!--<img src="{{ asset('images/bundle/' . $bundle['preview_image']) }}" alt="student" class="img-fluid">-->
                                                        <img src="{{ env('AWS_URL') . ('Storage/images/bundle/' . $bundle['preview_image']) }}"
                                                            alt="student" class="img-fluid">
                                                    </a>
                                                @else
                                                    <a href="{{ route('bundle.detail', $bundle->id) }}"><img
                                                            src="{{ Avatar::create($bundle->title)->toBase64() }}"
                                                            alt="student" class="img-fluid">
                                                    </a>
                                                @endif
                                            </div>



                                            <div class="main-des">
                                                <p>{!! str_limit($bundle['detail'], $limit = 200, $end = '...') !!}</p>
                                            </div>
                                            <div class="des-btn-block">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        @if ($bundle->type == 1)
                                                            @if (Auth::check())
                                                                @if (Auth::User()->role == 'admin')
                                                                    <div class="protip-btn">
                                                                        <a href="" class="btn btn-secondary"
                                                                            title="course">{{ __('frontstaticword.Purchased') }}</a>
                                                                    </div>
                                                                @else
                                                                    @php
                                                                        $order = App\Order::where(
                                                                            'user_id',
                                                                            Auth::User()->id,
                                                                        )
                                                                            ->where('bundle_id', $bundle->id)
                                                                            ->first();
                                                                    @endphp
                                                                    @if (!empty($order) && $order->status == 1)
                                                                        <div class="protip-btn">
                                                                            <a href="" class="btn btn-secondary"
                                                                                title="course">{{ __('frontstaticword.Purchased') }}</a>
                                                                        </div>
                                                                    @else
                                                                        @php
                                                                            $cart = App\Cart::where(
                                                                                'user_id',
                                                                                Auth::User()->id,
                                                                            )
                                                                                ->where('bundle_id', $bundle->id)
                                                                                ->first();
                                                                        @endphp
                                                                        @if (!empty($cart))
                                                                            <div class="protip-btn">
                                                                                <form id="demo-form2" method="post"
                                                                                    action="{{ route('remove.item.cart', $cart->id) }}">
                                                                                    {{ csrf_field() }}

                                                                                    <div class="box-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary">{{ __('frontstaticword.RemoveFromCart') }}</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        @else
                                                                            <div class="protip-btn">
                                                                                <form id="demo-form2" method="post"
                                                                                    action="{{ route('bundlecart', $bundle->id) }}"
                                                                                    data-parsley-validate
                                                                                    class="form-horizontal form-label-left">
                                                                                    {{ csrf_field() }}

                                                                                    <input type="hidden" name="user_id"
                                                                                        value="{{ Auth::User()->id }}" />
                                                                                    <input type="hidden" name="bundle_id"
                                                                                        value="{{ $bundle->id }}" />

                                                                                    <div class="box-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary">{{ __('frontstaticword.AddToCart') }}</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <div class="protip-btn">
                                                                    <a href="{{ route('login') }}"
                                                                        class="btn btn-primary"><i class="fa fa-cart-plus"
                                                                            aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.AddToCart') }}</a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            @if (Auth::check())
                                                                @if (Auth::User()->role == 'admin')
                                                                    <div class="protip-btn">
                                                                        <a href="" class="btn btn-secondary"
                                                                            title="course">{{ __('frontstaticword.Purchased') }}</a>
                                                                    </div>
                                                                @else
                                                                    @php
                                                                        $enroll = App\Order::where(
                                                                            'user_id',
                                                                            Auth::User()->id,
                                                                        )
                                                                            ->where('course_id', $c->id)
                                                                            ->first();
                                                                    @endphp
                                                                    @if ($enroll == null)
                                                                        <div class="protip-btn">
                                                                            <a href="{{ url('enroll/show', $bundle->id) }}"
                                                                                class="btn btn-primary"
                                                                                title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                                        </div>
                                                                    @else
                                                                        <div class="protip-btn">
                                                                            <a href="" class="btn btn-secondary"
                                                                                title="Cart">{{ __('frontstaticword.Purchased') }}</a>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <div class="protip-btn">
                                                                    <a href="{{ route('login') }}"
                                                                        class="btn btn-primary"
                                                                        title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        @endif

                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <!-- Bundle end -->



    <!-- Bundle start -->
    <!-- Bundle end -->
    <!-- recommendations start -->
    <section id="border-recommendation" class="border-recommendation">
        @php
            $gets = App\GetStarted::first();
        @endphp
        @if (isset($gets))
            <div class="top-border"></div>
            <!--<div class="recommendation-main-block  text-center" style="background-image: url('{{ asset('images/getstarted/' . $gets['image']) }}')">-->
            <div class="recommendation-main-block  text-center"
                style="background-image: url('{{ env('AWS_URL') . ('Storage/images/getstarted/' . $gets['image']) }}')">
                <div class="container">
                    <h3 class="text-white">{{ $gets['heading'] }}</h3>
                    <p class="text-white btm-20">{{ $gets['sub_heading'] }}</p>
                    @if ($gets->button_txt == !null)
                        <div class="recommendation-btn text-white">
                            <a href="{{ url('/') }}" class="btn btn-primary "
                                title="search">{{ $gets['button_txt'] }}</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
    <!-- recommendations end -->
    <!-- categories start -->
    @php
        $topcats = App\Categories::orderBy('position', 'ASC')->get();
    @endphp
    @if (!$topcats->isEmpty())
        <!--<section id="categories" class="categories-main-block">-->
        <!--    <div class="container">-->

        <!--        <h3 class="categories-heading btm-30">{{ __('frontstaticword.TopCategories') }}</h3>-->
        <!--        <div class="row">-->
        <!--            @foreach ($topcats as $t)
    -->
        <!--            @if ($t->status == 1)
    -->
        <!--            <div class="col-lg-3 col-sm-6">-->
        <!--                <div class="categories-block">-->
        <!--                    <ul>-->
        <!--                        <li><a href="#" title="{{ $t['title'] }}"><i class="fa {{ $t['icon'] }}"></i>-->
        <!--                        </a></li>-->
        <!--                        <li><a href="{{ route('category.page', $t->id) }}">{{ $t['title'] }}</a></li>-->
        <!--                    </ul>-->
        <!--                </div>      -->
        <!--            </div>-->
        <!--
    @endif-->
        <!--
    @endforeach-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</section>-->
    @endif

    <!-- categories end -->
    <!-- testimonial start -->
    @php
        $testi = App\Testimonial::all();
    @endphp
    @if (!$testi->isEmpty())
        {{-- <section id="testimonial" class="testimonial-main-block">
    <div class="container">
        {{-- <h3 class="btm-30">{{ __('frontstaticword.HomeTestimonial') }}</h3> --}}
        <div id="testimonial-slider" class="testimonial-slider-main-block owl-carousel">

            @foreach ($testi as $tes)
                @if ($tes->status == 1)
                    <div class="item testimonial-block">
                        <ul>
                            <li>
                                <!--<img src="{{ asset('images/testimonial/' . $tes['image']) }}" alt="blog">-->
                                <img src="{{ env('AWS_URL') . ('Storage/images/testimonial/' . $tes['image']) }}"
                                    alt="blog">
                            </li>
                            <li>
                                <h5 class="testimonial-heading">{{ $tes['client_name'] }}</h5>
                            </li>
                        </ul>
                        <p>{!! str_limit($tes->details, $limit = 2000, $end = '...') !!}</p>
                    </div>
                @endif
            @endforeach
        </div>

        </div>
        {{-- </section> --}}
    @endif

    {{-- @php
    $trusted = App\Trusted::all();
@endphp
@if (!$trusted->isEmpty())
<section id="trusted" class="trusted-main-block">
    <div class="container">
        <div class="patners-block">
            
            <h6 class="patners-heading text-center btm-40">{{ __('frontstaticword.Trusted') }}</h6>
            <div id="patners-slider" class="patners-slider owl-carousel">
                @foreach ($trusted as $trust)
                    @if ($trust->status == 1)
                    <div class="item-patners-img">
                        <a href="{{ $trust['url'] }}" target="_blank">
                            <!--<img src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid" alt="patners-1">-->
                            <img src="{{ env('AWS_URL').('Storage/images/trusted/'.$trust['image']) }}" class="img-fluid" alt="patners-1">
                            </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    
</section>
@endif --}}


    {{-- <section id="trusted" class="trusted-main-block">
    <!-- google adsense code -->
    <div class="container-fluid" id="adsense">
        @php
            $ad = App\Adsense::first();
        @endphp
        <?php
        if (isset($ad)) {
            if ($ad->ishome == 1 && $ad->status == 1) {
                $code = $ad->code;
                echo html_entity_decode($code);
            }
        }
        ?>
    </div>
</section> --}}

@endsection

@section('custom-script')
    {{-- 
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+91 9500186186", // WhatsApp number
            call_to_action: "Message us", // Call to action
            position: "right", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script> --}}

    <script>
        (function($) {
            "use strict";
            $(function() {
                $("#home-tab").trigger("click");
            });
        })(jQuery);

        function showtab(id) {
            $.ajax({
                type: 'GET',
                url: '{{ url('/tabcontent') }}/' + id,
                dataType: 'html',
                success: function(data) {

                    $('#tabShow').html('');
                    $('#tabShow').append(data);
                }
            });
        }
    </script>



@endsection
