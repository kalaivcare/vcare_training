{{-- @if ($gsetting->promo_enable == 1)
<div id="promo-outer">
    <div id="promo-inner">
        <a href="{{ $gsetting['promo_link'] }}">{{ $gsetting['promo_text'] }}</a>
        <span id="close">x</span>
    </div>
</div>
<div id="promo-tab" class="display-none">SHOW</div>
@endif --}}
<style>
    .my-dropdown {
        width: 60%;
    }

    .nav-bar-main-block .logo .img-fluid {
        max-width: 100%;
        height: 70px;
    }

    .my-container {
        justify-content: center;
    }

    @media (min-width: 767px) and (max-width: 992px) {
        .smallscreen-search-block {
            display: block;
        }
    }

    @media (max-width: 992px) {
        .Login-btn {

            margin-bottom: 0px;
        }
    }

    @media (max-width: 576px) {
        .nav-bar-main-block .logo .img-fluid {
            max-width: 125%;
            height: 50px;
            margin-top: 0px;
        }
    }

    @media (max-width: 576px) {
        .smallscreen-search-block {
            display: block;
        }
    }
</style>
<section id="nav-bar" class="nav-bar-main-block px-3">
    <div class="container-fluid">
        <!-- start navigation -->
        <div class="navigation fullscreen-search-block">

            <div class="logo ">
                <span style="font-size:30px;cursor:pointer;    line-height: 70px;margin-right: 14px;"
                    onclick="openNav()" class="hamburger">&#9776; </span>
                @php
                    $setting = App\Setting::first();
                    $money = App\Currency::all();
                @endphp

                @if ($setting->logo_type == 'L')
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('files/logo/' . $setting->logo) }}" class="img-fluid" alt="logo">
                        {{-- <img src="{{ env('AWS_URL').('Storage/images/logo/'.$setting->logo) }}" class="img-fluid"
                            alt="logo"> --}}
                    </a>
                @else()
                    <a href="{{ url('/') }}"><b>
                            <div class="logotext">{{ $setting->project_title }}</div>
                        </b></a>
                @endif
            </div>

            <!--  <div class="nav-search nav-wishlist mobile-search">
                <a href="#find"><i class="fa fa-search"></i></a>
            </div> -->

            @auth
                {{-- <div class="shopping-cart">
                    <a href="{{ route('cart.show') }}" title="Cart"><i class="flaticon-shopping-cart"></i></a>
                    <span class="red-menu-badge red-bg-success" style="left: 21px;">
                        @php
                        $item = App\Cart::where('user_id', Auth::User()->id)->get();
                        if(count($item)>0){

                        echo count($item);
                        }
                        else{

                        echo "0";
                        }
                        @endphp
                    </span>
                </div> --}}
                {{-- <div class="nav-wishlist mobile">
                    <div id="notification_li">
                        <a href="{{ url('send') }}" id="notificationLinkk" title="Notification"><i
                                class="fa fa-bell"></i></a>
                        <span class="red-menu-badge red-bg-success mobile-not-badge">
                            {{ Auth()->user()->unreadNotifications->count() }}
                        </span>
                        <div id="notificationContainerr">
                            <div id="notificationTitle">{{ __('frontstaticword.Notifications') }}</div>
                            <div id="notificationsBody" class="notifications">
                                <ul>
                                    @foreach (Auth()->user()->unreadNotifications as $notification)
                                    <li class="unread-notification">
                                        <a href="{{url('notifications/'.$notification->id)}}">
                                            <div class="notification-image">
                                                @if ($notification->data['image'] !== null)
                                                {{-- <img src="{{ asset('images/course/'.$notification->data['image']) }}"
                                                    alt="course" class="img-fluid"> --}}

                                                {{-- <img
                                                    src="{{ env('AWS_URL').('Storage/images/course/'.$notification->data['image']) }}"
                                                    alt="course" class="img-fluid">
                                                @else
                                                <img src="{{ Avatar::create($notification->data['id'])->toBase64() }}"
                                                    alt="course" class="img-fluid">
                                                @endif
                                            </div>
                                            <div class="notification-data">
                                                In {{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
                                                <br>
                                                {{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach

                                    @foreach (Auth()->user()->readNotifications as $notification)
                                    <li>
                                        <a href="{{ route('mycourse.show') }}">
                                            <div class="notification-image">
                                                @if ($notification->data['image'] !== null)
                                                {{-- <img src="{{ asset('images/course/'.$notification->data['image']) }}"
                                                    alt="course" class="img-fluid"> --}}
                                                {{-- <img
                                                    src="{{ env('AWS_URL').('Storage/images/course/'.$notification->data['image']) }}"
                                                    alt="course" class="img-fluid">
                                                @else
                                                <img src="{{ Avatar::create($notification->data['id'])->toBase64() }}"
                                                    alt="course" class="img-fluid">
                                                @endif
                                            </div>
                                            <div class="notification-data">
                                                In {{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
                                                <br>
                                                {{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div id="notificationFooter"><a href="{{route('deleteNotification')}}">{{
                                    __('frontstaticword.ClearAll') }}</a></div>
                        </div>
                    </div>
                </div> --}}
            @endauth
            {{-- <div class="select2-wrapper nav-currency">
                <select class="input icons_select2" id="currency1">
                    @foreach ($money as $curr_sel)
                    <?php $currency_value = session('currency_value'); ?>
                    <option value="{{ $curr_sel->currency}}" data-icon="{{ $curr_sel->icon }}" {{ $curr_sel->currency ==
                        $currency_value ? 'selected':''}}></option>
                    @endforeach
                </select>
            </div> --}}

            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                @guest
                    <div class="login-block">
                        <a href="{{ route('register') }}" class="btn btn-primary"
                            title="register">{{ __('frontstaticword.Signup') }}</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary"
                            title="login">{{ __('frontstaticword.Login') }}</a>
                    </div>
                @endguest
                @auth

                    <div id="notificationTitle">
                        @if (Auth::User()->user_img != null || Auth::User()->user_img != '')
                            <img src="{{ url('/images/user_img/' . Auth::User()->user_img) }}" class="dropdown-user-circle"
                                alt="user">
                        @else
                            <img src="{{ asset('images/default/user.jpg') }}" class="dropdown-user-circle" alt="user">
                        @endif
                        <div class="user-detailss">
                            Hi, {{ Auth::User()->fname }}

                        </div>

                    </div>

                    <div class="login-block">

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <a href="{{ route('profile.show', Auth::User()->id) }}">
                                <li style="list-style: none;"><i
                                        class="fa fa-user"></i>{{ __('frontstaticword.UserProfile') }}</li>
                            </a>

                            <div id="notificationFooter">
                                {{ __('frontstaticword.Logout') }}

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                    @csrf
                                </form>
                            </div>
                        </a>
                    </div>

                @endauth

                {{-- <div class="wrapper center-block">
                    @php
                    $categories = App\Categories::whereNotin('id',[1])->orderBy('position','ASC')->get();
                    $courses = App\Course::get();
                    @endphp
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach ($categories as $cate)
                        <div class="panel panel-default">
                            <div class="panel-heading active" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseOne{{ $cate->id }}" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <i class="fa {{ $cate->icon }} rgt-10"></i> <label class="prime-cat"
                                            data-url="{{ route('category.page',$cate->id) }}">{{ str_limit($cate->title,
                                            $limit = 20, $end = '..') }}</label>
                                    </a>
                                </h4>
                            </div>

                            <div id="collapseOne{{ $cate->id }}" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingOne">
                                @foreach ($courses as $coursedel)
                                @php
                                $coursecatid = $coursedel['category_id'] ;
                                @endphp
                                @if (in_array($cate->id, $coursecatid))
                                @if ($coursedel->status == 1)
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingeleven">
                                            <h4 class="panel-title">
                                                <a href="{{ route('user.course.show',['id' => $coursedel->id, 'slug' => $coursedel->slug ]) }}"
                                                    title="{{ $coursedel->title }}">{{ $coursedel->title }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @endforeach
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
                --}}

                <!-- Workshop mobile menu -->
                {{--
                <div class="wrapper center-block">

                    @php
                    $workshops = App\Workshop::get();
                    @endphp
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading active" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#workshop"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Workshops
                                    </a>
                                </h4>
                            </div>


                            <div id="workshop" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingOne">
                                @foreach ($workshops as $workshop)
                                @if ($workshop->status == 1)
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingeleven">
                                            <h4 class="panel-title">
                                                <a href="{{ route('detail.workshop.show',['id' => $workshop->id, 'slug' => $workshop->slug ]) }}"
                                                    title="{{ $workshop->title }}">{{ $workshop->title }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>

                        </div>
                    </div>

                </div> --}}

                <!-- ........  -->
                @auth


                    <div class="sidebar-nav-icon">
                        <ul>
                            @if (Auth::User()->role == 'admin' || Auth::User()->role == 'trainer')
                                <a target="_blank" href="{{ url('/admins') }}">
                                    <li><i class="fa fa-dashboard"></i>{{ __('frontstaticword.AdminDashboard') }}</li>
                                </a>
                            @endif
                            @if (Auth::User()->role == 'instructor')
                                <a target="_blank" href="{{ url('/admins') }}">
                                    <li><i class="fa fa-dashboard"></i>{{ __('frontstaticword.InstructorDashboard') }}</li>
                                </a>
                            @endif
                            {{-- <a href="{{ route('mycourse.show') }}">
                                <li><i class="fa fa-diamond"></i>{{ __('frontstaticword.MyCourses') }}</li>
                            </a> --}}
                            {{-- <a href="{{ route('wishlist.show') }}">
                                <li><i class="fa fa-heart"></i>{{ __('frontstaticword.MyWishlist') }}</li>
                            </a> --}}
                            {{-- <a href="{{ route('purchase.show') }}">
                                <li><i class="fa fa-shopping-cart"></i>{{ __('frontstaticword.PurchaseHistory') }}</li>
                            </a> --}}
                            {{-- <a href="{{route('profile.show',Auth::User()->id)}}">
                                <li><i class="fa fa-user"></i>{{ __('frontstaticword.UserProfile') }}</li>
                            </a> --}}
                            @if (Auth::User()->role == 'user')
                                @if ($gsetting->instructor_enable == 1)
                                    <a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">
                                        <li><i class="fas fa-chalkboard-teacher"></i>{{ __('frontstaticword.BecomeAnInstructor') }}
                                        </li>
                                    </a>
                                @endif
                            @endif


                        </ul>
                    </div>


                @endauth
            </div>
        </div>

        <!-- end navigation -->
        <div class="row smallscreen-search-block">
            <div class="col-lg-4 d-none d-lg-block">
                <div class="row">
                    <div class="col-lg-5 col-md-4 col-sm-12 mt-0">
                        <div class="logo">
                            @php
                                $setting = App\Setting::first();
                            @endphp

                            @if ($setting->logo_type == 'L')
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('files/logo/' . $setting->logo) }}" class="img-fluid" alt="logo">
                                    {{-- <img src="{{ env('AWS_URL').('Storage/images/logo/'.$setting->logo) }}"
                                        class="img-fluid" alt="logo"> --}}
                                </a>
                            @else()
                                <a href="{{ url('/') }}"><b>
                                        <div class="logotext">{{ $setting->project_title }}</div>
                                    </b></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="navigation">
                            {{-- <div id="cssmenu">
                                <ul>
                                    <li><a href="#" title="Courses"><i class="flaticon-grid"></i>{{
                                            __('frontstaticword.Courses') }}</a>
                                        @php
                                        $categories =
                                        App\Categories::whereNotin('id',[1])->orderBy('position','ASC')->get();
                                        $courses = App\Course::get();

                                        @endphp
                                        <ul>
                                            @foreach ($categories as $cate)
                                            @if ($cate->status == 1)
                                            <li><a href="{{ route('category.page',$cate->id) }}"
                                                    title="{{ $cate->title }}"><i
                                                        class="fa {{ $cate->icon }} rgt-20"></i>{{ $cate->title }}<i
                                                        class="fa fa-chevron-right float-rgt"></i></a>

                                                <ul>
                                                    @foreach ($courses as $coursedel)
                                                    @php
                                                    $coursecatid = $coursedel['category_id'] ;
                                                    @endphp
                                                    @if (in_array($cate->id, $coursecatid))
                                                    @if ($coursedel->status == 1)
                                                    <li>
                                                        <a href="{{ route('user.course.show',['id' => $coursedel->id, 'slug' => $coursedel->slug ]) }}"
                                                            title="{{ $coursedel->title }}">{{ $coursedel->title }}</a>
                                                    </li>

                                                    @endif
                                                    @endif
                                                    @endforeach
                                                </ul>


                                                <!--<ul>   -->
                                                <!--    @foreach ($cate->subcategory as $sub)-->
                                                <!--    @if ($sub->status == 1)-->
                                                <!--    <li><a href="{{ route('subcategory.page',$sub->id) }}" title="{{ $sub->title }}"><i class="fa {{ $sub->icon }} rgt-20"></i>{{ $sub->title }}-->
                                                <!--        <i class="fa fa-chevron-right float-rgt"></i></a>-->
                                                <!--        <ul>-->
                                                <!--            @foreach ($sub->childcategory as $child)-->
                                                <!--            @if ($child->status == 1)-->
                                                <!--            <li>-->
                                                <!--                <a href="{{ route('childcategory.page',$child->id) }}" title="{{ $child->title }}"><i class="fa {{ $child->icon }} rgt-20"></i>{{ $child->title }}</a>-->
                                                <!--            </li>-->
                                                <!--            @endif-->
                                                <!--            @endforeach-->
                                                <!--        </ul>-->
                                                <!--    </li>-->
                                                <!--    @endif-->
                                                <!--   @endforeach-->
                                                <!--</ul>-->
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="navigation">
                            {{-- <div id="cssmenu">
                                <ul>
                                    <li><a href="#" title="Workshops"><i class="flaticon-grid"></i>Workshops</a>
                                        @php
                                        $workshops = App\Workshop::get();
                                        @endphp
                                        <ul>
                                            @foreach ($workshops as $workshop)

                                            @if ($workshop->status == 1)
                                            <li>
                                                <a href="{{ route('detail.workshop.show',['id' => $workshop->id, 'slug' => $workshop->slug ]) }}"
                                                    title="{{ $workshop->title }}">{{ $workshop->title }}</a>

                                                <!-- <a href="{{ route('detail.workshop.show',['id' => $workshop->id, 'slug' => $workshop->slug ]) }}" title="{{ $workshop->title }}">{{ $workshop->title }}</a> -->
                                            </li>

                                            @endif
                                            @endforeach
                                        </ul>


                                    </li>

                                </ul>
                                </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                @guest
                    <div class="row justify-content-between pt-0 h-100">
                        <div class="col-lg-6 col-md-7 col-7 d-flex align-items-center">
                            <div class="learning-business pt-0 w-100" id="searchnew">
                                <!--@if ($setting->instructor_enable == 1)
                                                                                                                                                                                                    -->
                                <!--    <a href="{{ route('login') }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Login/Register To Become an Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a>-->
                                <!--
                                                                                                                                                                                                    @endif-->
                                <form action="{{ route('search') }}" class="" method="GET">

                                    <div class="input-group">
                                        <input type="text" name='searchTerm' id="search" class="form-control"
                                            placeholder="Search for courses" value="{{ request('searchTerm') }}">
                                        <div class="input-group-append">
                                            <button class="btn search-wish" type="submit"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- <div class="col-lg-2 col-md-2">
                            <div class="select2-wrapper  " style="margin-top:13px !important;">
                                <select class="input icons_select2" id="currency2">
                                    @foreach ($money as $curr_sel)
                                    <?php $currency_value = session('currency_value'); ?>
                                    <option value="" data-icon="{{ $curr_sel->icon }}" {{ $curr_sel->currency ==
                                        $currency_value ? 'selected':''}}>{{ $curr_sel->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-lg-4 col-md-4 col-4 d-flex align-items-center justify-content-end">
                            <div class="Login-btn">
                                {{-- <a href="{{ route('cartbefore.show') }}" class="nav-wishlist shopping-cart"
                                    title="Cart">
                                    <i class="fas fa-shopping-cart"></i> <span class="red-menu-badge-cart red-bg-success"
                                        style="left: 29px !important;"> 0 </span></a> --}}
                                {{-- <a href="{{ asset('navigation-guide') }}" class="btn btn-secondary"
                                    title="guide">Guide</a> --}}

                                <a href="{{ route('register') }}" class="btn btn-primary mb-0"
                                    title="register">{{ __('frontstaticword.Signup') }}</a>
                                <a href="{{ route('login') }}" class="btn btn-primary mb-0"
                                    title="login">{{ __('frontstaticword.Login') }}</a>
                            </div>
                        </div>
                @endguest

                    @auth
                        <div class="row justify-content-between">
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="learning-business learning-business-two" id="searchnewlog">
                                    <form action="{{ route('search') }}" class="" method="GET">

                                        <div class="input-group">
                                            <input type="text" name='searchTerm' id="search" class="form-control"
                                                placeholder="Search for courses" value="{{ request('searchTerm') }}">

                                            <div class="input-group-append">
                                                <button class="btn search-wish" type="submit"><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    @if (Auth::User()->role == 'user')
                                        @if ($setting->instructor_enable == 1)
                                            <a href="#" class="btn btn-link" data-toggle="modal" data-target="#myModalinstructor"
                                                title="Become An Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <!--  <div class="col-lg-2 col-md-2 col-6">
                                                                                            <div class="learning-business">

                                                                                            </div>
                                                                                        </div>
                                                             -->
                            {{-- <div class="select2-wrapper  cartm" style="margin-top:15px;">
                                <select class="input icons_select2" id="currency3">
                                    @foreach ($money as $curr_sel)
                                    <?php $currency_value = session('currency_value'); ?>
                                    <option value="" data-icon="{{ $curr_sel->icon }}" {{ $curr_sel->currency ==
                                        $currency_value ? 'selected':''}}>{{ $curr_sel->currency}}</option>
                                    @endforeach
                                </select>
                            </div> --}}


                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 d-lg-block d-none">
                                <div class="my-container">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle  my-dropdown" type="button"
                                            id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true" Profile>
                                            @if (Auth::User()->user_img != null || Auth::User()->user_img != '')
                                                <img src="{{ url('/images/user_img/' . Auth::User()->user_img) }}"
                                                    class="circle" alt="user">
                                            @else
                                                <img src="{{ asset('images/default/user.jpg') }}" class="circle" alt="user">
                                            @endif
                                            <span class="dropdown__item name"
                                                id="name">{{ str_limit(Auth::User()->fname, $limit = 10, $end = '..') }}</span>
                                            <span class="dropdown__item caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right User-Dropdown U-open"
                                            aria-labelledby="dropdownMenu1">
                                            <div id="notificationTitle">
                                                @if (Auth::User()->user_img != null || Auth::User()->user_img != '')
                                                    <img src="{{ url('/images/user_img/' . Auth::User()->user_img) }}"
                                                        class="dropdown-user-circle" alt="user">
                                                @else
                                                    <img src="{{ asset('images/default/user.jpg') }}"
                                                        class="dropdown-user-circle" alt="user">
                                                @endif
                                                <div class="user-detailss">
                                                    {{ Auth::User()->fname }}
                                                    <br>
                                                    {{ Auth::User()->email }}
                                                </div>

                                            </div>
                                            @if (Auth::User()->role == 'admin' || Auth::User()->role == 'trainer')
                                                <a target="_blank" href="{{ url('/admins') }}">
                                                    <li><i class="fa fa-dashboard"></i>
                                                        @if (Auth::User()->role == 'admin')
                                                            Admin Dashboard
                                                        @else
                                                            Trainer Dashboard
                                                        @endif
                                                    </li>
                                                </a>
                                            @endif
                                            @if (Auth::User()->role == 'instructor')
                                                <a target="_blank" href="{{ url('/admins') }}">
                                                    <li><i
                                                            class="fa fa-dashboard"></i>{{ __('frontstaticword.InstructorDashboard') }}
                                                    </li>
                                                </a>
                                            @endif
                                            {{-- <a href="{{ route('mycourse.show') }}">
                                                <li><i class="fa fa-diamond"></i>{{ __('frontstaticword.MyCourses') }}</li>
                                            </a>
                                            <a href="{{ route('wishlist.show') }}">
                                                <li><i class="fa fa-heart"></i>{{ __('frontstaticword.MyWishlist') }}</li>
                                            </a>
                                            <a href="{{ route('purchase.show') }}">
                                                <li><i class="fa fa-shopping-cart"></i>{{
                                                    __('frontstaticword.PurchaseHistory') }}</li>
                                            </a> --}}
                                            <a href="{{ route('profile.show', Auth::User()->id) }}">
                                                <li><i class="fa fa-user"></i>{{ __('frontstaticword.UserProfile') }}</li>
                                            </a>
                                            @if (Auth::User()->role == 'user')
                                                @if ($gsetting->instructor_enable == 1)
                                                    <a href="#" data-toggle="modal" data-target="#myModalinstructor"
                                                        title="Become An Instructor">
                                                        <li><i
                                                                class="fas fa-chalkboard-teacher"></i>{{ __('frontstaticword.BecomeAnInstructor') }}
                                                        </li>
                                                    </a>
                                                @endif
                                            @endif

                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <div id="notificationFooter">
                                                    {{ __('frontstaticword.Logout') }}

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="display-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

            </div>

        </div>
</section>

<!-- start search -->
<div id="find">
    <button type="button" class="close">×</button>
    <form action="{{ route('search') }}" class="form-inline search-form" method="GET">
        <input type="find" name="searchTerm" class="form-control" id="search"
            placeholder="{{ __('frontstaticword.Searchforcourses') }}"
            value="{{ isset($searchTerm) ? $searchTerm : '' }}">
        <button type="submit" class="btn btn-outline-info btn_sm">Search</button>
    </form>
</div>
<!-- start end -->


<!-- side navigation  -->
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

@section('custom-script')
@endsection

@include('instructormodel')