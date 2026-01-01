@php
    $cats = App\Categories::find($cate);
    $courses = App\Course::all();
    // dd($courses);

@endphp






@if ($cate == 1)



    <div class="row no-gutters">

        <div id="business-home-slider-two" class="business-home-slider">
            @foreach ($courses as $course)

                @if ($course->featured == 1 && $course->status == 1)
                    <div class="item business-home-slider-block">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="business-home-slider-img">
                                    @if ($course['preview_image'] !== null && $course['preview_image'] !== '')
                                        {{-- <img src="{{ env('AWS_URL') . ('Storage/images/course/' . $course->preview_image) }}"
                                            class="img-fluid" alt="course"> --}}
                                        <img src="{{ asset('images/course/' . $course->preview_image) }}"
                                            class="img-fluid" alt="course">


                                        {{-- <a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}"> --}}
                                        {{-- <img src="{{ asset('images/course/'.$course->preview_image) }}" class="img-fluid" alt="course"> --}}
                                        {{-- <img src="{{ env('AWS_URL').('Storage/images/course/'.$course->preview_image) }}" class="img-fluid" alt="course">
                                    </a> --}}
                                    @else
                                        {{-- <a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}"> --}}
                                        <img src="{{ Avatar::create($course->title)->toBase64() }}" class="img-fluid"
                                            alt="course">
                                        {{-- </a> --}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="categories-popularity-dtl">
                                    <ul>
                                        <li class="heart float-rgt">
                                            @if (Auth::check())
                                                @php
                                                    $wishtt = App\Wishlist::where('user_id', Auth::User()->id)
                                                        ->where('course_id', $course->id)
                                                        ->first();
                                                @endphp
                                                @if ($wishtt == null)
                                                    <div class="heart">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ url('show/wishlist', $course->id) }}"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::User()->id }}" />
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course->id }}" />

                                                            {{-- <button class="wishlisht-btn heart-category" title="Add to wishlist" type="submit"><i class="fa fa-heart rgt-10"></i></button> --}}
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="heart-two">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ url('remove/wishlist', $course->id) }}"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::User()->id }}" />
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course->id }}" />

                                                            {{-- <button class="wishlisht-btn heart" title="Remove from Wishlist" type="submit"><i class="fa fa-heart rgt-10"></i></button> --}}
                                                        </form>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="heart">
                                                    {{-- <a href="{{ route('login') }}" title="heart"><i class="fa fa-heart rgt-10"></i></a> --}}
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                    <div class="view-heading btm-10"><a
                                            href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}"><b>{{ $course->title }}</b></a>
                                    </div>
                                    <ul>
                                        <li class="rgt-5">
                                            @php
                                                $data = App\CourseChapter::where('course_id', $course->id)->get();
                                                if (count($data) > 0) {
                                                    echo count($data);
                                                } else {
                                                    echo '0';
                                                }
                                            @endphp
                                            modules
                                        </li>
                                        <li>

                                        </li>
                                        <li class="rgt-5" style="display:none;">
                                            <ul class="rating">
                                                <li>
                                                    <?php
                                                    $learn = 0;
                                                    $price = 0;
                                                    $value = 0;
                                                    $sub_total = 0;
                                                    $sub_total = 0;
                                                    $reviews = App\ReviewRating::where('course_id', $course->id)->where('status', '1')->get();
                                                    ?>
                                                    @if (!empty($reviews[0]))
                                                        <?php
                                                        $count = App\ReviewRating::where('course_id', $course->id)->count();
                                                        
                                                        foreach ($reviews as $review) {
                                                            $learn = $review->price * 5;
                                                            $price = $review->price * 5;
                                                            $value = $review->value * 5;
                                                            $sub_total = $sub_total + $learn + $price + $value;
                                                        }
                                                        
                                                        $count = $count * 3 * 5;
                                                        $rat = $sub_total / $count;
                                                        $ratings_var = ($rat * 100) / 5;
                                                        ?>

                                                        <div class="pull-left">
                                                            <div class="star-ratings-sprite"><span
                                                                    style="width:<?php ?>%"
                                                                    class="star-ratings-sprite-rating"></span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="pull-left">
                                                            <p></p>
                                                        </div>
                                                    @endif
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- overall rating -->
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $count = count($reviews);
                                        $onlyrev = [];
                                        
                                        $reviewcount = App\ReviewRating::where('course_id', $course->id)->where('status', '1')->WhereNotNull('review')->get();
                                        
                                        foreach ($reviews as $review) {
                                            $learn = $review->learn * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }
                                        
                                        $count = $count * 3 * 5;
                                        
                                        if ($count) {
                                            $rat = $sub_total / $count;
                                        
                                            $ratings_var = ($rat * 100) / 5;
                                        
                                            $overallrating = $ratings_var / 2 / 10;
                                        }
                                        
                                        ?>

                                        @php
                                            $reviewsrating = App\ReviewRating::where('course_id', $course->id)->first();
                                        @endphp
                                        @if (!$reviews->isEmpty())
                                            <li class="rgt-5">
                                            </li>
                                        @endif

                                        <li>

                                        </li>
                                    </ul>
                                    @if ($course->type == 1)
                                        <div class="rate">
                                            <ul>

                                                @if (ceil($course->discount_price / $money->amount) == !null)
                                                    <li><a><b><i class="{{ $money['icon'] }}"
                                                                    style="font-size:13px;"></i>
                                                                {{ ceil($course->discount_price / $money->amount) }}</b></a>
                                                    </li>&nbsp;
                                                    <li><a><b><strike><i class="{{ $money['icon'] }}"
                                                                        style="font-size:13px;"></i>
                                                                    {{ ceil($course->price / $money->amount) }}</strike></b></a>
                                                    </li>
                                                @else
                                                    <li><a><b><i class="{{ $money['icon'] }}"
                                                                    style="font-size:13px;"></i>
                                                                {{ ceil($course->price / $money->amount) }}</b></a>
                                                    </li>
                                                @endif


                                            </ul>
                                        </div>
                                    @else
                                        <div class="rate">
                                            <ul>
                                                <li><a><b>{{ __('frontstaticword.Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                    @endif
                                    <p class="btm-20">{{ $course->short_detail }}</p>
                                    <div class="business-home-slider-btn btm-20">
                                        <!-- <a href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}" type="button" class="btn btn-info">Explore course</a> -->
                                    </div>
                                    <div class="business-home-slider-btn btm-20">

                                        @if (Auth::check())
                                            @if (Auth::User()->role == 'admin')
                                                <div class="catslide">
                                                    <a href="{{ url('show/coursecontent', $course->id) }}"
                                                        class="btn btn-secondary"
                                                        title="course">{{ __('frontstaticword.GoToCourse') }}</a>
                                                </div>
                                            @else
                                                @php
                                                    $enroll = App\Order::where('user_id', Auth::User()->id)
                                                        ->where('course_id', $course->id)
                                                        ->where('status', 1)
                                                        ->first();
                                                @endphp
                                                @if ($enroll == null)
                                                    @if (ceil($course->price / $money->amount) == null)
                                                        <div class="catslide">
                                                            <a href="{{ url('enroll/show', $course->id) }}"
                                                                class="btn btn-primary"
                                                                title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                        </div>
                                                    @else
                                                        <div class="catslide">
                                                            <a href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                                class="btn btn-primary"
                                                                title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="catslide">
                                                        <a href="{{ url('show/coursecontent', $course->id) }}"
                                                            class="btn btn-secondary"
                                                            title="Cart">{{ __('frontstaticword.GoToCourse') }}</a>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <div class="catslide">
                                                <a href="{{ route('login') }}" class="btn btn-primary"
                                                    title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endif
            @endforeach

        </div>


    </div>

    </div>
@else
    <div class="row no-gutters">


        <div id="business-home-slider-two" class="business-home-slider">

            @foreach ($courses as $course)
                @if (in_array($cats->id, $course->category_id))
                    @if ($course->featured == 1 && $course->status == 1)
                        <div class="item business-home-slider-block">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="business-home-slider-img">
                                        @if ($course['preview_image'] !== null && $course['preview_image'] !== '')
                                            <img src="{{ asset('images/course/' . $course->preview_image) }}"
                                                class="img-fluid" alt="course">
                                            {{-- <a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}"> --}}
                                            {{-- <img src="{{ asset('images/course/'.$course->preview_image) }}" class="img-fluid" alt="course"> --}}
                                            {{-- <img src="{{ env('AWS_URL').('Storage/images/course/'.$course->preview_image) }}" class="img-fluid" alt="course">
                                    </a> --}}
                                        @else
                                            <img src="{{ Avatar::create($course->title)->toBase64() }}"
                                                class="img-fluid" alt="course">

                                            {{-- <a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}">
                                    <img src="{{ Avatar::create($course->title)->toBase64() }}" class="img-fluid" alt="course">
                                </a> --}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="categories-popularity-dtl">
                                        <ul>
                                            <li class="heart float-rgt">
                                                @if (Auth::check())
                                                    @php
                                                        $wishtt = App\Wishlist::where('user_id', Auth::User()->id)
                                                            ->where('course_id', $course->id)
                                                            ->first();
                                                    @endphp
                                                    @if ($wishtt == null)
                                                        <div class="heart">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('show/wishlist', $course->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::User()->id }}" />
                                                                <input type="hidden" name="course_id"
                                                                    value="{{ $course->id }}" />

                                                                <button class="wishlisht-btn heart-category"
                                                                    title="Add to wishlist" type="submit"><i
                                                                        class="fa fa-heart rgt-10"></i></button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <div class="heart-two">
                                                            <form id="demo-form2" method="post"
                                                                action="{{ url('remove/wishlist', $course->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::User()->id }}" />
                                                                <input type="hidden" name="course_id"
                                                                    value="{{ $course->id }}" />

                                                                <button class="wishlisht-btn heart"
                                                                    title="Remove from Wishlist" type="submit"><i
                                                                        class="fa fa-heart rgt-10"></i></button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="heart">
                                                        <a href="{{ route('login') }}" title="heart"><i
                                                                class="fa fa-heart rgt-10"></i></a>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                        <div class="view-heading btm-10"><a
                                                href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}"><b>{{ $course->title }}</b></a>
                                        </div>
                                        <ul>
                                            <li class="rgt-5">
                                                @php
                                                    $data = App\CourseChapter::where('course_id', $course->id)->get();
                                                    // dd( $data);
                                                    if (count($data) > 0) {
                                                        echo count($data);
                                                    } else {
                                                        echo '0';
                                                    }
                                                @endphp
                                                modules
                                            </li>
                                            <li>

                                            </li>
                                            <li class="rgt-5" style="display:none;">
                                                <ul class="rating">
                                                    <li>
                                                        <?php
                                                        $learn = 0;
                                                        $price = 0;
                                                        $value = 0;
                                                        $sub_total = 0;
                                                        $sub_total = 0;
                                                        $reviews = App\ReviewRating::where('course_id', $course->id)->where('status', '1')->get();
                                                        ?>
                                                        @if (!empty($reviews[0]))
                                                            <?php
                                                            $count = App\ReviewRating::where('course_id', $course->id)->count();
                                                            
                                                            foreach ($reviews as $review) {
                                                                $learn = $review->price * 5;
                                                                $price = $review->price * 5;
                                                                $value = $review->value * 5;
                                                                $sub_total = $sub_total + $learn + $price + $value;
                                                            }
                                                            
                                                            $count = $count * 3 * 5;
                                                            $rat = $sub_total / $count;
                                                            $ratings_var = ($rat * 100) / 5;
                                                            ?>

                                                            <div class="pull-left">
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="pull-left">
                                                                <p></p>
                                                            </div>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>
                                            <!-- overall rating -->
                                            <?php
                                            $learn = 0;
                                            $price = 0;
                                            $value = 0;
                                            $sub_total = 0;
                                            $count = count($reviews);
                                            $onlyrev = [];
                                            
                                            $reviewcount = App\ReviewRating::where('course_id', $course->id)->where('status', '1')->WhereNotNull('review')->get();
                                            
                                            foreach ($reviews as $review) {
                                                $learn = $review->learn * 5;
                                                $price = $review->price * 5;
                                                $value = $review->value * 5;
                                                $sub_total = $sub_total + $learn + $price + $value;
                                            }
                                            
                                            $count = $count * 3 * 5;
                                            
                                            if ($count != '') {
                                                $rat = $sub_total / $count;
                                            
                                                $ratings_var = ($rat * 100) / 5;
                                            
                                                $overallrating = $ratings_var / 2 / 10;
                                            }
                                            
                                            ?>

                                            @php
                                                $reviewsrating = App\ReviewRating::where(
                                                    'course_id',
                                                    $course->id,
                                                )->first();
                                            @endphp
                                            @if (!$reviews->isEmpty())
                                                <li class="rgt-5">
                                                </li>
                                            @endif

                                            <li>

                                            </li>
                                        </ul>
                                        @if ($course->type == 1)
                                            <div class="rate">
                                                <ul>

                                                    @if (ceil($course->discount_price / $money->amount) == !null)
                                                        <li><a><b><i class="{{ $money['icon'] }}"
                                                                        style="font-size:13px;"></i>
                                                                    {{ ceil($course->discount_price / $money->amount) }}</b></a>
                                                        </li>&nbsp;
                                                        <li><a><b><strike><i class="{{ $money['icon'] }}"
                                                                            style="font-size:13px;"></i>
                                                                        {{ ceil($course->price / $money->amount) }}</strike></b></a>
                                                        </li>
                                                    @else
                                                        <li><a><b><i class="{{ $money['icon'] }}"
                                                                        style="font-size:13px;"></i>
                                                                    {{ ceil($course->price / $money->amount) }}</b></a>
                                                        </li>
                                                    @endif


                                                </ul>
                                            </div>
                                        @else
                                            <div class="rate">
                                                <ul>
                                                    <li><a><b>{{ __('frontstaticword.Free') }}</b></a></li>
                                                </ul>
                                            </div>
                                        @endif
                                        <p class="btm-20">{{ $course->short_detail }}</p>
                                        <!--<div class="business-home-slider-btn btm-20">-->
                                        <!--     <a href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}" type="button" class="btn btn-info">Explore course</a> -->
                                        <!--</div>-->
                                        <div class="business-home-slider-btn btm-20">

                                            @if (Auth::check())
                                                @if (Auth::User()->role == 'admin')
                                                    <div class="catslide">
                                                        <a href="{{ url('show/coursecontent', $course->id) }}"
                                                            class="btn btn-secondary"
                                                            title="course">{{ __('frontstaticword.GoToCourse') }}</a>
                                                    </div>
                                                @else
                                                    @php
                                                        $enroll = App\Order::where('user_id', Auth::User()->id)
                                                            ->where('course_id', $course->id)
                                                            ->first();
                                                    @endphp
                                                    @if ($enroll == null)
                                                        @if (ceil($course->price / $money->amount) == null)
                                                            <div class="catslide">
                                                                <a href="{{ url('enroll/show', $course->id) }}"
                                                                    class="btn btn-primary"
                                                                    title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                            </div>
                                                        @else
                                                            <div class="catslide">
                                                                <a href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                                    class="btn btn-primary"
                                                                    title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="catslide">
                                                            <a href="{{ url('show/coursecontent', $course->id) }}"
                                                                class="btn btn-secondary"
                                                                title="Cart">{{ __('frontstaticword.GoToCourse') }}</a>
                                                        </div>
                                                    @endif
                                                @endif
                                            @else
                                                <div class="catslide">
                                                    <a href="{{ route('login') }}" class="btn btn-primary"
                                                        title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endif
                @endif
            @endforeach







        </div>


    </div>



    </div>
@endif

@php
    $count = $cats->courses->where('status', '=', '1')->count();
@endphp
@if ($count >= 10)
    <div class="view-button txt-rgt">
        <a href="{{ route('category.page', $cats->id) }}" class="btn btn-secondary"
            title="View More">{{ __('frontstaticword.ViewMore') }}</a>
    </div>
@endif
