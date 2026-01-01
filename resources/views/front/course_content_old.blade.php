@extends('theme.master')
@section('title', "$course->title")
@section('content')

@include('admin.message')
<!-- courses content header start -->
<section id="class-nav" class="class-nav-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-12">
               
                <div class="class-nav-heading">{{ $course->title }}</div>
            </div>
            <div class="col-lg-5 col-md-6 col-12">
                <div class="class-button certificate-button">
                    <ul>
                        <li>
                            <div class="dropdown">

                                @if(!empty($progress))
                                    <?php
                                    $total_class = $progress->all_chapter_id;
                                    $total_count = count($total_class);

                                    $total_per = 100;

                                    $read_class = $progress->mark_chapter_id;
                                    $read_count =  count($read_class);

                                    $progres = ($read_count/$total_count) * 100;
                                    ?>

                                @endif
                                
                              <!--<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                              <!--  <i class="fas fa-trophy"></i>&nbsp; Get Certificate-->
                              <!--</button>-->
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if(!empty($progress))
                                <a class="dropdown-item"> 
                                    {{ $read_count }} of {{ $total_count }} complete  
                                </a>
                                @else

                                <a class="dropdown-item"> 
                                    0 of 
                                    @php
                                        $data = App\CourseChapter::where('course_id', $course->id)->get();
                                        if(count($data)>0){

                                            echo count($data);
                                        }
                                        else{

                                            echo "0";
                                        }
                                    @endphp 
                                    complete 
                                </a>

                                @endif

                                @if(!empty($progress))
                                    @if($read_count == $total_count)
                                    <!--<div class="about-home-btn">-->
                                    <!--    <a href="{{ route('cirtificate.show', $course->id) }}" class="btn btn-secondary" href="#">Get Certificate</a>-->
                                    <!--</div>-->
                                    @endif
                                @endif
                              </div>
                            </div>

                           
                        </li>
                        <li>
                            <!--<a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}" class="course_btn"> {{ __('frontstaticword.Coursedetails') }} <i class="fa fa-chevron-right"></i></a>-->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="learning-courses-home" class="learning-courses-home-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="learning-courses-home-video text-white btm-30">
                    <div class="video-item hidden-xs">
                        <div class="video-device">
                            @if($course['preview_image'] !== NULL && $course['preview_image'] !== '')
                            
                                <img src="{{ asset('images/course/'.$course->preview_image) }}" class="img-fluid" alt="Background">
                            @else
                                <img src="{{ Avatar::create($course->title)->toBase64() }}" class="bg_img img-fluid" alt="Background">
                            @endif
                            <div class="video-preview">
                                @php
                                    //if empty 
                                    $items = App\CourseClass::where('course_id', $course->id)->first();
                                @endphp 
                               
                                <!--<a href="{{ asset('video/preview/'.$course['video']) }}" class="btn-video-play iframe"><i class="fa fa-play"></i></a>-->
                                 <a href="{{ route('watchcoursepreview',$course->id) }}" class="btn-video-play iframe" id="player_id"><i class="fa fa-play"></i></a>
                                       
                                @if(isset($items))
                                    @if(isset($course->chapter[0]->courseclass[0])) 
                                        @if($course->chapter[0]->courseclass[0]->iframe_url == NULL)
                                            <!--<a href="{{ route('watchcourse',$course->id) }}" class="btn-video-play iframe"><i class="fa fa-play"></i></a>-->
                                        @else
                                       
                                            @php
                                                $url = Crypt::encrypt($course->chapter[0]->courseclass[0]->iframe_url);
                                            @endphp
                                            <!--<a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" class="btn-video-play"><i class="fa fa-play"></i></a>-->
                                        @endif
                                    @else
                                        <!--<a href="{{ route('watchcourse',$course->id) }}" class="btn-video-play iframe"><i class="fa fa-play"></i></a>-->
                                    @endif
                                @endif
                               
                            </div>
                        </div>
                    </div>
                    
                </div>
                 <a class="btn" href="{{ asset('files/guide/Download Transctipt (Trichology).pdf') }}" download="{{ asset('files/guide/Intro video Transcript.pdf') }}" style="background-color:#59b3d1; color:#000000;">Download Introduction Transcript</a>
            </div>
            <div class="col-lg-8">
                <div class="learning-courses-home-block text-white">
                    <h3 class="learning-courses-home-heading btm-20"><a href="{{ route('user.course.show',['id' => $course->id, 'slug' => $course->slug ]) }}" title="heading">{{ $course->title }}</a></h3>
                    <!--<div class="learning-courses btm-20">{{ $course->user->fname }}</div>-->
                    <div class="learning-courses btm-20">{{ $course->short_detail }}</div>

                    @if(!empty($progress))
                        <?php
                        $total_class = $progress->all_chapter_id;
                        $total_count = count($total_class);

                        $total_per = 100;

                        $read_class = $progress->mark_chapter_id;
                        $read_count =  count($read_class);

                        $progres = ($read_count/$total_count) * 100;
                        $progres = round($progres);
                        ?>
    
                    <div class="progress-block">
                        <div class="one histo-rate">
                            <span class="bar-block" style="width: 100%">
                                <span id="bar-one" style="width: <?php echo $progres; ?>%" class="bar bar-clr bar-radius">&nbsp;</span> 
                            </span>
                        </div>
                        <i class="fa fa-trophy lft-7"></i>
                    </div>
                    @else
                    <?php
                        
                        $progres = 0;
                        ?>
                    <div class="progress-block">
                        <div class="one histo-rate">
                            <span class="bar-block" style="width: 100%">
                                <span id="bar-one" style="width: 0%" class="bar bar-clr bar-radius">&nbsp;</span> 
                            </span>
                        </div>
                        <i class="fa fa-trophy lft-7"></i>
                    </div>
                    @endif
                    
                    @if(isset($items))
                        @if(isset($course->chapter[0]->courseclass[0]))
                            @if($course->chapter[0]->courseclass[0]->iframe_url == NULL)
                            <!--<div class="learning-courses-home-btn">-->
                            <!--    <a href="{{ route('watchcourse',$course->id) }}" class="iframe btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>-->
                            <!--</div>-->
                            @else
                            <div class="learning-courses-home-btn">
                                @php
                                    $url = Crypt::encrypt($course->chapter[0]->courseclass[0]->iframe_url);
                                @endphp
                                <!--<a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" class="btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>-->
                            </div>
                            @endif
                        @else
                            <!--<div class="learning-courses-home-btn">-->
                            <!--    <a href="{{ route('watchcourse',$course->id) }}" class="iframe btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>-->
                            <!--</div>-->
                        @endif
                    @endif
                            <div class="learning-courses-home-btn">
                                <button class="btn" style="background-color:#59b3d1;" title="Continue">Course progress - {{ $progres }}%</button>
                            </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- courses content header end -->
