@extends('admin.layouts.master')
@section('title', 'Dashboard - Admin')
@section('body')

    @if (Auth::User()->role == 'admin' || Auth::User()->role == 'trainer')

        <section class="content-header">
            <h1>
                {{ __('adminstaticword.Dashboard') }}
                <small>{{ $project_title }}</small>
            </h1>
            <ol class="breadcrumb">
                {{-- <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('adminstaticword.Home') }}</a></li> --}}
                <li class="active">{{ __('adminstaticword.Dashboard') }}</li>
            </ol>
        </section>
        <section class="content">
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                @php
                                    if (Auth::User()->role == 'admin') {
                                        // $user = App\User::all();
                                        $user = App\User::where('role', 'user')->where('role', 'trainer')->get();
                                    } else {
                                        $user = App\User::where('role', 'user')->get();
                                    }

                                    if (count($user) > 0) {
                                        echo count($user);
                                    } else {
                                        echo '0';
                                    }
                                @endphp
                            </h3>
                            <p>{{ __('adminstaticword.Users') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                @php
                                    $course = App\Course::all();
                                    if (count($course) > 0) {
                                        echo count($course);
                                    } else {
                                        echo '0';
                                    }
                                @endphp
                            </h3>
                            <p>{{ __('adminstaticword.Courses') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-wpforms"></i>
                        </div>
                        <a href="{{ url('courses') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>
              	@php
              		$faq = App\FaqStudent::all();
              		if(count($faq)>0){

              			echo count($faq);
              		}
              		else{

              			echo "0";
              		}
              	@endphp
              </h3>
              <p>{{ __('adminstaticword.Faqs') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-question-circle-o"></i>
            </div>
            <a href="{{url('faq')}}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>@php
                                $review = App\Page::all();
                                if (count($review) > 0) {
                                    echo count($review);
                                } else {
                                    echo '0';
                                }
                            @endphp
                            </h3>
                            <p>{{ __('adminstaticword.Pages') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder-o"></i>
                        </div>
                        <a href="{{ url('page') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-4">
                    <!-- USERS LIST -->
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('adminstaticword.LatestUsers') }}</h3>

                            <div class="box-tools pull-right">
                                <span class="label label-danger">
                                    @php
                                        $user = App\User::all();
                                        if (count($user) > 0) {
                                            echo count($user);
                                        } else {
                                            echo '0';
                                        }
                                    @endphp
                                    {{ __('adminstaticword.Users') }}
                                </span>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            @php
                                $users = App\User::limit(8)->orderBy('id', 'DESC')->get();
                            @endphp
                            <ul class="users-list clearfix">
                                @foreach ($users as $user)
                                    <li>
                                        @if ($user['user_img'] != null || $user['user_img'] != '')
                                            <img src="{{ asset('/images/user_img/' . $user['user_img']) }}"
                                                class="img-fluid" alt="User Image">
                                        @else
                                            <img src="{{ asset('images/default/user.jpg') }}" class="img-fluid"
                                                alt="User Image">
                                        @endif
                                        <a class="users-list-name" href="#">{{ $user['fname'] }}
                                            {{ $user['lname'] }}</a>
                                        <span
                                            class="users-list-date">{{ date('F Y', strtotime($user['created_at'])) }}</span>
                                    </li>
                                @endforeach

                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{ route('user.index') }}" class="uppercase">{{ __('adminstaticword.ViewAll') }}</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!--/.box -->

                    <!-- PRODUCT LIST -->
                    @php
                        $courses = App\Course::limit(5)->orderBy('id', 'DESC')->get();
                    @endphp
                    @if (!$courses->isEmpty())
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ __('adminstaticword.RecentCourses') }}</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">

                                    @foreach ($courses as $course)
                                        <li class="item">
                                            <div class="product-img">
                                                @if ($course['preview_image'] !== null && $course['preview_image'] !== '')
                                                    <img src="images/course/<?php echo $course['preview_image']; ?>" alt="Course Image">
                                                @else
                                                    <img src="{{ Avatar::create($course->title)->toBase64() }}"
                                                        alt="Course Image">
                                                @endif

                                            </div>
                                            <div class="product-info">
                                                <a href="{{ url('/') }}"
                                                    class="product-title">{{ str_limit($course['title'], $limit = 25, $end = '...') }}
                                                    <span class="label label-warning pull-right">
                                                        @if ($course->type == 1)
                                                            @php
                                                                $currency2 = App\Currency::first();
                                                            @endphp
                                                            @if ($course->discount_price == !null)
                                                                <i
                                                                    class="{{ $currency2['icon'] }}"></i>{{ $course['discount_price'] }}
                                                            @else
                                                                <i
                                                                    class="{{ $currency2['icon'] }}"></i>{{ $course['price'] }}
                                                            @endif
                                                        @else
                                                            {{ __('adminstaticword.Free') }}
                                                        @endif
                                                    </span></a>

                                                <span class="product-description">
                                                    {{ str_limit($course->short_detail, $limit = 40, $end = '...') }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.box-body -->
                            {{-- <div class="box-footer text-center">
            <a href="{{url('course')}}" class="uppercase">{{ __('adminstaticword.ViewAll') }}</a>
          </div> --}}
                            <!-- /.box-footer -->
                        </div>
                    @endif
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

    @endif

@endsection