<!-- courses-content start -->
<section id="learning-courses" class="learning-courses-about-main-block">
    <div class="container">
        <div class="about-block">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active text-center" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ __('frontstaticword.Overview') }}</a>
                    <a class="nav-item nav-link text-center" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{ __('frontstaticword.CourseContent') }}</a>
                    <a class="nav-item nav-link text-center" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">{{ __('frontstaticword.Q&A') }}</a>
                    <a class="nav-item nav-link text-center" id="nav-announcement-tab" data-toggle="tab" href="#nav-announcement" role="tab" aria-controls="nav-announcement" aria-selected="false">{{ __('frontstaticword.Announcements') }}</a>
                    <!--<a class="nav-item nav-link text-center" id="nav-quiz-tab" data-toggle="tab" href="#nav-quiz" role="tab" aria-controls="nav-quiz" aria-selected="false">Course Assessments</a>-->
                    <a class="nav-item nav-link text-center" id="nav-assign-tab" data-toggle="tab" href="#nav-assign" role="tab" aria-controls="nav-assign" aria-selected="false">{{ __('frontstaticword.Assignment') }}</a>
                    <a class="nav-item nav-link text-center" id="nav-appoint-tab" data-toggle="tab" href="#nav-appoint" role="tab" aria-controls="nav-appoint" aria-selected="false">{{ __('frontstaticword.Appointment') }}</a>
                    <a class="nav-item nav-link text-center" id="nav-feedback-tab" data-toggle="tab" href="#nav-feedback" role="tab" aria-controls="nav-feedback" aria-selected="false">Feedback</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="overview-block">
                       
                        <div class="content-course-block">
                            <h4 class="content-course">{{ __('frontstaticword.Aboutthiscourse') }}</h4>
                            <p class="btm-40">{{ $course->short_detail }}</p>
                        </div>
                        <hr>
                        <div class="content-course-number-block">
                            <div class="row">
                                <div class="col-lg-3 col-sm-4">
                                    <div class="content-course-number">{{ __('frontstaticword.Bythenumbers') }}</div>
                                </div>
                                <div class="col-lg-6 col-sm-5">
                                    <div class="content-course-number">
                                        <ul>
                                          
                                            @if($course->language_id == !NULL)
                                            <li>{{ __('frontstaticword.Languages') }}: {{ $course->language->name }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3">
                                    <div class="content-course-number">
                                        <ul>
                                            <li> Modules :
                                                @php
                                                    $data = App\CourseClass::where('course_id', $course->id)->get();
                                                    if(count($data)>0){

                                                        echo count($data);
                                                    }
                                                    else{

                                                        echo "0";
                                                    }
                                                @endphp
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="content-course-number">{{ __('frontstaticword.Description') }}</div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="content-course-number content-course-one">
                                        <h5 class="content-course-number-heading">{{ __('frontstaticword.Aboutthiscourse') }}</h5>
                                        <p>{{ $course->short_detail }}<p>
                                        <h5 class="content-course-number-heading">{{ __('frontstaticword.Description') }}</h5>
                                        <p>{!! $course->detail !!}<p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!--<div class="row">-->
                            <!--    <div class="col-lg-3 col-sm-3">-->
                            <!--        <div class="content-course-number">{{ __('frontstaticword.Instructor') }}</div>-->
                            <!--    </div>-->
                            <!--    <div class="col-lg-9 col-sm-9">-->
                            <!--        <div class="content-course-number content-course-number-one">-->
                            <!--            <div class="content-img-block btm-20">-->
                            <!--                <div class="content-img">-->
                                               

                            <!--                    @if($course->user->user_img != null || $course->user->user_img !='')-->
                            <!--                      <a href="{{ route('instructor.profile', $course->user->id) }}" title="profile"><img src="{{ asset('images/user_img/'.$course->user->user_img) }}" class="img-fluid"  alt="instructor" ></a>-->
                            <!--                    @else-->
                            <!--                        <a href="{{ route('instructor.profile', $course->user->id) }}" title="profile"><img src="{{ asset('images/default/user.jpg')}}" class="img-fluid" alt="instructor"></a>-->
                            <!--                    @endif-->
                            <!--                </div>-->
                            <!--                <div class="content-img-dtl">-->
                            <!--                    <div class="profile"><a href="{{ route('instructor.profile', $course->user->id) }}" title="profile">{{ $course->user->fname }}-->
                            <!--                    </a></div>-->
                            <!--                    <p>{{ $course->user->email }}</p>-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--            <ul>-->
                            <!--                @if($course->user->twitter_url != NULL)-->
                            <!--                <li class="rgt-10"><a href="{{ $course->user['twitter_url'] }}" target="_blank" title="twitter"><i class="fab fa-twitter"></i></a></li>-->
                            <!--                @endif-->
                            <!--                @if($course->user->fb_url != NULL)-->
                            <!--                <li class="rgt-10"><a href="{{ $course->user['fb_url'] }}" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>-->
                            <!--                @endif-->
                            <!--                @if($course->user->linkedin_url != NULL)-->
                            <!--                <li class="rgt-10"><a href="{{ $course->user['linkedin_url'] }}" target="_blank" title="linkedin"><i class="fa fa-linkedin"></i></a></li>-->
                            <!--                @endif-->
                            <!--                @if($course->user->youtube_url != NULL)-->
                            <!--                <li class="rgt-10"><a href="{{ $course->user['youtube_url'] }}" target="_blank" title="twitter"><i class="fa fa-youtube"></i></a></li>-->
                            <!--                @endif-->

                            <!--            </ul>-->
                            <!--            <p>{!! $course->user->detail !!}<p>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                         <h4>{{ __('frontstaticword.RecentActivity') }}</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="learning-questions-block btm-40">
                                    <h5 class="learning-questions-heading">{{ __('frontstaticword.RecentQuestions') }}</h5>

                                    @if($coursequestions->isEmpty())
                                        <div class="learning-questions-content text-center">
                                            <h3 class="text-center">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentQuestions') }}</h3>
                                        </div>
                                    @else
                                        @php
                                            $questions = App\Question::where('course_id', $course->id)->orderBy('created_at','desc')->limit(2)->get();
                                        @endphp
                                        @foreach($questions as $question)
                                        <div class="learning-questions-dtl-block">
                                            <div class="learning-questions-img rgt-20">{{ $question->user->fname[0] }}{{ $question->user->lname[0] }}</div>
                                            <div class="learning-questions-dtl"><a href="#" title="questions">{{ $question->question }}</a>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                    <div class="learning-questions-heading"><a href="#" id="goTab3" title="browse">{{ __('frontstaticword.Browsequestions') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="learning-questions-block btm-40">
                                    <h5 class="learning-questions-heading">{{ __('frontstaticword.RecentAnnouncements') }}</h5>
                                    @if($announsments->isEmpty())
                                        <div class="learning-questions-content text-center">
                                            <h3 class="text-center">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentAnnouncements') }}</h3>
                                        </div>
                                    @else
                                        <div id="accordion" class="second-accordion">
                                        @foreach($announsments->take(2) as $announsment)
                                        <div class="card">
                                            <div class="card-header" id="headingFour{{ $announsment->id }}">
                                                <div class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour{{ $announsment->id }}" aria-expanded="true" aria-controls="collapseFour">
                                                        <div class="learning-questions-img rgt-20">{{ $announsment->user->fname[0] }}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="section"><a href="#" title="questions">{{ date('jS F Y', strtotime($announsment->created_at)) }}</a></div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="section-dividation text-right">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 offset-3 col-9 offset-sm-0"> 
                                                                <div class="profile-heading">Activities</div>
                                                            </div>
                                                            
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="collapseFour{{ $announsment->id }}" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                               
                                                <div class="card-body">
                                                    <p class="announsment-text">{{ $announsment->announsment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        </div>
                                    @endif
                                    <div class="learning-questions-heading"><a id="goTab4" href="" title="browse">{{ __('frontstaticword.Browseannouncements') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="profile-block">
                        <!--<form  method="post" action="{{ action('CourseProgressController@checked', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left">-->
                            {{ csrf_field() }}
                        
                        <div id="ck-button">
                           <label>
                              <!-- <input type="checkbox" name="select-all" class="hidden" id="select-all" /><span>Select All</span> -->
                           </label>
                        </div>
                       
                      <?php 
                        if (!empty($progress)) {
                            
                            $balance= array_diff($progress->all_chapter_id, $progress->mark_chapter_id);
                             if($balance != Null){
                            $firstkey=array_key_first($balance);
                           $check = $balance[$firstkey];   
                             }
                             else{
                                $check= $chapter->id;
                             }
                        }
                        else{
                            if(!empty($chapter->id)){
                           $check= $chapter->id;
                            }
                        }

                        ?>
                        <div id="accordion" class="second-accordion">
                            <?php $i=0;
                            $completed ="Completed";
                            $notcompleted = "Not Completed";
                            
                            ?>
                           
                            @foreach($coursechapters as $coursechapter )
                            
                            <?php $i++; ?>

                            <div class="card btm-10">
                                <div class="card-header" id="headingChapter{{ $coursechapter->id }}">
                            

                                    <div class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseChapter{{ $coursechapter->id }}" aria-expanded="true" aria-controls="collapseChapter">
                                            <div class="course-check-table">
                                            <table class="table">  
                                                <tbody>
                                                    <tr>
                                                    <!-- <td width="10px">
                                                        <div class="form-check">
                                                            <input class="form-check-input filled-in material-checkbox-input" type="checkbox" name="checked[]" value="{{$coursechapter->id}}" id="checkbox{{$coursechapter->id}}"  {{ isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id) ? "checked" : "" }} >
                                                            <label class="form-check-label" for="invalidCheck">
                                                            </label>
                                                        </div>
                                                    </td> -->
                                                    
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-6">
                                                         
                                                                <div class="section">{{ __('frontstaticword.Section') }}: <?php echo $i;?>
                                                                @if(isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id))
                                                                <span class="badge badge-success">{{$completed}}</span>
                                                                
                                                                @else
                                                                <span class="badge badge-danger">{{$notcompleted}}</span>
                                                                @endif
                                                                </div>
                                                            </div>
                                                           
                                                            <div class="col-lg-6 col-6">
                                                                <div class="section-dividation text-right">
                                                                    @php
                                                                        $classone = App\CourseClass::where('coursechapter_id', $coursechapter->id)->get();
                                                                        
                                                                        if(count($classone)>0){

                                                                            echo count($classone);
                                                                        }
                                                                        else{

                                                                            echo "0";
                                                                        }
                                                                    @endphp
                                                                    Modules
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-9 col-">

                                                                <div class="profile-heading">{{ $coursechapter->chapter_name }}
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-lg-3 col-5">
                                                                <div class="text-right">
                                                                     @php 
                                                                          $topics = App\QuizTopic::where('course_id', $course->id)->where('coursechapter_id',$coursechapter->id)->orderby('coursechapter_id')->get();
                                                                     @endphp
                                                                     @if(count($topics)>0 )
                                                                      @foreach ($topics as $topic)
                                                                      {{ $topic->due_hours}} hr {{ $topic->due_minutes }} mins
                                   
                                                                          
                                                                      @endforeach
                                                                     @endif
                                                                    @if($coursechapter->file != NULL)
                                                                    <!--<a href="{{ asset('files/material/'.$coursechapter->file) }}" target="_blank"  title="Learning Material"><i class="fa fa-download"></i></a>-->
                                                                    @endif
                                                                    
                                                                    
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div id="collapseChapter{{ $coursechapter->id }}" class="collapse" aria-labelledby="headingChapter" data-parent="#accordion">

                                    @php
                                        $classes = App\CourseClass::where('coursechapter_id', $coursechapter->id)->orderBy('position','ASC')->get();

                                        $mytime = Carbon\Carbon::now();
                                        if(!empty($progress)){;
                                            $comp = in_array($coursechapter->id,$progress->mark_chapter_id);
                                        }
                                        else{
                                            $comp = $chapter->id;
                                        }
                                        
                                    @endphp
                                     
                                    <!--@if($coursechapter->id == $check || $coursechapter->id == $comp)-->
                                    <!--  @else-->
                                    <!--<div class="container">-->
                                    <!--<p class="m-3"><i class="fa fa-lock"></i> Complete previous chapter to unlock this</p>-->
                                    <!--</div>-->
                                    <!--@endif -->
                                    @foreach($classes as $class)                                                                  
                                    <input type="hidden" value=" {{ $course->id }}" id="course_id">
                                    
                                    @php
                                       $classprog = App\ClassProgress::where('user_id',Auth::user()->id)->where('chapter_id',$coursechapter->id)->where('class_id',$class->id)->first();
		                            @endphp

                                    <div class="card-body">
                                        <table class="table" style="width: 100%;">  
                                            <tbody>
                                                <tr>
                                                    <td class="class-type content" style="width: 60%;">

                                                        @if($class->type =='video' && $class->video )
                                                          <a href="{{ route('watchcourseclass',$class->id) }}" id="completed" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" id="check" title="Course"  class="iframe"><i class="fa fa-play-circle"></i>&nbsp; {{ $class->title }}</a>
                                                          
                                                        @endif
                                                        
                                                        @php
                                                            $url = Crypt::encrypt($class->iframe_url);
                                                        @endphp
                                                        @if($class->type =='video' && $class->iframe_url )
                                                        <a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fa fa-play-circle"></i>&nbsp; {{ $class->title }}</a>
                                                      
                                                        @endif
                                                        @if($class->type =='audio' && $class->audio)
                                                        <a href="{{ route('audiocourseclass',$class->id) }}" title="class" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" class="iframe"><i class="fa fa-play-circle"></i>&nbsp; {{ $class->title }}</a>
                                                        @endif
                                                        @if($class->type =='image' && $class->image )
                                                        <a href="{{ asset('images/class/'.$class->image) }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->image}}" title="Course"><i class="fas fa-image"></i>&nbsp; {{ $class->title }}</a>
                                                        @endif
                                                        @if($class->type =='pdf' && $class->pdf )
                                                        <a href="{{asset('files/pdf/'.$class->pdf)}}" target="_blank" id="iframe" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-file-pdf"></i>&nbsp; {{ $class->title }}</a>
                                                        @endif
                                                        @if($class->type =='zip' && $class->zip )
                                                        <a href="{{ asset('files/zip/'.$class->zip) }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->zip}}" title="Course"><i class="far fa-file-archive"></i>&nbsp; {{ $class->title }}</a>
                                                        @endif
                                                        @if($class->url)
                                                            @if($class->type =='video')
                                                            @if($mytime >= $class->date_time)
                                                            <a href="{{ route('watchcourseclass',$class->id) }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course" class="iframe"><i class="fa fa-play-circle"></i>&nbsp; {{ $class->title }}</a>
                                                            @else
                                                            <a href="" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fa fa-play-circle"></i>&nbsp; {{ $class->title }}</a>
                                                            @endif
                                                            @endif
                                                            @if($class->type =='image')
                                                            <a href="{{ $class->url }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-image"></i>&nbsp; {{ $class->title }}</a>
                                                            @endif
                                                            @if($class->type =='pdf')
                                                            <a href="{{ $class->url }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-file-pdf"></i>&nbsp; {{ $class->title }}</a>
                                                            @endif
                                                            @if($class->type =='zip')
                                                            <a href="{{ $class->url }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="far fa-file-archive">&nbsp; {{ $class->title }}</i></a>
                                                            @endif
                                                            @if($class->type =='audio')
                                                            <a href="{{ route('audiocourseclass',$class->id) }}" onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course" class="iframe"><i class="fa fa-play-circle" >&nbsp; {{ $class->title }}</i></a>
                                                            @endif
                                                        @endif 
                                                    </td>

                                                    <!--<td class="class-name">-->
                                                    <!--    <a href="#" title="Course">{{ $class->title }}</a>&nbsp;-->
                                                    <!--    @if($class->date_time != NULL)-->
                                                    <!--       <div class="live-class">Live at: {{ $class->date_time }}</div>-->
                                                    <!--    @endif-->
                                                    <!--</td>-->

                                                    <!--<td class="class-size txt-rgt">-->
                                                    <!--    @if($class->type =='video' || $class->type =='audio')-->
                                                    <!--        {{ $class->duration }} Min-->
                                                    <!--    @endif-->
                                                    <!--    @if($class->type =='image' || $class->type =='pdf' || $class->type =='zip' )-->
                                                    <!--        {{ $class->size }} Mb-->
                                                    <!--    @endif-->
                                                    <!--</td>-->
                                                    
                                                    <td class="class-type content txt-rgt pdfvisiviewcheck" style="width: 20%;">

                                                        @if($class->type =='video' && $class->video )
                                                          <a href="{{ route('watchcourseclass',$class->id) }}" id="completed" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" id="check" title="Course"  class="iframe"><i class="fa fa-play-circle"></i>&nbsp; </a>
                                                          
                                                          @endif
                                                        
                                                        @php
                                                            $url = Crypt::encrypt($class->iframe_url);
                                                        @endphp
                                                        @if($class->type =='video' && $class->iframe_url )
                                                        <a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fa fa-download"></i>&nbsp; </a>
                                                      
                                                        @endif
                                                        @if($class->type =='audio' && $class->audio)
                                                        <a href="{{ route('audiocourseclass',$class->id) }}" title="class" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" class="iframe"><i class="fa fa-download"></i>&nbsp; </a>
                                                        @endif
                                                        @if($class->type =='image' && $class->image )
                                                        <a href="{{ asset('images/class/'.$class->image) }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->image}}" title="Course"><i class="fas fa-download"></i>&nbsp; </a>
                                                        @endif
                                                        @if($class->type =='pdf' && $class->pdf )
                                                        <a href="{{asset('files/pdf/'.$class->pdf)}}" target="_blank" id="pdfclassview{{ $class->id }}"  onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-eye"></i>&nbsp; View &nbsp;&nbsp;</a>
                                                        @endif
                                                        @if($class->type =='zip' && $class->zip )
                                                        <a href="{{ asset('files/zip/'.$class->zip) }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->zip}}" title="Course"><i class="far fa-download"></i>&nbsp; </a>
                                                        @endif
                                                        @if($class->url)
                                                            @if($class->type =='video')
                                                            @if($mytime >= $class->date_time)
                                                            <a href="{{ route('watchcourseclass',$class->id) }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course" class="iframe"><i class="fa fa-download"></i>&nbsp; </a>
                                                            @else
                                                            <a href="" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fa fa-download"></i>&nbsp;</a>
                                                            @endif
                                                            @endif
                                                            @if($class->type =='image')
                                                            <a href="{{ $class->url }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-download"></i>&nbsp; </a>
                                                            @endif
                                                            @if($class->type =='pdf')
                                                            <a href="{{asset('files/pdf/'.$class->pdf)}}" target="_blank" id="pdfclassview{{ $class->id }}"  onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-eye"></i>&nbsp; View /</a>
                                                            @endif
                                                            @if($class->type =='zip')
                                                            <a href="{{ $class->url }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="far fa-download">&nbsp; </i></a>
                                                            @endif
                                                            @if($class->type =='audio')
                                                            <a href="{{ route('audiocourseclass',$class->id) }}" onclick="pdfvisiviewcheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course" class="iframe"><i class="fa fa-download" >&nbsp; </i></a>
                                                            @endif
                                                        @endif 
                                                    </td>
                                                   
                                                    <td class="class-type content txt-rgt pdfvisicheck" style="width: 20%;">

                                                        @if($class->type =='video' && $class->video )
                                                          <a href="{{ route('watchcourseclass',$class->id) }}" id="completed" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" id="check" title="Course"  class="iframe"><i class="fa fa-play-circle"></i>&nbsp; </a>
                                                          
                                                          @endif
                                                        
                                                        @php
                                                            $url = Crypt::encrypt($class->iframe_url);
                                                        @endphp
                                                        @if($class->type =='video' && $class->iframe_url )
                                                        <a href="{{ route('watchinframe',[$url, 'course_id' => $course->id]) }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fa fa-download"></i>&nbsp; </a>
                                                      
                                                        @endif
                                                        @if($class->type =='audio' && $class->audio)
                                                        <a href="{{ route('audiocourseclass',$class->id) }}" title="class" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" class="iframe"><i class="fa fa-download"></i>&nbsp; </a>
                                                        @endif
                                                        @if($class->type =='image' && $class->image )
                                                        <a href="{{ asset('images/class/'.$class->image) }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->image}}" title="Course"><i class="fas fa-download"></i>&nbsp; </a>
                                                        @endif
                                                        @if($class->type =='pdf' && $class->pdf )
                                                        <a href="{{asset('files/pdf/'.$class->pdf)}}" target="_blank" id="downchap{{ $class->id }}" download="{{$class->pdf}}"  onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-download"></i>&nbsp; Download </a>
                                                        @endif
                                                        @if($class->type =='zip' && $class->zip )
                                                        <a href="{{ asset('files/zip/'.$class->zip) }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->zip}}" title="Course"><i class="far fa-download"></i>&nbsp; </a>
                                                        @endif
                                                        @if($class->url)
                                                            @if($class->type =='video')
                                                            @if($mytime >= $class->date_time)
                                                            <a href="{{ route('watchcourseclass',$class->id) }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course" class="iframe"><i class="fa fa-download"></i>&nbsp; </a>
                                                            @else
                                                            <a href="" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fa fa-download"></i>&nbsp;</a>
                                                            @endif
                                                            @endif
                                                            @if($class->type =='image')
                                                            <a href="{{ $class->url }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="fas fa-download"></i>&nbsp; </a>
                                                            @endif
                                                            @if($class->type =='pdf')
                                                            <a href="{{ $class->url }}" id="downchap{{ $class->id }}" target="_blank" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" download="{{$class->pdf}}"  title="Course"><i class="fas fa-download"></i>&nbsp; Download</a>
                                                            @endif
                                                            @if($class->type =='zip')
                                                            <a href="{{ $class->url }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course"><i class="far fa-download">&nbsp; </i></a>
                                                            @endif
                                                            @if($class->type =='audio')
                                                            <a href="{{ route('audiocourseclass',$class->id) }}" onclick="pdfvisicheck('{{ $class->id }}', '{{ $coursechapter->id }}')" title="Course" class="iframe"><i class="fa fa-download" >&nbsp; </i></a>
                                                            @endif
                                                        @endif 
                                                    </td>
                                                  
                                                </tr>
                                               
                          
                                            </tbody>
                                        </table>

                                    </div>
                                  

                                    @endforeach 
                                      <!-- Assessments within Section -->
                                    
                                 <div class="container">
                                    <div class="quiz-main-block">
                          <div class="row">
                            @php 
                                $topics = App\QuizTopic::where('course_id', $course->id)->where('coursechapter_id',$coursechapter->id)->orderby('coursechapter_id')->get();
                            @endphp
                            @if(count($topics)>0 )
                              @foreach ($topics as $topic)
                              @if($topic->status == 1)

                                @if(Auth::User()->role == 'instructor' || Auth::User()->role == 'user')
                                <?php
                                    $order = App\Order::where('course_id', $course->id)->where('user_id', '=', Auth::user()->id)->first();
	                                $classprogress = App\ClassProgress::where('user_id',Auth::user()->id)->where('course_id',$course->id)->
			                                        	where('chapter_id',$coursechapter->id)->first();
                                    $hours = $topic->due_hours;
                                    $minhour = $hours * 60;
                                    $minutes = $topic->due_minutes;
                                    $mins = $minhour + $minutes;
                                    $orderDate = $order['created_at'];
                                    $startDateDays = date("Y-m-d", strtotime("$orderDate +$hours days"));
                                    
                                                                          

                                    
                                     if(isset($classprogress)){
                                    
                                    $dt =$classprogress->created_at;
                                    $startDate= $dt->addMinutes($mins);
                                   
                                    }
                                    else{
                                        
                                    
                                     if(isset($progress)){
                                        //  echo $progress;
                                        
                                        $complete = array_diff($progress->all_chapter_id,$progress->mark_chapter_id);
                                       // print_r($complete);
                                     
                                        }
                                    if($topic->final_assess == 1 && in_array($topic->coursechapter_id,$complete)){
                                      $startDate = Carbon\Carbon::now();
                                    }
                                    elseif(in_array($topic->coursechapter_id,$progress->mark_chapter_id)){
                                        $startDate = Carbon\Carbon::now();
                                    }
                                    else{
                                        $startDate = '2050-09-21 10:18:27';
                                    }
                                    }
                                ?>

                                @else

                                <?php
                                    
                                    $startDate = '0';
                                ?>
                               
                                @endif

                                @php
                                    $mytime = Carbon\Carbon::now(); 
                                @endphp

                              
                                 @if($mytime >= $startDate) 
                                <div class="col-md-6 col-lg-4">
                                  <div class="topic-block">
                                    <div class="card blue-grey darken-1">
                                      <div class="card-content dark-text">
                                        <span class="card-title">{{$topic->title}}</span>
                                        @php 
                                             $coursechapterfin = App\CourseChapter::where('id',$topic->coursechapter_id)->first();
                                        @endphp
                                        
                                        <!--<span class="card-title">{{$coursechapter->chapter_name}}</span>-->
                                        <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                                        <div class="row">
                                          <div class="col-lg-6 col-7">
                                            <ul class="topic-detail">
                                              <li>{{ __('frontstaticword.PerQuestionMark') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalMarks') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalQuestions') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <!--<li>{{ __('frontstaticword.QuizPrice') }}<i class="fa fa-long-arrow-right"></i></li>-->
                                            </ul>
                                          </div>
                                          <div class="col-lg-6 col-5">
                                            <ul class="topic-detail">
                                              <li>{{$topic->per_q_mark}}</li>
                                              <li>
                                                @php
                                                    $qu_count = 0;
                                                    $quizz = App\Quiz::get();
                                                @endphp
                                                @foreach($quizz as $quiz)
                                                  @if($quiz->topic_id == $topic->id)
                                                    @php 
                                                      $qu_count++;
                                                    @endphp
                                                  @endif
                                                @endforeach
                                                {{$topic->per_q_mark*$qu_count}}
                                              </li>
                                              <li>
                                                {{$qu_count}}
                                              </li>
                                              
                                              <li>
                                                <!--{{ __('frontstaticword.Free') }}-->
                                              </li>

                                            </ul>
                                          </div>
                                        </div>
                                      </div>


                                   <div class="card-action text-center">

                                      @php
                                        $users =  App\QuizAnswer::where('topic_id',$topic->id)->where('user_id',Auth::user()->id)->first();
                                        $quiz_question =  App\Quiz::where('course_id',$course->id)->get();

                                      @endphp
                                      @if(empty($users))
                                        @if($quiz_question != null || $quiz_question!= '')
                                         
                                            <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Assessment</a>
                                        
                                        @endif
                                      @else
                                         <a href="{{route('start.quiz.show',$topic->id)}}" class="btn btn-block">Assessment Report </a>
                                       
                                        @if($topic->quiz_again == '1')
                                         <a href="{{route('tryagain',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.TryAgain') }} </a>
                                        @endif
                                        
                                      @endif
                                     
                                        
                                      </div>
                                    
                                    </div>
                                  </div>
                                </div>
                               @endif

                               
                              @endif
                              @endforeach
                            
                          
                            @else
                                <div class="m-auto" >
                                    <div class="col-lg-12">
                                        <h3>No Assessments</h3>
                                        <!--<p>{{ __('frontstaticword.Noquizsdetail') }}</p>-->
                                    </div>
                                </div> 
                            @endif
                          </div>
                            

                        </div>
                       
                           </div>
                               
                   <div class="container">
                       
                     
                       
                      <button data-toggle="modal" data-target="#modulefeedback{{ $coursechapter->id }}" class="btn btn-primary btm-20">Feedback</button>
                                    
                                      
                    <div class="modal " id="modulefeedback{{ $coursechapter->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <div class="">
                                    <h5 class="top-20"></h5>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <form id="demo-form10" method="post" action="{{route('module.rating',$course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        <div class="review-table top-20">
                                            <input type="hidden" value="{{ $coursechapter->id }}" name="chapter_id">
                                            
                                           
                                            <div class="form-group">
                                                <label for="title">1. Have you faced any difficulty in understanding the course content ?</label>                         
                                                <textarea name="qn1" rows="1" class="form-control" placeholder=""></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="title">2. Do you require any additional support to understand the course content completely ?</label>                         
                                                <textarea name="qn2" rows="1" class="form-control" placeholder=""></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="title">3. Do you think the assessment questions are relevant to the course content ?</label>                         
                                                <textarea name="qn3" rows="1" class="form-control" placeholder=""></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="title">4. Have you completed reading and understanding the course content within the stipulated period ?</label>                         
                                                <textarea name="qn4" rows="1" class="form-control" placeholder=""></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="title">5. Do you have any suggestions for the improvement of the course content ?</label>                         
                                                <textarea name="qn5" rows="1" class="form-control" placeholder=""></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="title">6. Other remarks</label>                         
                                                <textarea name="qn6" rows="1" class="form-control" placeholder=""></textarea>
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
                                 </div>
                                                                    
                                 
                              </div>
                                
                            </div>
                           @endforeach
                        </div>                        
                        <div class="mark-read-button">
                            <!-- <button type="submit" class="btn btn-md btn-primary">
                                Mark as Complete
                            </button> -->
                        </div>
                        <!--</form>-->
                        
                    </div>
                    

                    @if(!empty($progress))
                      @if($read_count == $total_count)
                      @php
                          $review = App\ReviewRating::where('user_id', Auth::User()->id)->where('course_id', $course->id)->first();
                      @endphp
                     @if(isset($review))
                     <a href="{{route('cirtificate.download',$course->id)}}" target="_blank"  class="btn btn-danger btm-20">Download Certificate</a>

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
                                    <form id="demo-form2" method="post" action="{{route('coursecert.rating',$course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
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
                
                
              
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="learning-contact-block">
                        @php
                        $orders = App\Order::where('user_id',Auth::user()->id)->where('course_id',$course->id)->first();
                        @endphp
                        <div class="row">
                            @if(Auth::user()->role == 'user')
                                <div class="col-lg-12">
                                <div class="contact-search-block btm-40">
                                    <div class="learning-contact-search">
                                        @if($coursequestions->isEmpty())
                                            <h4 class="question-text">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentQuestions') }}</h4>
                                        @else
                                            <h4 class="question-text">
                                            @php
                                                $quess = App\Question::where('course_id', $course->id)->get();
                                                if(count($quess)>0){

                                                    echo count($quess);
                                                }
                                                else{

                                                    echo "0";
                                                }
                                            @endphp
                                            {{ __('frontstaticword.questionsinthiscourse') }}</h4>
                                        @endif
                                        
                                    </div>
                                    <div class="learning-contact-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">{{ __('frontstaticword.Askanewquestion') }}
                                        </button>

                                        <!--Model start-->
                                        <div id="myModal" class="modal fade" role="dialog">
                                          <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">{{ __('frontstaticword.Askanewquestion') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>

                                              <div class="modal-body">
                                                
                                                <form id="demo-form2" method="post" action="{{ url('addquestion', $course->id) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                            
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                        <input type="hidden" name="instructor_id" class="form-control" value="{{$course->user_id}}"  />
                                                        <input type="hidden" name="user_id"  value="{{Auth::user()->id}}" />
                                                      </div>
                                                      <div class="col-md-6">
                                                        <input type="hidden" name="course_id"  value="{{$course->id}}" />
                                                        <input type="hidden" name="status"  value="1" />
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                        <label for="detail">{{ __('frontstaticword.Question') }}:<sup class="redstar">*</sup></label>
                                                        <textarea name="question" rows="4"  class="form-control" placeholder=""></textarea>
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="box-footer">
                                                     <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('frontstaticword.Close') }}</button>
                                              </div>
                                            </div>

                                          </div>
                                        </div>
                                        <!--Model end-->
                                    </div>
                                </div>
                                
                                <div id="accordion" class="second-accordion" style="margin-bottom:150px;">
                                    @php
                                        $questions = App\Question::where('course_id', $course->id)->get();
                                    @endphp
                                    @foreach($questions as $ques)
                                    @if($ques->status == 1)
                                    <div class="card btm-10">
                                        <div class="card-header" id="headingThree{{ $ques->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree{{ $ques->id }}" aria-expanded="true" aria-controls="collapseThree">
                                                    <div class="learning-questions-img rgt-10">{{ $ques->user->fname[0] }}{{ $ques->user->lname[0]  }}
                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-6 col-8">
                                                            <div class="section">
                                                                <a href="#" title="questions">{{ $ques->user->fname }} </a> 
                                                                <a href="#" title="questions">{{ date('jS F Y', strtotime($ques->created_at)) }}</a>
                                                                <div class="author-tag">
                                                                    {{ $ques->user->role }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-lg-5 col-3">
                                                            <div class="section-dividation text-right">
                                                                @php
                                                                    $answer = App\Answer::where('question_id', $ques->id)->get();
                                                                    if(count($answer)>0){

                                                                        echo count($answer);
                                                                    }
                                                                    else{

                                                                        echo "0";
                                                                    }
                                                                @endphp
                                                                {{ __('frontstaticword.Answer') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-1">
                                                            <div class="question-report txt-rgt">
                                                                 <a href="#" data-toggle="modal" data-target="#myModalquesReport{{ $ques->id }}" title="response"><i class="fa fa-flag" aria-hidden="true"></i></a>
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-8 col-8"> 
                                                            <div class="profile-heading profile-heading-two">{{ $ques->question }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-3"> 
                                                            <div class="profile-heading txt-rgt"><a href="#" data-toggle="modal" data-target="#myModalanswer{{ $ques->id }}" title="response">{{ __('frontstaticword.AddAnswer') }}</a>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <!--Model start-->
                                        <div class="modal fade" id="myModalanswer{{ $ques->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">

                                                  <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Answer') }}</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                    
                                                    <form id="demo-form2" method="post" action="{{ url('addanswer', $ques->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                        <input type="hidden" name="question_id"  value="{{$ques->id}}" />
                                                        <input type="hidden" name="instructor_id"  value="{{$course->user_id}}" />
                                                        <input type="hidden" name="ans_user_id"  value="{{Auth::user()->id}}" />
                                                        <input type="hidden" name="ques_user_id"  value="{{$ques->user_id}}" />
                                                        <input type="hidden" name="course_id"  value="{{$ques->course_id}}" />
                                                        <input type="hidden" name="question_id"  value="{{$ques->id}}" />
                                                        <input type="hidden" name="status"  value="1" />       
                                                        
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            {{ $ques->question }}
                                                            <br>
                                                            <br>
                                                          </div>
                                                          <div class="col-md-12">
                                                            <label for="detail">{{ __('frontstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                                            <textarea name="answer" rows="4"  class="form-control" placeholder=""></textarea>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                         <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                                        </div>
                                        <!--Model close -->

                                        <!--Model start Question Report-->
                                                           
                                        <div class="modal fade" id="myModalquesReport{{ $ques->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">

                                                  <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Report') }} Question</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                    
                                                    <form id="demo-form2" method="post" action="{{ route('question.report', $ques->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                        <input type="hidden" name="course_id"  value="{{ $course->id }}" />

                                                        <input type="hidden" name="question_id"  value="{{ $ques->id }}" />
                                                                
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">{{ __('frontstaticword.Email') }}:<sup class="redstar">*</sup></label>
                                                                <input type="email" class="form-control" name="email" id="title" placeholder="Please Enter Email" value="{{ Auth::user()->email }}" required>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('frontstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea name="detail" rows="4"  class="form-control" placeholder="Enter Detail" required></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                                        </div>
                                      
                                        <!--Model close -->

                                        
                                        <div id="collapseThree{{ $ques->id }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            @php
                                                $answers = App\Answer::where('question_id', $ques->id)->get();
                                            @endphp
                                            @foreach($answers as $ans)
                                            @if($ans->status == 1)
                                            <div class="card-body">
                                                <div class="answer-block">
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-1 col-2">
                                                            <div class="learning-questions-img-two">{{ $ans->user->fname[0] }}{{ $ans->user->lname[0]  }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-11 col-10">
                                                            
                                                            <div class="section">
                                                                <a href="#" title="questions">{{ $ans->user->fname }}</a> <a href="#" title="questions">{{ date('jS F Y', strtotime($ans->created_at)) }}</a>
                                                                <div class="author-tag">
                                                                    {{ $ans->user->role }}
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <div class="section-answer">
                                                                <a href="#" title="Course">{{ $ans->answer }}</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                           
                            @else 
                               <div class="col-lg-12">
                                <div class="contact-search-block btm-40">
                                    <div class="learning-contact-search">
                                        @if($coursequestions->isEmpty())
                                            <h4 class="question-text">{{ __('frontstaticword.No') }} {{ __('frontstaticword.RecentQuestions') }}</h4>
                                        @else
                                            <h4 class="question-text">
                                            @php
                                                $quess = App\Question::where('course_id', $course->id)->get();
                                                if(count($quess)>0){

                                                    echo count($quess);
                                                }
                                                else{

                                                    echo "0";
                                                }
                                            @endphp
                                            {{ __('frontstaticword.questionsinthiscourse') }}</h4>
                                        @endif
                                        
                                    </div>
                                    <div class="learning-contact-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">{{ __('frontstaticword.Askanewquestion') }}
                                        </button>

                                        <!--Model start-->
                                        <div id="myModal" class="modal fade" role="dialog">
                                          <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">{{ __('frontstaticword.Askanewquestion') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>

                                              <div class="modal-body">
                                                
                                                <form id="demo-form2" method="post" action="{{ url('addquestion', $course->id) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                            
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                        <input type="hidden" name="instructor_id" class="form-control" value="{{$course->user_id}}"  />
                                                        <input type="hidden" name="user_id"  value="{{Auth::user()->id}}" />
                                                      </div>
                                                      <div class="col-md-6">
                                                        <input type="hidden" name="course_id"  value="{{$course->id}}" />
                                                        <input type="hidden" name="status"  value="1" />
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                        <label for="detail">{{ __('frontstaticword.Question') }}:<sup class="redstar">*</sup></label>
                                                        <textarea name="question" rows="4"  class="form-control" placeholder=""></textarea>
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="box-footer">
                                                     <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('frontstaticword.Close') }}</button>
                                              </div>
                                            </div>

                                          </div>
                                        </div>
                                        <!--Model end-->
                                    </div>
                                </div>
                                
                                <div id="accordion" class="second-accordion" style="">
                                    @php
                                        $questions = App\Question::where('course_id', $course->id)->get();
                                    @endphp
                                    @foreach($questions as $ques)
                                    @if($ques->status == 1)
                                    <div class="card btm-10">
                                        <div class="card-header" id="headingThree{{ $ques->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree{{ $ques->id }}" aria-expanded="true" aria-controls="collapseThree">
                                                    <div class="learning-questions-img rgt-10">{{ $ques->user->fname[0] }}{{ $ques->user->lname[0]  }}
                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-6 col-8">
                                                            <div class="section">
                                                                <a href="#" title="questions">{{ $ques->user->fname }} </a> 
                                                                <a href="#" title="questions">{{ date('jS F Y', strtotime($ques->created_at)) }}</a>
                                                                <div class="author-tag">
                                                                    {{ $ques->user->role }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-lg-5 col-3">
                                                            <div class="section-dividation text-right">
                                                                @php
                                                                    $answer = App\Answer::where('question_id', $ques->id)->get();
                                                                    if(count($answer)>0){

                                                                        echo count($answer);
                                                                    }
                                                                    else{

                                                                        echo "0";
                                                                    }
                                                                @endphp
                                                                {{ __('frontstaticword.Answer') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-1">
                                                            <div class="question-report txt-rgt">
                                                                 <a href="#" data-toggle="modal" data-target="#myModalquesReport{{ $ques->id }}" title="response"><i class="fa fa-flag" aria-hidden="true"></i></a>
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-8 col-8"> 
                                                            <div class="profile-heading profile-heading-two">{{ $ques->question }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-3"> 
                                                            <div class="profile-heading txt-rgt"><a href="#" data-toggle="modal" data-target="#myModalanswer{{ $ques->id }}" title="response">{{ __('frontstaticword.AddAnswer') }}</a>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <!--Model start-->
                                        <div class="modal fade" id="myModalanswer{{ $ques->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">

                                                  <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Answer') }}</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                    
                                                    <form id="demo-form2" method="post" action="{{ url('addanswer', $ques->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                        <input type="hidden" name="question_id"  value="{{$ques->id}}" />
                                                        <input type="hidden" name="instructor_id"  value="{{$course->user_id}}" />
                                                        <input type="hidden" name="ans_user_id"  value="{{Auth::user()->id}}" />
                                                        <input type="hidden" name="ques_user_id"  value="{{$ques->user_id}}" />
                                                        <input type="hidden" name="course_id"  value="{{$ques->course_id}}" />
                                                        <input type="hidden" name="question_id"  value="{{$ques->id}}" />
                                                        <input type="hidden" name="status"  value="1" />       
                                                        
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            {{ $ques->question }}
                                                            <br>
                                                            <br>
                                                          </div>
                                                          <div class="col-md-12">
                                                            <label for="detail">{{ __('frontstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                                            <textarea name="answer" rows="4"  class="form-control" placeholder=""></textarea>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                         <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>

                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                                        </div>
                                        <!--Model close -->

                                        <!--Model start Question Report-->
                                                           
                                        <div class="modal fade" id="myModalquesReport{{ $ques->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">

                                                  <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Report') }} Question</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                  <div class="panel panel-sum">
                                                    <div class="modal-body">
                                                    
                                                    <form id="demo-form2" method="post" action="{{ route('question.report', $ques->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                        <input type="hidden" name="course_id"  value="{{ $course->id }}" />

                                                        <input type="hidden" name="question_id"  value="{{ $ques->id }}" />
                                                                
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">{{ __('frontstaticword.Email') }}:<sup class="redstar">*</sup></label>
                                                                <input type="email" class="form-control" name="email" id="title" placeholder="Please Enter Email" value="{{ Auth::user()->email }}" required>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('frontstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea name="detail" rows="4"  class="form-control" placeholder="Enter Detail" required></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <br>
                                                        <div class="box-footer">
                                                            <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div> 
                                        </div>
                                      
                                        <!--Model close -->

                                        
                                        <div id="collapseThree{{ $ques->id }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            @php
                                                $answers = App\Answer::where('question_id', $ques->id)->get();
                                            @endphp
                                            @foreach($answers as $ans)
                                            @if($ans->status == 1)
                                            <div class="card-body">
                                                <div class="answer-block">
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-1 col-2">
                                                            <div class="learning-questions-img-two">{{ $ans->user->fname[0] }}{{ $ans->user->lname[0]  }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-11 col-10">
                                                            
                                                            <div class="section">
                                                                <a href="#" title="questions">{{ $ans->user->fname }}</a> <a href="#" title="questions">{{ date('jS F Y', strtotime($ans->created_at)) }}</a>
                                                                <div class="author-tag">
                                                                    {{ $ans->user->role }}
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <div class="section-answer">
                                                                <a href="#" title="Course">{{ $ans->answer }}</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab">
                    @if($announsments->isEmpty())
                        <div class="learning-announcement-null text-center">
                            <div class="offset-lg-2 col-lg-8">
                                <h1>{{ __('frontstaticword.Noannouncements') }}</h1>
                                <p>{{ __('frontstaticword.Noannouncementsdetail') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="learning-announcement text-center">
                            <div class="col-lg-12">
                                <div id="accordion" class="second-accordion">
                                    
                                    @foreach($announsments as $announsment)
                                    @if($announsment->status == 1)
                                    <div class="card btm-30">
                                        <div class="card-header" id="headingFive{{ $announsment->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="" aria-expanded="true" aria-controls="collapseFive">
                                                    <!--<div class="learning-questions-img rgt-20 mt-2">{{ $announsment->user->fname[0] }}-->
                                                    <!--</div>-->
                                                    <div class="row p-2">
                                                        <div class="col-lg-6">
                                                            <h5>Activities</h5>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="section-dividation text-right">
                                                                <div class="section"> <a href="#" title="questions">{{ date('d-m-Y', strtotime($announsment->created_at)) }}</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row p-2">
                                                        <div class="col-lg-12 offset-3 col-9 offset-sm-0 col-sm-12 offset-md-0 col-md-12"> 
                                                            <div class="profile-heading profile-heading-one">
                                                               {{ $announsment->announsment }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="collapseFive{{ $announsment->id }}" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                            <div class="card-body">
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="nav-quiz" role="tabpanel" aria-labelledby="nav-quiz-tab">
                    <div class="container">
                        <div class="quiz-main-block">
                          <div class="row">
                            @php 
                                $topics = App\QuizTopic::where('course_id', $course->id)->get();
                            @endphp
                            @if(count($topics)>0 )
                              @foreach ($topics as $topic)
                              @if($topic->status == 1)

                                @if(Auth::User()->role == 'instructor' || Auth::User()->role == 'user')
                                <?php 
                                    $order = App\Order::where('course_id', $course->id)->where('user_id', '=', Auth::user()->id)->first();

                                    $days = $topic->due_hours;
                                    $orderDate = $order['created_at'];
                                    $startDate = date("Y-m-d", strtotime("$orderDate +$days days"));
                                ?>

                                @else

                                <?php 
                                    
                                    $startDate = '0';
                                ?>
                                @endif


                                @php
                                    $mytime = Carbon\Carbon::now();
                                @endphp

                               
                               
                                @if($mytime >= $startDate)
                              
                                <div class="col-md-6 col-lg-4">
                                  <div class="topic-block">
                                    <div class="card blue-grey darken-1">
                                      <div class="card-content dark-text">
                                        <span class="card-title">{{$topic->title}}</span>
                                        <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                                        <div class="row">
                                          <div class="col-lg-6 col-7">
                                            <ul class="topic-detail">
                                              <li>{{ __('frontstaticword.PerQuestionMark') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalMarks') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.TotalQuestions') }}<i class="fa fa-long-arrow-right"></i></li>
                                              <li>{{ __('frontstaticword.QuizPrice') }}<i class="fa fa-long-arrow-right"></i></li>
                                            </ul>
                                          </div>
                                          <div class="col-lg-6 col-5">
                                            <ul class="topic-detail">
                                              <li>{{$topic->per_q_mark}}</li>
                                              <li>
                                                @php
                                                    $qu_count = 0;
                                                    $quizz = App\Quiz::get();
                                                @endphp
                                                @foreach($quizz as $quiz)
                                                  @if($quiz->topic_id == $topic->id)
                                                    @php 
                                                      $qu_count++;
                                                    @endphp
                                                  @endif
                                                @endforeach
                                                {{$topic->per_q_mark*$qu_count}}
                                              </li>
                                              <li>
                                                {{$qu_count}}
                                              </li>
                                              
                                              <li>
                                                {{ __('frontstaticword.Free') }}
                                              </li>

                                            </ul>
                                          </div>
                                        </div>
                                      </div>


                                   <div class="card-action text-center">

                                      @php
                                        $users =  App\QuizAnswer::where('topic_id',$topic->id)->where('user_id',Auth::user()->id)->first();
                                        $quiz_question =  App\Quiz::where('course_id',$course->id)->get();

                                      @endphp
                                      @if(empty($users))
                                        @if($quiz_question != null || $quiz_question!= '')
                                         
                                            <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz"> {{ __('frontstaticword.StartQuiz') }}</a>
                                        
                                        @endif
                                      @else
                                         <a href="{{route('start.quiz.show',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.ShowQuizReport') }} </a>
                                       
                                        @if($topic->quiz_again == '1')
                                         <a href="{{route('tryagain',$topic->id)}}" class="btn btn-block">{{ __('frontstaticword.TryAgain') }} </a>
                                        @endif
                                      @endif
                                        
                                      </div>
                                    
                                    </div>
                                  </div>
                                </div>

                                @endif

                               
                              @endif
                              @endforeach
                            @else
                                
                                <div class="learning-quiz-null text-center">
                                    <div class="col-lg-12">
                                        <h1>{{ __('frontstaticword.Noquiz') }}</h1>
                                        <p>{{ __('frontstaticword.Noquizsdetail') }}</p>
                                    </div>
                                </div> 
                            @endif
                          </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-assign" role="tabpanel" aria-labelledby="nav-assign-tab">
                    <div class="container">
                        <div class="assignment-main-block">
                            <h3>{{ __('frontstaticword.YourAssignments') }}</h3>
                          <div class="row">

                            <div class="col-md-8">

                                <div class="row">
                                @foreach($assignment as $assign)
                                    <div class="col-md-12">
                                        <div class="assignment-tab-block">
                                            <div class="categories-block assign-tab-one text-center">
                                                <ul>
                                                    <li class="btm-5"><span>{{ $assign->title }}</span></li>
                                                    <li>
                                                        <a href="{{ asset('files/assignment/'.$assign->assignment) }}" download="{{$assign->assignment}}" title="Course">{{ __('frontstaticword.Download') }} <i class="fa fa-download"></i></a>
                                                   
                                                        <form  method="post" action="{{url('assignment/delete/'.$assign->id)}}" ata-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart"> {{ __('frontstaticword.Delete') }}</button>
                                                      </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                
                                @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="contact-search-block btm-40">
                                    
                                    <div class="udemy-contact-btn text-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignmodel">{{ __('frontstaticword.SubmitAssignment') }}
                                        </button>
                                    </div>
                                    <div class="modal fade" id="assignmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-sm" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.SubmitAssignment') }}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                              <div class="panel panel-sum">
                                                <div class="modal-body">
                                                    <form id="demo-form2" method="post" action="{{ route('assignment.submit', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id"  value="{{ Auth::user()->id }}" />

                                                        <input type="hidden" name="instructor_id"  value="{{ $course->user_id }}" />
                                                                
                                                        <div class="row text-center">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="">
                                                            </div>
                                                                
                                                            <div class="form-group">
                                                                
                                                                <div class="wrapper">
                                                                   <label for="detail">{{ __('frontstaticword.AssignmentUpload') }}:<sup class="redstar">*</sup></label> 
                                                                  <div class="file-upload">
                                                                    <input type="file" name="assignment" class="form-control" />
                                                                    <i class="fa fa-arrow-up"></i>
                                                                  </div>
                                                                </div>
                                                            </div> 
                                                            
                                                          </div>
                                                          
                                                        </div>
                                                        
                                                        <hr>
                                                        <div class="box-footer text-center">
                                                         <button type="submit" class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
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
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-appoint" role="tabpanel" aria-labelledby="nav-appoint-tab">
                    <div class="container">
                         @if(Auth::user()->role == 'user')

                        <div class="appointment-main-block">
                            <h3>{{ __('frontstaticword.YourAppointment') }}</h3>
                          <div class="row">
                            
                            <div class="col-md-8">
                                @foreach($appointment as $appoint)
                                    <div class="col-md-12">
                                        <div class="assignment-tab-block">
                                            <div class="categories-block assign-tab-one text-center">
                                                <ul>
                                                    <li class="btm-5"><span>{{ $appoint->title }}</span></li>
                                                    <li class="btm-5"><span>{!! $appoint->detail !!}</span></li>
                                                    <li>
                                                   
                                                        <form  method="post" action="{{url('appointment/delete/'.$appoint->id)}}" ata-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart"> {{ __('frontstaticword.Delete') }}</button>
                                                      </form>

                                                    </li>
                                                    @if($appoint->accept == 1)
                                                    <li><a href="" data-toggle="modal" data-target="#myModalresponse" title="response">Response</a></li>

                                                    <div class="modal fade" id="myModalresponse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">

                                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Response') }}</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="box box-primary">
                                                              <div class="panel panel-sum">
                                                                <div class="modal-body">
                                                                  <div class="instructor-detail">
                                                                    <ul>
                                                                        <li>Your appointment was accepted</li>
                                                                        <li>
                                                                            Date : {{ $appoint->date }}
                                                                        </li>
                                                                        <li>
                                                                            {{ __('frontstaticword.Response') }}: {!! $appoint->reply !!}
                                                                        </li>

                                                                    </ul>
                                                                  </div>
                                                                
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div> 
                                                    </div>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <div class="contact-search-block btm-40">
                                    <div class="udemy-contact-btn text-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#appointmodel">{{ __('frontstaticword.RequestAppointment') }}
                                        </button>
                                    </div>
                                    <div class="modal fade" id="appointmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.RequestAppointment') }}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                              <div class="panel panel-sum">
                                                <div class="modal-body">
                                                    <form id="demo-form2" method="post" action="{{ route('appointment.request', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id"  value="{{ Auth::user()->id }}" />

                                                        <input type="hidden" name="instructor_id"  value="{{ $course->user_id }}" />
                                                        
                                                        
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.User') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" name="fname" value="{{ Auth::user()->email }}" class="form-control" disabled />
                                                            </div>
                                                          </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="">
                                                            </div>
                                                        </div>
                                                        </div>
                                                        
                                                       
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('frontstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea id="detail" name="detail" class="form-control" placeholder="Enter your details" value=""></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">Phone Number : <sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Please Enter Phone No." value="" required>
                                                            </div>
                                                          </div>

                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Date') }}:<sup class="redstar">*</sup></label>
                                                                <input type="month" class="form-control" id="date" name="date" placeholder="Please Enter Title" required>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        
                                                        <hr>
                                                        <div class="box-footer">
                                                         <button type="submit" class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
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
                        </div>
                        
                            @else
                       <div class="appointment-main-block">
                            <h3>{{ __('frontstaticword.YourAppointment') }}</h3>
                          <div class="row">
                            
                            <div class="col-md-8">
                                @foreach($appointment as $appoint)
                                    <div class="col-md-12">
                                        <div class="assignment-tab-block">
                                            <div class="categories-block assign-tab-one text-center">
                                                <ul>
                                                    <li class="btm-5"><span>{{ $appoint->title }}</span></li>
                                                    <li class="btm-5"><span>{!! $appoint->detail !!}</span></li>
                                                    <li>
                                                   
                                                        <form  method="post" action="{{url('appointment/delete/'.$appoint->id)}}" ata-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <button  type="submit" class="cart-remove-btn display-inline" title="Remove From cart"> {{ __('frontstaticword.Delete') }}</button>
                                                      </form>

                                                    </li>
                                                    @if($appoint->accept == 1)
                                                    <li><a href="" data-toggle="modal" data-target="#myModalresponse" title="response">Response</a></li>

                                                    <div class="modal fade" id="myModalresponse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">

                                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.Response') }}</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="box box-primary">
                                                              <div class="panel panel-sum">
                                                                <div class="modal-body">
                                                                  <div class="instructor-detail">
                                                                    <ul>
                                                                        <li>Your appointment was accepted</li>
                                                                        <li>
                                                                            Date : {{ $appoint->date }}
                                                                        </li>
                                                                        <li>
                                                                            {{ __('frontstaticword.Response') }}: {!! $appoint->reply !!}
                                                                        </li>

                                                                    </ul>
                                                                  </div>
                                                                
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div> 
                                                    </div>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <div class="contact-search-block btm-40">
                                    <div class="udemy-contact-btn text-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#appointmodel">{{ __('frontstaticword.RequestAppointment') }}
                                        </button>
                                    </div>
                                    <div class="modal fade" id="appointmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title" id="myModalLabel">{{ __('frontstaticword.RequestAppointment') }}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                              <div class="panel panel-sum">
                                                <div class="modal-body">
                                                    <form id="demo-form2" method="post" action="{{ route('appointment.request', $course->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id"  value="{{ Auth::user()->id }}" />

                                                        <input type="hidden" name="instructor_id"  value="{{ $course->user_id }}" />
                                                        
                                                        
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.User') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" name="fname" value="{{ Auth::user()->email }}" class="form-control" disabled />
                                                            </div>
                                                          </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Title') }}:<sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="Please Enter Title" value="">
                                                            </div>
                                                        </div>
                                                        </div>
                                                        
                                                       
                                                        <div class="row">
                                                          <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detail">{{ __('frontstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                                                                <textarea id="detail" name="detail" class="form-control" placeholder="Enter your details" value=""></textarea>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">Phone Number : <sup class="redstar">*</sup></label>
                                                                <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Please Enter Phone No." value="" required>
                                                            </div>
                                                          </div>

                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="title">{{ __('frontstaticword.Date') }}:<sup class="redstar">*</sup></label>
                                                                <input type="month" class="form-control" id="date" name="date" placeholder="Please Enter Title" required>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        
                                                        <hr>
                                                        <div class="box-footer">
                                                         <button type="submit" class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
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
                        </div>

                            @endif
                    </div>
                </div>
                
                <div class="tab-pane fade" id="nav-feedback" role="tabpanel" aria-labelledby="nav-feedback-tab">
                       <div class="review-block">
                            <div class="row">
                                <div class="col-lg-2">
                                    <h5 class="top-20">{{ __('frontstaticword.Reviews') }}</h5>
                                </div>
                                <div class="col-lg-10 col-12">
                                    <form id="demo-form2" method="post" action="{{route('coursecert.rating',$course->id)}}" data-parsley-validate class="form-horizontal form-label-left">
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
</section>
<!-- courses-content end -->



@endsection

@section('custom-script')
<!-- iframe script -->
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
    $(".iframe").colorbox({iframe:true, width:"100%", height:"100%"});
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


 
function gohome() {
  $(".iframe").colorbox.remove();
  alert('kjd');
}


</script>
<!-- script to remain on active tab -->
<script>
(function($) {
  "use strict";
      $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#nav-tab a[href="' + activeTab + '"]').tab('show');
        }
      });
})(jQuery);
</script>
<!-- link for another tab -->
<script>
(function($) {
  "use strict";
    $("#goTab4").click(function(){
        $("#nav-tab a:nth-child(4)").click();
        return false;
    });

    $("#goTab3").click(function(){
        $("#nav-tab a:nth-child(3)").click();
        return false;
    });
})(jQuery);    
</script>

<script type="text/javascript">
    $('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
});
</script>
<script>
 
 
function pdfvisicheck(id,chapter_id){
    //  console.log('trig');
     var class_id = id;
     $('#downchap'+class_id).css("color", "green");
     classprogress(id,chapter_id);
}    
function pdfvisiviewcheck(id,chapter_id){
    //  console.log('trig');
     var class_id = id;
     $('#pdfclassview'+class_id).css("color", "green");
     classprogress(id,chapter_id);
}   
  
function classprogress(id,chapter_id){
    var class_id = id;
var course_id = $('#course_id').val();
var chapter_id = chapter_id;
console.log(class_id);
console.log(chapter_id);

// $('#downchap'+class_id).click(function(){
//     console.log('trig');
//   $('#downchap'+class_id).css("color", "green");
// });

// $('#pdfclassview'+class_id).click(function(){ 
//       $('#pdfclassview'+class_id).css("color", "green");
       
// });

$.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });

$.ajax({
   
      type: "POST",
      url: '{{ url('/classprogress') }}',
      data:{class_id:class_id, course_id:course_id, chapter_id:chapter_id },
      success: function (data) {
     // console.log(data);
      
      },
      error: function (error) {
      console.log(error);
             }
     });


}
 
    
</script>

<script>
(function($) {
  "use strict";
    tinymce.init({selector:'textarea'});
})(jQuery);
</script>

@endsection


<style>
    .hidden {position:absolute;visibility:hidden;opacity:0;}
    input[type=checkbox] + label {
      color: #ccc;
      font-style: italic;
    } 
    input[type=checkbox]:checked + label {
      color: #f00;
      font-style: normal;
    }
   td.class-type.content.txt-rgt.pdfvisicheck a:visited {
     color: green;
   }

 td.class-type.content.txt-rgt.pdfvisiviewcheck a:visited {
     color: green;
   }
</style>
