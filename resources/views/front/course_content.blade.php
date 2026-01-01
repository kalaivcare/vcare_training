<?php
use App\CourseProgress; ?>
<!-- Add this to your HTML if missing -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
                                    {{-- @dd(count($progress->all_chapter_id)) --}}
                                    @if (!empty($progress) &&  is_array($progress->all_chapter_id) && count($progress->all_chapter_id) > 0 )
                                        <?php
                                        $total_class =
                                            $progress->all_chapter_id;
                                        $total_count = count($total_class);
                                        $total_per = 100;
                                        $read_class =
                                            $progress->mark_chapter_id;
                                        $read_count = count($read_class);
                                        $progres =
                                            ($read_count / $total_count) * 100;
                                        ?>
                                    @endif
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if (!empty($progress) &&  is_array($progress->all_chapter_id) && count($progress->all_chapter_id) > 0 )
                                            <a class="dropdown-item">
                                                {{ $read_count }} of {{ $total_count }} complete
                                            </a>
                                        @else
                                            <a class="dropdown-item">
                                                0 of
                                                @php
                                                    $data = App\CourseChapter::where('course_id', $course->id)->get();
                                                    if (count($data) > 0) {
                                                        echo count($data);
                                                    } else {
                                                        echo '0';
                                                    }
                                                @endphp
                                                complete
                                            </a>
                                        @endif

                                    </div>
                                </div>
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
                <div class="col-lg-5">
                    <img src="{{ asset('images/course/preview_two.png') }}" alt="homepage_preview">

                </div>
                <div class="col-lg-6">
                    <div class="learning-courses-home-block text-white">
                        <h3 class="learning-courses-home-heading btm-20"><a href="#"
                                title="heading">{{ $course->title }}</a></h3>
                        @php
                            // dd($course->short_detail);
                        @endphp

                        <div class="learning-courses btm-20">{{ $course->short_detail }}</div>
                        @if (!empty($progress) &&  is_array($progress->all_chapter_id) && count($progress->all_chapter_id) > 0 )
                            <?php
                            $total_class = $progress->all_chapter_id;
                            $total_count = count($total_class);

                            $total_per = 100;

                            $read_class = $progress->mark_chapter_id;
                            $read_count = count($read_class) - 1;

                            $progres = ($read_count / $total_count) * 100;
                            $progres = round($progres);
                            ?>
                            <div class="progress-block">
                                <div class="one histo-rate">
                                    <span class="bar-block" style="width: 100%">
                                        <span id="bar-one" style="width: <?php echo $progres; ?>%"
                                            class="bar bar-clr bar-radius progress-bar-striped">&nbsp;</span>
                                    </span>
                                </div>
                                <i class="fa fa-trophy lft-7"></i>
                            </div>
                        @else
                            <?php $progres = 0; ?>
                            <div class="progress-block">
                                <div class="one histo-rate">
                                    <span class="bar-block" style="width: 100%">
                                        <span id="bar-one" style="width: 0%" class="bar bar-clr bar-radius">&nbsp;</span>
                                    </span>
                                </div>
                                <i class="fa fa-trophy lft-7"></i>
                            </div>
                        @endif
                        @if (isset($items))
                            @if (isset($course->chapter[0]->courseclass[0]))
                                @if ($course->chapter[0]->courseclass[0]->iframe_url == null)
                                    <!--<div class="learning-courses-home-btn">-->
                                    <!--    <a href="{{ route('watchcourse', $course->id) }}" class="iframe btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>-->
                                    <!--</div>-->
                                @else
                                    <div class="learning-courses-home-btn">
                                        @php
                                            $url = Crypt::encrypt($course->chapter[0]->courseclass[0]->iframe_url);
                                        @endphp
                                        <!--<a href="{{ route('watchinframe', [$url, 'course_id' => $course->id]) }}" class="btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>-->
                                    </div>
                                @endif
                            @else
                                <!--<div class="learning-courses-home-btn">-->
                                <!--    <a href="{{ route('watchcourse', $course->id) }}" class="iframe btn btn-primary" title="Continue">{{ __('frontstaticword.ContinuetoLecture') }}</a>-->
                                <!--</div>-->
                            @endif
                        @endif
                        <div class="learning-courses-home-btn">
                            <button class="btn" style="background-color:#59b3d1;" title="Continue">Course progress -
                                {{ $progres }}%</button>
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
                    <div class="nav nav-tabs d-flex justify-content-between" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active text-center" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home"
                            aria-selected="true">{{ __('frontstaticword.Overview') }}</a>
                        <a class="nav-item nav-link text-center" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile"
                            aria-selected="false">{{ __('frontstaticword.CourseContent') }}</a>
                        <a class="nav-item nav-link text-center" id="nav-announcement-tab" data-toggle="tab"
                            href="#nav-announcement" role="tab" aria-controls="nav-announcement"
                            aria-selected="false">Assigment details</a>
                        <a class="nav-item nav-link text-center" id="nav-assign-tab" data-toggle="tab" href="#nav-assign"
                            role="tab" aria-controls="nav-assign"
                            aria-selected="false">{{ __('frontstaticword.Assignment') }}</a>
                        <a class="nav-item nav-link text-center" id="nav-feedback-tab" data-toggle="tab"
                            href="#nav-feedback" role="tab" aria-controls="nav-feedback"
                            aria-selected="false">Feedback</a>
                        <a class="nav-item nav-link text-center" id="nav-progress-tab" data-toggle="tab"
                            href="#nav-progress" role="tab" aria-controls="nav-progress"
                            aria-selected="false">Progress Entry</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade" id="nav-progress" role="tabpanel" aria-labelledby="nav-progress-tab">
                        {{-- progress entry --}}
                        <div class="container">
                            <h4 class="mb-4 mt-4">Daily Learning Progress Entry</h4>

                            {{-- Success & Error Messages --}}
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            {{-- Entry Form --}}
                            <form method="POST" action="{{ route('learning.store') }}" id="learningForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="learning_date" class="form-label">Select Date</label>
                                    <input type="date" name="learning_date" id="learning_date" class="form-control"
                                        max="{{ now()->toDateString() }}">
                                    <small id="learning_date_err" class="text-danger"></small>
                                </div>

                                <div class="mb-3">
                                    <label for="content_learn" class="form-label">What did you learn today?</label>
                                    <textarea name="content" id="content_learn" class="form-control" rows="6"></textarea>
                                    <small id="wordCount" class="text-muted">0 words</small><br>
                                    <small id="content_err" class="text-danger"></small>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                            <script>
                                const learningForm = document.getElementById('learningForm');

                                learningForm.addEventListener('submit', function(event) {
                                    const learning_date = document.getElementById('learning_date').value;
                                    const content_learn = document.getElementById('content_learn').value.trim();

                                    let valid = true;

                                    if (learning_date === '') {
                                        document.getElementById('learning_date_err').innerText = "Please select a date.";
                                        valid = false;
                                    } else {
                                        document.getElementById('learning_date_err').innerText = "";
                                    }

                                    const wordCount = content_learn.split(/\s+/).filter(Boolean).length;
                                    document.getElementById('wordCount').textContent = `${wordCount} words`;

                                    if (wordCount < 100) {
                                        document.getElementById('content_err').innerText = "Minimum 100 words required.";
                                        valid = false;
                                    } else {
                                        document.getElementById('content_err').innerText = "";
                                    }

                                    if (!valid) {
                                        event.preventDefault();
                                    }
                                });

                                document.getElementById('content_learn').addEventListener('input', function() {
                                    const wordCount = this.value.trim().split(/\s+/).filter(Boolean).length;
                                    document.getElementById('wordCount').textContent = `${wordCount} words`;
                                });

                                const editModal = document.getElementById('editModal');
                                const editForm = document.getElementById('editForm');

                                if (editModal) {
                                    editModal.addEventListener('show.bs.modal', function(event) {
                                        const button = event.relatedTarget;
                                        const entryId = button.getAttribute('data-id');
                                        const entryContent = button.getAttribute('data-content');
                                        const entryDate = button.getAttribute('data-date');

                                        editForm.action = `{{ url('learning/update') }}/${entryId}`;
                                        document.getElementById('edit_learning_date').value = entryDate;
                                        document.getElementById('edit_content').value = entryContent;
                                    });

                                    document.getElementById('edit_content').addEventListener('input', function() {
                                        const wordCount = this.value.trim().split(/\s+/).filter(Boolean).length;
                                        document.getElementById('editWordCount').textContent = `${wordCount} words`;
                                    });
                                }
                            </script>


                            <hr class="my-4">

                            {{-- Entries Table --}}
                            <h4>Your Previous Entries</h4>
                            <table class="table table-bordered mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Content</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($entries as $entry)
                                        <tr>
                                            <td>{{ $entry->learning_date }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($entry->content, 100) }}</td>
                                            <td>
                                                @if ($entry->learning_date == now()->toDateString())
                                                    <button class="btn  btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editModal" data-id="{{ $entry->id }}"
                                                        data-content="{{ $entry->content }}"
                                                        data-date="{{ $entry->learning_date }}"><i
                                                            class="fa fa-edit"></i></button>
                                                @else
                                                    <span class="badge bg-secondary">Locked</span>
                                                @endif
                                            </td>

                                        </tr>
                                        <div class="modal fade" id="editModal" tabindex="-1"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Learning Progress
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('learning.update', $entry->id) }}"
                                                            id="editForm">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="edit_learning_date" class="form-label">Select
                                                                    Date</label>
                                                                <input type="date" name="learning_date"
                                                                    class="form-control"
                                                                    value="{{ $entry->learning_date }}" readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="edit_content" class="form-label">What did you
                                                                    learn today?</label>
                                                                <textarea id="edit_content" name="content" class="form-control" rows="8" required>{{ $entry->content }}</textarea>
                                                                <small id="editWordCount" class="text-muted">0
                                                                    words</small>
                                                                <div id="editWordError" class="text-danger mt-1"></div>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary">Update
                                                                Entry</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No entries yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination Links --}}
                            <div class="d-flex justify-content-center">
                                {{ $entries->links() }}
                            </div>
                        </div>

                        {{-- Edit Entry Modal --}}


                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const textarea = document.getElementById('edit_content');
                                const wordCountDisplay = document.getElementById('editWordCount');
                                const errorDisplay = document.getElementById('editWordError');
                                const form = document.getElementById('editForm');
                                textarea.addEventListener('input', function() {
                                    const words = textarea.value.trim().split(/\s+/).filter(word => word.length > 0);
                                    wordCountDisplay.textContent = `${words.length} words`;
                                    if (words.length < 100) {
                                        wordCountDisplay.classList.add('text-danger');
                                    } else {
                                        wordCountDisplay.classList.remove('text-danger');
                                    }
                                });

                                form.addEventListener('submit', function(e) {
                                    const words = textarea.value.trim().split(/\s+/).filter(word => word.length > 0);
                                    if (words.length < 100) {
                                        e.preventDefault();
                                        errorDisplay.textContent = "❌ Please enter at least 100 words before submitting.";
                                    } else {
                                        errorDisplay.textContent = "";
                                    }
                                });
                            });
                        </script>


                    </div>

                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                        aria-labelledby="nav-home-tab">
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
                                                @if ($course->language_id == !null)
                                                    <li>{{ __('frontstaticword.Languages') }}:
                                                        {{ $course->language->name }}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3">
                                        <div class="content-course-number">
                                            <ul>
                                                <li> Modules :
                                                    @php
                                                        $data = App\CourseChapter::where(
                                                            'course_id',
                                                            $course->id,
                                                        )->get();
                                                        // @dd($data);
                                                        $module_progress = 0;
                                                        $totalclass = 0;
                                                        foreach ($data as $totalpage) {
                                                            $totalclass += $totalpage['size'];
                                                        }
                                                        if (count($data) > 0) {
                                                            echo count($data);
                                                        } else {
                                                            echo '0';
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
                                            <h5 class="content-course-number-heading">
                                                {{ __('frontstaticword.Aboutthiscourse') }}</h5>
                                            <p>{{ $course->short_detail }}
                                            <p>
                                            <h5 class="content-course-number-heading">
                                                {{ __('frontstaticword.Description') }}</h5>

                                            <p>{!! $course->detail !!}
                                            <p>
                                        </div>
                                    </div>
                                </div>
                                <hr>

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
                            if (!empty($progress) &&  is_array($progress->all_chapter_id) && count($progress->all_chapter_id) > 0 ) {
                                $balance = array_diff(
                                    $progress->all_chapter_id,
                                    $progress->mark_chapter_id
                                );
                                if ($balance != null) {
                                    $firstkey = array_key_first($balance);
                                    $check = $balance[$firstkey];
                                } else {
                                    $check = $chapter->id;
                                }
                            } else {
                                if (!empty($chapter->id)) {
                                    $check = $chapter->id;
                                }
                            } ?>
                            <div id="accordion" class="second-accordion">
                                <?php
                                $i = 0;
                                // dd($progress);
                                $completed = "Completed";
                                $notcompleted = "Not Completed";
                                $On_progress = "On Progress";
                                $failed = "Failed in this module";
                                $status_Array = json_decode(
                                    $progress->status,
                                    true
                                );
                                $hairbased = $coursechapters->where(
                                    "module_type",
                                    "Hair"
                                );
                                $skinbased = $coursechapters->where(
                                    "module_type",
                                    "Skin"
                                );
                                ?>
                                
                                @if($hairbased->isNotEmpty())
                                  <h3>Hair Modules</h3>
                                @endif
                                @foreach ($hairbased as $coursechapter)
                                    <?php $i++; ?>
                                    <div class="card btm-10">
                                        <div class="card-header" id="headingChapter{{ $coursechapter->id }}">
                                            <div class="mb-0">
                                                <button type="button" class="btn btn-link"
                                                    @if (
                                                        (isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id)) ||
                                                            (isset($status_Array) && in_array($coursechapter->id, $status_Array))) data-toggle="collapse" @endif
                                                    data-target="#collapseChapter{{ $coursechapter->id }}"
                                                    aria-expanded="true" aria-controls="collapseChapter">
                                                    <div class="course-check-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr
                                                                    class="@if (!isset($progress->mark_chapter_id) || !in_array($coursechapter->id, $progress->mark_chapter_id)) disabled-row @endif">

                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-6">
                                                                                <div class="section">
                                                                                    Module: <?php
                                                                                    echo $i;

                                                                                    $check_fail = App\UserTestAtempt::where(
                                                                                        "chapter_id",
                                                                                        $coursechapter->id
                                                                                    )
                                                                                        ->where(
                                                                                            "user_id",
                                                                                            Auth::user()
                                                                                                ->id
                                                                                        )
                                                                                        ->first();
                                            ?>
                                                                                    @php
                                                                                        $check_fail = App\UserTestAtempt::where(
                                                                                            'chapter_id',
                                                                                            $coursechapter->id,
                                                                                        )
                                                                                            ->where(
                                                                                                'user_id',
                                                                                                Auth::user()->id,
                                                                                            )
                                                                                            ->first();
                                                                                    @endphp

                                                                                    <span
                                                                                        id="module-status-{{ $coursechapter->id }}"
                                                                                        class="badge
                                                                                          @if(isset($status_Array) && in_array($coursechapter->id, $status_Array))
                                                                                              badge-warning
                                                                                          @elseif(isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id))
                                                                                              badge-success
                                                                                          @else
                                                                                              badge-danger @endif">

                                                                                        
                                                                                        @if(isset($status_Array) && in_array($coursechapter->id, $status_Array))
                                                                                            {{ $On_progress }}
                                                                                        @elseif(isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id))
                                                                                            {{ $completed }}
                                                                                        @else
                                                                                            {{ $notcompleted }}
                                                                                        @endif
                                                                                    </span>

                                                                                </div>

                                                                            </div>
                                                                            <div class="col-lg-6 col-6">
                                                                                <div class="section-dividation text-right">
                                                                                    @php
                                                                                        $classone = App\CourseClass::where(
                                                                                            'coursechapter_id',
                                                                                            $coursechapter->id,
                                                                                        )->get();
                                                                                        // dd( $classone);
                                                                                        if (count($classone) > 0) {
                                                                                            echo count($classone);
                                                                                        } else {
                                                                                            echo '0';
                                                                                        }
                                                                                    @endphp
                                                                                    Contents
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-9 col-">
                                                                                <div class="profile-heading">
                                                                                    {{ $coursechapter->chapter_name }}
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-lg-3 col-5">
                                                                                <div class="text-right">
                                                                                    @php
                                                                                        $topics = App\QuizTopic::where(
                                                                                            'course_id',
                                                                                            $course->id,
                                                                                        )
                                                                                            ->where(
                                                                                                'coursechapter_id',
                                                                                                $coursechapter->id,
                                                                                            )
                                                                                            ->orderby(
                                                                                                'coursechapter_id',
                                                                                            )
                                                                                            ->get();
                                                                                    @endphp

                                                                                    @if ($coursechapter->file != null)
                                                                                        <!--<a href="{{ asset('files/material/' . $coursechapter->file) }}" target="_blank"  title="Learning Material"><i class="fa fa-download"></i></a>-->
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
                                        <div id="collapseChapter{{ $coursechapter->id }}" class="collapse"
                                            aria-labelledby="headingChapter" data-parent="#accordion">
                                            @php
                                                $classes = App\CourseClass::where(
                                                    'coursechapter_id',
                                                    $coursechapter->id,
                                                )
                                                    ->orderBy('position', 'ASC')
                                                    ->get();
                                                $mytime = Carbon\Carbon::now();
                                                if (!empty($progress)) {
                                                    $comp = in_array($coursechapter->id, $progress->mark_chapter_id);
                                                } else {
                                                    $comp = $chapter->id;
                                                }
                                            @endphp

                                            @foreach ($classes as $class)
                                                <input type="hidden" value=" {{ $course->id }}" id="course_id">
                                                @php
                                                    $classprog = App\ClassProgress::where('user_id', Auth::user()->id)
                                                        ->where('chapter_id', $coursechapter->id)
                                                        ->where('class_id', $class->id)
                                                        ->first();
                                                    $size = App\CourseClass::where('course_id', $course->id)
                                                        ->where('coursechapter_id', $coursechapter->id)
                                                        ->where('id', $class->id)
                                                        ->first();
                                                        // dd($size);
                                                    if (isset($size['size']) && $size['size'] != null) {
                                                        $module_progress += ($size['size'] / $totalclass) * 100;
                                                    } else {
                                                        $module_progress += 0;
                                                    }

                                                @endphp
                                                <div class="card-body">
                                                    <table class="table" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="class-type content" style="width: 100%;">
                                                                    @if ($class->type == 'video' && $class->video)
                                                                        <a href="{{ route('watchcourseclass', $class->id) }}"
                                                                            id="completed" target="_blank" class="mt-3 p-4"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}' , this)"
                                                                             title="Course"
                                                                            @if (isset($classprog)) style="color:green" @endif
                                                                            class="iframe"><i
                                                                                @if (isset($classprog)) style="color:green" @endif
                                                                                class="fa fa-play-circle"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @php
                                                                        $url = Crypt::encrypt($class->iframe_url);
                                                                    @endphp
                                                                    @if ($class->type == 'video' && $class->iframe_url)
                                                                        <a href="{{ route('watchinframe', [$url, 'course_id' => $course->id]) }}"
                                                                            target="_blank" class="mt-3 p-4"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            title="Course"><i
                                                                                class="fa fa-play-circle"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'audio' && $class->audio)
                                                                        <a href="{{ route('audiocourseclass', $class->id) }}"
                                                                            title="class"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            class="iframe"><i
                                                                                class="fa fa-play-circle"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'image' && $class->image)
                                                                        <a href="{{ asset('images/class/' . $class->image) }}"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            download="{{ $class->image }}"
                                                                            title="Course"><i
                                                                                class="fas fa-image"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'pdf' && $class->pdf)
                                                                        <a href="{{ asset('files/pdf/' . $class->pdf) }}"
                                                                            id="iframe" target="_blank" class="mt-3 p-4"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}', this)"
                                                                            title="Course"><i
                                                                                @if (isset($classprog)) style="color:green" @endif
                                                                                class="fa fa-file"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'ppt' && $class->ppt)
                                                                        @php
                                                                            $fileUrl =
                                                                                'https://nihaws.s3.ap-south-1.amazonaws.com/ppt/' .
                                                                                $class->ppt;
                                                                            $src =
                                                                                'https://docs.google.com/viewer?url=' .
                                                                                urlencode($fileUrl) .
                                                                                '&embedded=true';
                                                                        @endphp

                                                                        <a href="{{ route('viewppt', ['url' => $fileUrl]) }}"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}',this)"
                                                                            target="_blank" title="View PPT" class="mt-3 p-4">
                                                                            <i @if (isset($classprog)) style="color:green" @endif
                                                                                class="fa fa-file-text"></i>
                                                                            {{ $class->title }}
                                                                        </a>
                                                                    @endif

                                                                    @if ($class->type == 'zip' && $class->zip)
                                                                        <a href="{{ asset('files/zip/' . $class->zip) }}"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            download="{{ $class->zip }}"
                                                                            title="Course"><i
                                                                                class="far fa-file-archive"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->url)
                                                                        @if ($class->type == 'video')
                                                                            @if ($mytime >= $class->date_time)
                                                                                <a href="{{ route('watchcourseclass', $class->id) }}"
                                                                                    target="_blank"
                                                                                    onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                    title="Course" class="iframe"><i
                                                                                        class="fa fa-play-circle"></i>&nbsp;
                                                                                    {{ $class->title }}</a>
                                                                            @else
                                                                                <a href="" target="_blank"
                                                                                    onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                    title="Course"><i
                                                                                        class="fa fa-play-circle"></i>&nbsp;
                                                                                    {{ $class->title }}</a>
                                                                            @endif
                                                                        @endif
                                                                        @if ($class->type == 'image')
                                                                            <a href="{{ $class->url }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                title="Course"><i
                                                                                    class="fas fa-image"></i>&nbsp;
                                                                                {{ $class->title }}</a>
                                                                        @endif
                                                                        @if ($class->type == 'pdf')
                                                                            <a href="{{ $class->url }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                @if (isset($classprog)) style="color:green" @endif
                                                                                target="_blank" title="Course"><i
                                                                                    class="fas fa-file-pdf"></i>&nbsp;
                                                                                {{ $class->title }}</a>
                                                                        @endif
                                                                        @if ($class->type == 'zip')
                                                                            <a href="{{ $class->url }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                title="Course"><i
                                                                                    class="far fa-file-archive">&nbsp;
                                                                                    {{ $class->title }}</i></a>
                                                                        @endif
                                                                        @if ($class->type == 'audio')
                                                                            <a href="{{ route('audiocourseclass', $class->id) }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                title="Course" class="iframe"><i
                                                                                    class="fa fa-play-circle">&nbsp;
                                                                                    {{ $class->title }}</i></a>
                                                                        @endif
                                                                    @endif
                                                                </td>



                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                           


                                            <div class="container">
                                                <div class="modal " id="modulefeedback{{ $coursechapter->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Feedback Form
                                                                </h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
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
                                                                                    <form id="demo-form10" method="post"
                                                                                        action="{{ route('module.rating', $course->id) }}"
                                                                                        data-parsley-validate
                                                                                        class="form-horizontal form-label-left">
                                                                                        {{ csrf_field() }}
                                                                                        <div class="review-table top-20">
                                                                                            <input type="hidden"
                                                                                                value="{{ $coursechapter->id }}"
                                                                                                name="chapter_id">
                                                                                            <div class="form-group">
                                                                                                <label for="title">1.
                                                                                                    Have you faced any
                                                                                                    difficulty in
                                                                                                    understanding the course
                                                                                                    content ?</label>
                                                                                                <textarea name="qn1" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">2. Do
                                                                                                    you require any
                                                                                                    additional support to
                                                                                                    understand the course
                                                                                                    content completely
                                                                                                    ?</label>
                                                                                                <textarea name="qn2" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">3. Do
                                                                                                    you think the assessment
                                                                                                    questions are relevant
                                                                                                    to the course content
                                                                                                    ?</label>
                                                                                                <textarea name="qn3" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">4.
                                                                                                    Have you completed
                                                                                                    reading and
                                                                                                    understanding the course
                                                                                                    content within the
                                                                                                    stipulated period
                                                                                                    ?</label>
                                                                                                <textarea name="qn4" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">5. Do
                                                                                                    you have any suggestions
                                                                                                    for the improvement of
                                                                                                    the course content
                                                                                                    ?</label>
                                                                                                <textarea name="qn5" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">6.
                                                                                                    Other remarks</label>
                                                                                                <textarea name="qn6" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div
                                                                                                class="review-rating-btn text-right">
                                                                                                <button type="submit"
                                                                                                    class="btn btn-success"
                                                                                                    title="Review">{{ __('frontstaticword.Submit') }}</button>
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
                                <!-- Assessments within Section -->
@php
use App\CourseChapter;
use App\CourseClass;
use App\ClassProgress;
use App\Quiz;
use App\UserTestAtempt;

$auth = Auth::user();
$courseId = $course->id;
$moduleType = 'Hair';

$allCompleted = false;
$questionCount = 0;
$remainingAttempts = 3;

$chapters = CourseChapter::where('course_id', $courseId)
    ->where('module_type', 'like', "%{$moduleType}%")
    ->pluck('id');

if ($chapters->isNotEmpty()) {
    $courseClassIds = CourseClass::whereIn('coursechapter_id', $chapters)
        ->pluck('id');
    $completedClassIds = ClassProgress::where('user_id', $auth->id)
        ->whereIn('class_id', $courseClassIds)
        ->pluck('class_id');
    $allCompleted = $courseClassIds->count() > 0 &&
                    $courseClassIds->diff($completedClassIds)->isEmpty();
    $questionCount = Quiz::whereHas('topic.chapter', function ($q) use ($courseId, $moduleType) {
        $q->where('course_id', $courseId)
          ->where('module_type', 'like', "%{$moduleType}%");
    })->count();
    $attemptRow = UserTestAtempt::where('user_id', $auth->id)
        ->where('course_id', $courseId)
        ->where('module_type', $moduleType)
        ->latest()
        ->first();

    $remainingAttempts = $attemptRow->attempts ?? 3;
    $retesthair = $attemptRow->retest_status ?? 0;
}
@endphp



@if($allCompleted && $chapter)
<div class="container">
    <div class="quiz-main-block">
        <div class="col-md-6 col-lg-4">
            <div class="topic-block">
                <div class="card blue-grey darken-1">
                    <div class="card-content dark-text">
                        <h3 class="d-flex justify-content-center">
                            Assessment
                        </h3>
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <ul class="topic-detail">
                                    <li>Per Question →</li>
                                    <li>Total Marks →</li>
                                    <li>Total Questions →</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-5">
                                <ul class="topic-detail">
                                    <li>1</li>
                                    <li>{{ $questionCount }}</li>
                                    <li>{{ $questionCount }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                     <div class="card-action text-center">
                     @if($retesthair == 1 || $remainingAttempts == 0)
                            
                            <a href="{{ route('start.quiz.show_report',['id' => $course->id, 'type' => 'Hair'])}}"
                               class="btn btn-success btn-block">
                                View Report
                            </a>
                            
                        @else
                        
                            <a href="{{ route('start_quiz', ['course' => $course->id, 'type' => 'Hair']) }}"
                                class="btn btn-primary btn-block text-white">
                                {{ $remainingAttempts == 3 ? 'Start Assessment' : 'Re-Take Assessment' }}
                                </a>
                            <small class="text-muted">Remaining Attempts: {{ $remainingAttempts }}</small>
                        @endif
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endif



                             @if($skinbased->isNotEmpty())
                                <h3>
                                    Skin Modules
                                </h3>
                              @endif
                                @foreach ($skinbased as $coursechapter)
                                    <?php $i++; ?>
                                    <div class="card btm-10">
                                        <div class="card-header" id="headingChapter{{ $coursechapter->id }}">
                                            <div class="mb-0">
                                                <button type="button" class="btn btn-link"
                                                    @if (
                                                        (isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id)) ||
                                                            (isset($status_Array) && in_array($coursechapter->id, $status_Array))) data-toggle="collapse" @endif
                                                    data-target="#collapseChapter{{ $coursechapter->id }}"
                                                    aria-expanded="true" aria-controls="collapseChapter">
                                                    <div class="course-check-table">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr
                                                                    class="@if (!isset($progress->mark_chapter_id) || !in_array($coursechapter->id, $progress->mark_chapter_id)) disabled-row @endif">

                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-6">
                                                                                <div class="section">
                                                                                    Module: <?php
                                                                                    echo $i;

                                                                                    $check_fail = App\UserTestAtempt::where(
                                                                                        "chapter_id",
                                                                                        $coursechapter->id
                                                                                    )
                                                                                        ->where(
                                                                                            "user_id",
                                                                                            Auth::user()
                                                                                                ->id
                                                                                        )
                                                                                        ->first();?>
                                                                                    @php
                                                                                        $check_fail = App\UserTestAtempt::where(
                                                                                            'chapter_id',
                                                                                            $coursechapter->id,
                                                                                        )
                                                                                            ->where(
                                                                                                'user_id',
                                                                                                Auth::user()->id,
                                                                                            )
                                                                                            ->first();
                                                                                    @endphp

                                                                                    <span
                                                                                        id="module-status-{{ $coursechapter->id }}"
                                                                                        class="badge
                                                                                          @if(isset($status_Array) && in_array($coursechapter->id, $status_Array))
                                                                                              badge-warning
                                                                                          @elseif(isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id))
                                                                                              badge-success
                                                                                          @else
                                                                                              badge-danger @endif">

                                                                                        @if(isset($status_Array) && in_array($coursechapter->id, $status_Array))
                                                                                            {{ $On_progress }}
                                                                                        @elseif(isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id))
                                                                                            {{ $completed }}
                                                                                        @else
                                                                                            {{ $notcompleted }}
                                                                                        @endif
                                                                                    </span>

                                                                                </div>

                                                                            </div>
                                                                            <div class="col-lg-6 col-6">
                                                                                <div class="section-dividation text-right">
                                                                                    @php
                                                                                        $classone = App\CourseClass::where(
                                                                                            'coursechapter_id',
                                                                                            $coursechapter->id,
                                                                                        )->get();
                                                                                        // dd( $classone);
                                                                                        if (count($classone) > 0) {
                                                                                            echo count($classone);
                                                                                        } else {
                                                                                            echo '0';
                                                                                        }
                                                                                    @endphp
                                                                                    Contents
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-9 col-">
                                                                                <div class="profile-heading">
                                                                                    {{ $coursechapter->chapter_name }}
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-lg-3 col-5">
                                                                                <div class="text-right">
                                                                                    @php
                                                                                        $topics = App\QuizTopic::where(
                                                                                            'course_id',
                                                                                            $course->id,
                                                                                        )
                                                                                            ->where(
                                                                                                'coursechapter_id',
                                                                                                $coursechapter->id,
                                                                                            )
                                                                                            ->orderby(
                                                                                                'coursechapter_id',
                                                                                            )
                                                                                            ->get();
                                                                                    @endphp

                                                                                    @if ($coursechapter->file != null)
                                                                                        <!--<a href="{{ asset('files/material/' . $coursechapter->file) }}" target="_blank"  title="Learning Material"><i class="fa fa-download"></i></a>-->
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
                                        <div id="collapseChapter{{ $coursechapter->id }}" class="collapse"
                                            aria-labelledby="headingChapter" data-parent="#accordion">
                                            @php
                                                $classes = App\CourseClass::where(
                                                    'coursechapter_id',
                                                    $coursechapter->id,
                                                )
                                                    ->orderBy('position', 'ASC')
                                                    ->get();
                                                $mytime = Carbon\Carbon::now();
                                                if (!empty($progress)) {
                                                    $comp = in_array($coursechapter->id, $progress->mark_chapter_id);
                                                } else {
                                                    $comp = $chapter->id;
                                                }
                                            @endphp

                                            @foreach ($classes as $class)
                                                <input type="hidden" value=" {{ $course->id }}" id="course_id">
                                                @php
                                                    $classprog = App\ClassProgress::where('user_id', Auth::user()->id)
                                                        ->where('chapter_id', $coursechapter->id)
                                                        ->where('class_id', $class->id)
                                                        ->first();
                                                    $size = App\CourseClass::where('course_id', $course->id)
                                                        ->where('coursechapter_id', $coursechapter->id)
                                                        ->where('id', $class->id)
                                                        ->first();
                                                    if ($size['size'] != null) {
                                                        $module_progress += ($size['size'] / $totalclass) * 100;
                                                    } else {
                                                        $module_progress += 0;
                                                    }

                                                @endphp
                                                <div class="card-body">
                                                    <table class="table" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="class-type content" style="width: 100%;">
                                                                    @if ($class->type == 'video' && $class->video)
                                                                        <a href="{{ route('watchcourseclass', $class->id) }}"
                                                                            id="completed" target="_blank" class="mt-3 p-4"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}' , this)"
                                                                            id="check" title="Course"
                                                                            @if (isset($classprog)) style="color:green" @endif
                                                                            class="iframe"><i
                                                                                @if (isset($classprog)) style="color:green" @endif
                                                                                class="fa fa-play-circle"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @php
                                                                        $url = Crypt::encrypt($class->iframe_url);
                                                                    @endphp
                                                                    @if ($class->type == 'video' && $class->iframe_url)
                                                                        <a href="{{ route('watchinframe', [$url, 'course_id' => $course->id]) }}"
                                                                            target="_blank" class="mt-3 p-4"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            title="Course"><i
                                                                                class="fa fa-play-circle"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'audio' && $class->audio)
                                                                        <a href="{{ route('audiocourseclass', $class->id) }}"
                                                                            title="class"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            class="iframe"><i
                                                                                class="fa fa-play-circle"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'image' && $class->image)
                                                                        <a href="{{ asset('images/class/' . $class->image) }}"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            download="{{ $class->image }}"
                                                                            title="Course"><i
                                                                                class="fas fa-image"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'pdf' && $class->pdf)
                                                                        <a href="{{ asset('files/pdf/' . $class->pdf) }}"
                                                                            id="iframe" target="_blank" class="mt-3 p-4"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}', this)"
                                                                            title="Course"><i
                                                                                @if (isset($classprog)) style="color:green" @endif
                                                                                class="fa fa-file"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->type == 'ppt' && $class->ppt)
                                                                        @php
                                                                            $fileUrl =
                                                                                'https://nihaws.s3.ap-south-1.amazonaws.com/ppt/' .
                                                                                $class->ppt;
                                                                            $src =
                                                                                'https://docs.google.com/viewer?url=' .
                                                                                urlencode($fileUrl) .
                                                                                '&embedded=true';
                                                                        @endphp

                                                                        <a href="{{ route('viewppt', ['url' => $fileUrl]) }}"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}',this)"
                                                                            target="_blank" title="View PPT" class="mt-3 p-4">
                                                                            <i @if (isset($classprog)) style="color:green" @endif
                                                                                class="fa fa-file-text"></i>
                                                                            {{ $class->title }}
                                                                        </a>
                                                                    @endif

                                                                    @if ($class->type == 'zip' && $class->zip)
                                                                        <a href="{{ asset('files/zip/' . $class->zip) }}"
                                                                            onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                            download="{{ $class->zip }}"
                                                                            title="Course"><i
                                                                                class="far fa-file-archive"></i>&nbsp;
                                                                            {{ $class->title }}</a>
                                                                    @endif
                                                                    @if ($class->url)
                                                                        @if ($class->type == 'video')
                                                                            @if ($mytime >= $class->date_time)
                                                                                <a href="{{ route('watchcourseclass', $class->id) }}"
                                                                                    target="_blank"
                                                                                    onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                    title="Course" class="iframe"><i
                                                                                        class="fa fa-play-circle"></i>&nbsp;
                                                                                    {{ $class->title }}</a>
                                                                            @else
                                                                                <a href="" target="_blank"
                                                                                    onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                    title="Course"><i
                                                                                        class="fa fa-play-circle"></i>&nbsp;
                                                                                    {{ $class->title }}</a>
                                                                            @endif
                                                                        @endif
                                                                        @if ($class->type == 'image')
                                                                            <a href="{{ $class->url }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                title="Course"><i
                                                                                    class="fas fa-image"></i>&nbsp;
                                                                                {{ $class->title }}</a>
                                                                        @endif
                                                                        @if ($class->type == 'pdf')
                                                                            <a href="{{ $class->url }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                @if (isset($classprog)) style="color:green" @endif
                                                                                target="_blank" title="Course"><i
                                                                                    class="fas fa-file-pdf"></i>&nbsp;
                                                                                {{ $class->title }}</a>
                                                                        @endif
                                                                        @if ($class->type == 'zip')
                                                                            <a href="{{ $class->url }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                title="Course"><i
                                                                                    class="far fa-file-archive">&nbsp;
                                                                                    {{ $class->title }}</i></a>
                                                                        @endif
                                                                        @if ($class->type == 'audio')
                                                                            <a href="{{ route('audiocourseclass', $class->id) }}"
                                                                                onclick="classprogress('{{ $class->id }}', '{{ $coursechapter->id }}')"
                                                                                title="Course" class="iframe"><i
                                                                                    class="fa fa-play-circle">&nbsp;
                                                                                    {{ $class->title }}</i></a>
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
                                                <div class="modal " id="modulefeedback{{ $coursechapter->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Feedback Form
                                                                </h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
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
                                                                                    <form id="demo-form10" method="post"
                                                                                        action="{{ route('module.rating', $course->id) }}"
                                                                                        data-parsley-validate
                                                                                        class="form-horizontal form-label-left">
                                                                                        {{ csrf_field() }}
                                                                                        <div class="review-table top-20">
                                                                                            <input type="hidden"
                                                                                                value="{{ $coursechapter->id }}"
                                                                                                name="chapter_id">
                                                                                            <div class="form-group">
                                                                                                <label for="title">1.
                                                                                                    Have you faced any
                                                                                                    difficulty in
                                                                                                    understanding the course
                                                                                                    content ?</label>
                                                                                                <textarea name="qn1" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">2. Do
                                                                                                    you require any
                                                                                                    additional support to
                                                                                                    understand the course
                                                                                                    content completely
                                                                                                    ?</label>
                                                                                                <textarea name="qn2" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">3. Do
                                                                                                    you think the assessment
                                                                                                    questions are relevant
                                                                                                    to the course content
                                                                                                    ?</label>
                                                                                                <textarea name="qn3" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">4.
                                                                                                    Have you completed
                                                                                                    reading and
                                                                                                    understanding the course
                                                                                                    content within the
                                                                                                    stipulated period
                                                                                                    ?</label>
                                                                                                <textarea name="qn4" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">5. Do
                                                                                                    you have any suggestions
                                                                                                    for the improvement of
                                                                                                    the course content
                                                                                                    ?</label>
                                                                                                <textarea name="qn5" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="title">6.
                                                                                                    Other remarks</label>
                                                                                                <textarea name="qn6" rows="1" class="form-control" placeholder=""></textarea>
                                                                                            </div>
                                                                                            <div
                                                                                                class="review-rating-btn text-right">
                                                                                                <button type="submit"
                                                                                                    class="btn btn-success"
                                                                                                    title="Review">{{ __('frontstaticword.Submit') }}</button>
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
                                 <!-- Assessments within Section -->
      @php

$auth = Auth::user();
$courseId   = $course->id;
$moduleType = 'Skin';

$allCompleted = false;
$skinQuestionCount = 0;
$remainingAttempts = 3;
$retestStatus = 0;

$skinChapterIds = CourseChapter::where('course_id', $courseId)
    ->where('module_type', 'like', "%{$moduleType}%")
    ->pluck('id');
    
if ($skinChapterIds->isNotEmpty()) {
    $skinClassIds = CourseClass::whereIn('coursechapter_id', $skinChapterIds)->pluck('id');

    $completedClassIds = ClassProgress::where('user_id', $auth->id)
        ->whereIn('class_id', $skinClassIds)
        ->pluck('class_id');

    $allCompleted = $skinClassIds->count() > 0 &&
                    $skinClassIds->diff($completedClassIds)->isEmpty();

    $skinQuestionCount = Quiz::whereHas('topic.chapter', function ($q) use ($courseId, $moduleType) {
        $q->where('course_id', $courseId)
          ->where('module_type', 'like', "%{$moduleType}%");
    })->count();

    $attemptRow = UserTestAtempt::where('user_id', $auth->id)
        ->where('course_id', $courseId)
        ->where('module_type', strtolower($moduleType))
        ->latest()
        ->first();

    $remainingAttempts = $attemptRow->attempts ?? 3;
    $retestStatus = $attemptRow->retest_status ?? 0;
}
@endphp

@if($allCompleted)
<div class="container">
    <div class="quiz-main-block">
        <div class="col-md-6 col-lg-4">
            <div class="topic-block" id="assessment_1">
                <div class="card blue-grey darken-1">
                    <div class="card-content dark-text">
                        <h3 class="d-flex justify-content-center">
                            Assessment
                        </h3>
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <ul class="topic-detail">
                                    <li>{{ __('frontstaticword.PerQuestionMark') }} <i class="fa fa-long-arrow-right"></i></li>
                                    <li>{{ __('frontstaticword.TotalMarks') }} <i class="fa fa-long-arrow-right"></i></li>
                                    <li>{{ __('frontstaticword.TotalQuestions') }} <i class="fa fa-long-arrow-right"></i></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-5">
                                <ul class="topic-detail">
                                    <li>1</li>
                                    <li>{{ $skinQuestionCount }}</li>
                                    <li>{{ $skinQuestionCount }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-action text-center">

                        @if($retestStatus == 1 || $remainingAttempts == 0)
                            {{-- Show View Report --}}
                            <a href="{{ route('start.quiz.show_report',['id' => $course->id, 'type' => 'Skin'])}}"
                               class="btn btn-success btn-block">
                                View Report
                            </a>
                            {{-- <small class="text-danger">Maximum attempts reached or Retest locked</small> --}}
                        @else
                            {{-- Start / Re-Take Assessment --}}
                            {{-- <a href="{{ route('start_quiz', ['course' => $courseId, 'type' => $moduleType]) }}"
                               class="btn btn-primary btn-block text-white">
                                {{ $remainingAttempts == 3 ? 'Start Assessment' : 'Re-Take Assessment' }}
                            </a> --}}
                            <a href="{{ route('start_quiz', ['course' => $courseId, 'type' => $moduleType]) }}"
                                        class="btn btn-primary btn-block text-white">
                                        {{ $remainingAttempts == 3 ? 'Start Assessment' : 'Re-Take Assessment' }}
                                        </a>
                            <small class="text-muted">Remaining Attempts: {{ $remainingAttempts }}</small>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


                            </div>
                            @php
                                $progress = App\CourseProgress::where('course_id', '=', $course->id)->where('user_id', Auth::User()->id)->first();
                                // var_dump("progress",$progress->count());
                                $course_completions = App\CourseCompletion::where('user_id', Auth::User()->id)->where('course_id',  $course->id)->count();
                                // var_dump("course_completions",$course_completions);
                                
                               $images = App\Image::where('course_id', $course->id)->where('user_id', Auth::user()->id)->count();

                               $chap_count = App\CourseChapter::where('course_id', $course->id)->count();
                                // var_dump("chap_count",$chap_count);
                               

                            @endphp
                            <div class="row card grid @if (count($progress->all_chapter_id) != count($progress->mark_chapter_id) - 1 || $course_completions != 0) d-none @endif"id="course_completed">
                              
                                    <div class="test" >

                                        <div class="text-center mt-4">
                                            <h4>Tick each topic to confirm that you have completed it.</h4>
                                        </div>
                                        <form method="POST" action="{{ route('course.completed.store') }}" id="formcourse"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="course_id" value={{ $course->id}}>

                                            @csrf
                                            <div class="row g-3 align-items-center p-4" id="course_completed1">
                                                <div id="courseErrors" class="text-danger" style="display:none;"></div>
                                                @php
                                                    $course_classes = App\CourseClass::where('course_id',$course->id)->get();
                                                @endphp
                                                @foreach ($course_classes as $course_class)
                                                    <div class="col-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="completed_courses[]" value="{{ $course_class->id }}"
                                                                id="exampleCheck{{ $course_class->id }}">
                                                            <label class="form-check-label"
                                                                for="exampleCheck{{ $course_class->id }}">
                                                                {{ $course_class->title }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div> <!-- End of row for checkboxes -->



                                            <!-- Image Upload Section -->
                                            <div id="course_completed2">
                                                <h5>Provide your e-signature to confirm the completion of all topics.</h5>
                                            </div>

                                            <!-- E-Signature Text Input -->
                                            <div class="row">
                                                <div class="col-6 p-4" id="course_completed3">
                                                    <input class="form-control" type="text" name="e_signature"
                                                        id="e_signature" placeholder="Type your e-signature">
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <div id="imageError" class="text-danger" style="display:none;"></div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                        </form>

                                            <script>
                                                const form = document.getElementById('formcourse');
                                                const checkboxes = document.querySelectorAll('input[name="completed_courses[]"]');
                                                const e_signature = document.getElementById('e_signature');

                                                form.addEventListener('submit', function(e) {
                                                    let atLeastOneChecked = false;
                                                    let errorMessages = [];

                                                    document.getElementById('courseErrors').style.display = 'none';
                                                    document.getElementById('imageError').style.display = 'none';

                                                    checkboxes.forEach(cb => {
                                                        if (cb.checked) atLeastOneChecked = true;
                                                    });

                                                    if (!atLeastOneChecked) {
                                                        errorMessages.push('Please mark at least one topic as completed.');
                                                    }

                                                    if (!e_signature.value.trim()) {
                                                        errorMessages.push('Please provide your e-signature before submitting.');
                                                    }

                                                    if (errorMessages.length > 0) {
                                                        e.preventDefault();
                                                        document.getElementById('courseErrors').innerText = errorMessages.join('\n');
                                                        document.getElementById('courseErrors').style.display = 'block';

                                                        document.getElementById('imageError').innerText = errorMessages.join('\n');
                                                        document.getElementById('imageError').style.display = 'block';
                                                        return false;
                                                    }

                                                    e.preventDefault();
                                                    const formData = new FormData(form);

                                                    fetch("{{ route('course.completed.store') }}", {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                document.getElementById('course_completed').style.display = 'none';
                                                                console.log('Form submitted successfully!');
                                                            } else {
                                                                alert('Something went wrong, please try again.');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            alert('Error submitting form: ' + error);
                                                        });
                                                });
                                            </script>
                                    </div>
                              
                                

                               




                            </div>



                            <div class="mark-read-button">
                            </div>
                            <!--</form>-->

                        </div>
                        @if (!empty($progress) &&  is_array($progress->all_chapter_id) && count($progress->all_chapter_id) > 0 )
                            @if ($read_count == $total_count)
                                @php
                                    $review = App\ReviewRating::where('user_id', Auth::User()->id)
                                        ->where('course_id', $course->id)
                                        ->first();
                                @endphp
                                @if (isset($review))
                                    {{-- <a href="{{route('cirtificate.download',$course->id)}}" target="_blank"  class="btn cert_down btm-20">Download Certificate</a> --}}
                                @else
                                    {{-- <button type="submit" data-toggle="modal" data-target="#downloadCertificate" class="btn cert_down btm-20">Download Certificate</button> --}}
                                    <div class="modal fade" id="downloadCertificate" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Feedback Form</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="box box-primary">
                                                    <div class="panel panel-sum">
                                                        <div class="modal-body">
                                                            <div class="review-block">
                                                                <div class="row">
                                                                    <div class="col-lg-2">
                                                                        <h5 class="top-20">
                                                                            {{ __('frontstaticword.Reviews') }}</h5>
                                                                    </div>
                                                                    <div class="col-lg-10 col-12">
                                                                        <form id="demo-form2" method="post"
                                                                            action="{{ route('coursecert.rating', $course->id) }}"
                                                                            data-parsley-validate
                                                                            class="form-horizontal form-label-left">
                                                                            {{ csrf_field() }}
                                                                            <div class="review-table top-20">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th scope="col"></th>
                                                                                            <th scope="col">1
                                                                                                {{ __('frontstaticword.Star') }}
                                                                                            </th>
                                                                                            <th scope="col">2
                                                                                                {{ __('frontstaticword.Star') }}
                                                                                            </th>
                                                                                            <th scope="col">3
                                                                                                {{ __('frontstaticword.Star') }}
                                                                                            </th>
                                                                                            <th scope="col">4
                                                                                                {{ __('frontstaticword.Star') }}
                                                                                            </th>
                                                                                            <th scope="col">5
                                                                                                {{ __('frontstaticword.Star') }}
                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">
                                                                                                Accessibility</th>
                                                                                            <td><input type="radio"
                                                                                                    name="learn"
                                                                                                    value="1"
                                                                                                    id="option1"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="learn"
                                                                                                    value="2"
                                                                                                    id="option2"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="learn"
                                                                                                    value="3"
                                                                                                    id="option3"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="learn"
                                                                                                    value="4"
                                                                                                    id="option4"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="learn"
                                                                                                    value="5"
                                                                                                    id="option5"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Quality</th>
                                                                                            <td><input type="radio"
                                                                                                    name="price"
                                                                                                    value="1"
                                                                                                    id="option6"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="price"
                                                                                                    value="2"
                                                                                                    id="option7"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="price"
                                                                                                    value="3"
                                                                                                    id="option8"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="price"
                                                                                                    value="4"
                                                                                                    id="option9"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="price"
                                                                                                    value="5"
                                                                                                    id="option10"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Support</th>
                                                                                            <td><input type="radio"
                                                                                                    name="value"
                                                                                                    value="1"
                                                                                                    id="option11"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="value"
                                                                                                    value="2"
                                                                                                    id="option12"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="value"
                                                                                                    value="3"
                                                                                                    id="option13"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="value"
                                                                                                    value="4"
                                                                                                    id="option14"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                            <td><input type="radio"
                                                                                                    name="value"
                                                                                                    value="5"
                                                                                                    id="option15"
                                                                                                    autocomplete="off">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <div class="review-text btm-30">
                                                                                    <label
                                                                                        for="review">{{ __('frontstaticword.Writereview') }}:</label>
                                                                                    <textarea name="review" rows="4" class="form-control" placeholder=""></textarea>
                                                                                </div>
                                                                                <div class="review-rating-btn text-right">
                                                                                    <button type="submit"
                                                                                        class="btn btn-success"
                                                                                        title="Review">{{ __('frontstaticword.Submit') }}</button>
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
                                $orders = App\Order::where('user_id', Auth::user()->id)
                                    ->where('course_id', $course->id)
                                    ->first();
                            @endphp
                            <div class="row">
                                @if (Auth::user()->role == 'user')
                                    <div class="col-lg-12">
                                        <div class="contact-search-block btm-40">
                                            <div class="learning-contact-search">
                                                @if ($coursequestions->isEmpty())
                                                    <h4 class="question-text">{{ __('frontstaticword.No') }}
                                                        {{ __('frontstaticword.RecentQuestions') }}</h4>
                                                @else
                                                    <h4 class="question-text">
                                                        @php
                                                            $quess = App\Question::where(
                                                                'course_id',
                                                                $course->id,
                                                            )->get();
                                                            if (count($quess) > 0) {
                                                                echo count($quess);
                                                            } else {
                                                                echo '0';
                                                            }
                                                        @endphp
                                                        {{ __('frontstaticword.questionsinthiscourse') }}
                                                    </h4>
                                                @endif
                                            </div>
                                            <div class="learning-contact-btn">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal">{{ __('frontstaticword.Askanewquestion') }}
                                                </button>
                                                <!--Model start-->
                                                <div id="myModal" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    {{ __('frontstaticword.Askanewquestion') }}</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="demo-form2" method="post"
                                                                    action="{{ url('addquestion', $course->id) }}"
                                                                    data-parsley-validate
                                                                    class="form-horizontal form-label-left">
                                                                    {{ csrf_field() }}
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="hidden" name="instructor_id"
                                                                                class="form-control"
                                                                                value="{{ $course->user_id }}" />
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ Auth::user()->id }}" />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input type="hidden" name="course_id"
                                                                                value="{{ $course->id }}" />
                                                                            <input type="hidden" name="status"
                                                                                value="1" />
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label
                                                                                for="detail">{{ __('frontstaticword.Question') }}:<sup
                                                                                    class="redstar">*</sup></label>
                                                                            <textarea name="question" rows="4" class="form-control" placeholder=""></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="box-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">{{ __('frontstaticword.Close') }}</button>
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
                                            @foreach ($questions as $ques)
                                                @if ($ques->status == 1)
                                                    <div class="card btm-10">
                                                        <div class="card-header" id="headingThree{{ $ques->id }}">
                                                            <div class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse"
                                                                    data-target="#collapseThree{{ $ques->id }}"
                                                                    aria-expanded="true" aria-controls="collapseThree">
                                                                    <div class="learning-questions-img rgt-10">
                                                                    </div>
                                                                    <div class="row no-gutters">
                                                                        <div class="col-lg-6 col-8">
                                                                            <div class="section">
                                                                                <a href="#"
                                                                                    title="questions">{{ $ques->user->fname }}
                                                                                </a>
                                                                                <a href="#"
                                                                                    title="questions">{{ date('jS F Y', strtotime($ques->created_at)) }}</a>
                                                                                <div class="author-tag">
                                                                                    {{ $ques->user->role }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-3">
                                                                            <div class="section-dividation text-right">
                                                                                @php
                                                                                    $answer = App\Answer::where(
                                                                                        'question_id',
                                                                                        $ques->id,
                                                                                    )->get();
                                                                                    if (count($answer) > 0) {
                                                                                        echo count($answer);
                                                                                    } else {
                                                                                        echo '0';
                                                                                    }
                                                                                @endphp
                                                                                {{ __('frontstaticword.Answer') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col-1">
                                                                            <div class="question-report txt-rgt">
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#myModalquesReport{{ $ques->id }}"
                                                                                    title="response"><i class="fa fa-flag"
                                                                                        aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row no-gutters">
                                                                        <div class="col-lg-8 col-8">
                                                                            <div
                                                                                class="profile-heading profile-heading-two">
                                                                                {{ $ques->question }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-3">
                                                                            <div class="profile-heading txt-rgt"><a
                                                                                    href="#" data-toggle="modal"
                                                                                    data-target="#myModalanswer{{ $ques->id }}"
                                                                                    title="response">{{ __('frontstaticword.AddAnswer') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!--Model start-->
                                                        <div class="modal fade" id="myModalanswer{{ $ques->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">
                                                                            {{ __('frontstaticword.Answer') }}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="box box-primary">
                                                                        <div class="panel panel-sum">
                                                                            <div class="modal-body">
                                                                                <form id="demo-form2" method="post"
                                                                                    action="{{ url('addanswer', $ques->id) }}"
                                                                                    data-parsley-validate
                                                                                    class="form-horizontal form-label-left">
                                                                                    {{ csrf_field() }}
                                                                                    <input type="hidden"
                                                                                        name="question_id"
                                                                                        value="{{ $ques->id }}" />
                                                                                    <input type="hidden"
                                                                                        name="instructor_id"
                                                                                        value="{{ $course->user_id }}" />
                                                                                    <input type="hidden"
                                                                                        name="ans_user_id"
                                                                                        value="{{ Auth::user()->id }}" />
                                                                                    <input type="hidden"
                                                                                        name="ques_user_id"
                                                                                        value="{{ $ques->user_id }}" />
                                                                                    <input type="hidden" name="course_id"
                                                                                        value="{{ $ques->course_id }}" />
                                                                                    <input type="hidden"
                                                                                        name="question_id"
                                                                                        value="{{ $ques->id }}" />
                                                                                    <input type="hidden" name="status"
                                                                                        value="1" />
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            {{ $ques->question }}
                                                                                            <br>
                                                                                            <br>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <label
                                                                                                for="detail">{{ __('frontstaticword.Answer') }}:<sup
                                                                                                    class="redstar">*</sup></label>
                                                                                            <textarea name="answer" rows="4" class="form-control" placeholder=""></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="box-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
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
                                                        <div class="modal fade"
                                                            id="myModalquesReport{{ $ques->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">
                                                                            {{ __('frontstaticword.Report') }} Question
                                                                        </h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="box box-primary">
                                                                        <div class="panel panel-sum">
                                                                            <div class="modal-body">
                                                                                <form id="demo-form2" method="post"
                                                                                    action="{{ route('question.report', $ques->id) }}"
                                                                                    data-parsley-validate
                                                                                    class="form-horizontal form-label-left">
                                                                                    {{ csrf_field() }}
                                                                                    <input type="hidden" name="course_id"
                                                                                        value="{{ $course->id }}" />
                                                                                    <input type="hidden"
                                                                                        name="question_id"
                                                                                        value="{{ $ques->id }}" />
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="title">{{ __('frontstaticword.Title') }}:<sup
                                                                                                        class="redstar">*</sup></label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    name="title"
                                                                                                    id="title"
                                                                                                    placeholder="Please Enter Title"
                                                                                                    value=""
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="email">{{ __('frontstaticword.Email') }}:<sup
                                                                                                        class="redstar">*</sup></label>
                                                                                                <input type="email"
                                                                                                    class="form-control"
                                                                                                    name="email"
                                                                                                    id="title"
                                                                                                    placeholder="Please Enter Email"
                                                                                                    value="{{ Auth::user()->email }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="detail">{{ __('frontstaticword.Detail') }}:<sup
                                                                                                        class="redstar">*</sup></label>
                                                                                                <textarea name="detail" rows="4" class="form-control" placeholder="Enter Detail" required></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="box-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--Model close -->
                                                        <div id="collapseThree{{ $ques->id }}" class="collapse"
                                                            aria-labelledby="headingThree" data-parent="#accordion">
                                                            @php
                                                                $answers = App\Answer::where(
                                                                    'question_id',
                                                                    $ques->id,
                                                                )->get();
                                                            @endphp
                                                            @foreach ($answers as $ans)
                                                                @if ($ans->status == 1)
                                                                    <div class="card-body">
                                                                        <div class="answer-block">
                                                                            <div class="row no-gutters">
                                                                                <div class="col-lg-1 col-2">
                                                                                    <div
                                                                                        class="learning-questions-img-two">
                                                                                        {{ $ans->user->fname[0] }}{{ $ans->user->lname[0] }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-11 col-10">
                                                                                    <div class="section">
                                                                                        <a href="#"
                                                                                            title="questions">{{ $ans->user->fname }}</a>
                                                                                        <a href="#"
                                                                                            title="questions">{{ date('jS F Y', strtotime($ans->created_at)) }}</a>
                                                                                        <div class="author-tag">
                                                                                            {{ $ans->user->role }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="section-answer">
                                                                                        <a href="#"
                                                                                            title="Course">{{ $ans->answer }}</a>
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
                                                @if ($coursequestions->isEmpty())
                                                    <h4 class="question-text">{{ __('frontstaticword.No') }}
                                                        {{ __('frontstaticword.RecentQuestions') }}</h4>
                                                @else
                                                    <h4 class="question-text">
                                                        @php
                                                            $quess = App\Question::where(
                                                                'course_id',
                                                                $course->id,
                                                            )->get();
                                                            if (count($quess) > 0) {
                                                                echo count($quess);
                                                            } else {
                                                                echo '0';
                                                            }
                                                        @endphp
                                                        {{ __('frontstaticword.questionsinthiscourse') }}
                                                    </h4>
                                                @endif
                                            </div>
                                            <div class="learning-contact-btn">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal">{{ __('frontstaticword.Askanewquestion') }}
                                                </button>
                                                <!--Model start-->
                                                <div id="myModal" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    {{ __('frontstaticword.Askanewquestion') }}</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="demo-form2" method="post"
                                                                    action="{{ url('addquestion', $course->id) }}"
                                                                    data-parsley-validate
                                                                    class="form-horizontal form-label-left">
                                                                    {{ csrf_field() }}
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="hidden" name="instructor_id"
                                                                                class="form-control"
                                                                                value="{{ $course->user_id }}" />
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ Auth::user()->id }}" />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input type="hidden" name="course_id"
                                                                                value="{{ $course->id }}" />
                                                                            <input type="hidden" name="status"
                                                                                value="1" />
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label
                                                                                for="detail">{{ __('frontstaticword.Question') }}:<sup
                                                                                    class="redstar">*</sup></label>
                                                                            <textarea name="question" rows="4" class="form-control" placeholder=""></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="box-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">{{ __('frontstaticword.Close') }}</button>
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
                                            @foreach ($questions as $ques)
                                                @if ($ques->status == 1)
                                                    <div class="card btm-10">
                                                        <div class="card-header" id="headingThree{{ $ques->id }}">
                                                            <div class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse"
                                                                    data-target="#collapseThree{{ $ques->id }}"
                                                                    aria-expanded="true" aria-controls="collapseThree">
                                                                    <div class="learning-questions-img rgt-10">
                                                                        {{ $ques->user->fname[0] }}{{ $ques->user->lname[0] }}
                                                                    </div>
                                                                    <div class="row no-gutters">
                                                                        <div class="col-lg-6 col-8">
                                                                            <div class="section">
                                                                                <a href="#"
                                                                                    title="questions">{{ $ques->user->fname }}
                                                                                </a>
                                                                                <a href="#"
                                                                                    title="questions">{{ date('jS F Y', strtotime($ques->created_at)) }}</a>
                                                                                <div class="author-tag">
                                                                                    {{ $ques->user->role }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-3">
                                                                            <div class="section-dividation text-right">
                                                                                @php
                                                                                    $answer = App\Answer::where(
                                                                                        'question_id',
                                                                                        $ques->id,
                                                                                    )->get();
                                                                                    if (count($answer) > 0) {
                                                                                        echo count($answer);
                                                                                    } else {
                                                                                        echo '0';
                                                                                    }
                                                                                @endphp
                                                                                {{ __('frontstaticword.Answer') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col-1">
                                                                            <div class="question-report txt-rgt">
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#myModalquesReport{{ $ques->id }}"
                                                                                    title="response"><i class="fa fa-flag"
                                                                                        aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row no-gutters">
                                                                        <div class="col-lg-8 col-8">
                                                                            <div
                                                                                class="profile-heading profile-heading-two">
                                                                                {{ $ques->question }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-3">
                                                                            <div class="profile-heading txt-rgt"><a
                                                                                    href="#" data-toggle="modal"
                                                                                    data-target="#myModalanswer{{ $ques->id }}"
                                                                                    title="response">{{ __('frontstaticword.AddAnswer') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!--Model start-->
                                                        <div class="modal fade" id="myModalanswer{{ $ques->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">
                                                                            {{ __('frontstaticword.Answer') }}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="box box-primary">
                                                                        <div class="panel panel-sum">
                                                                            <div class="modal-body">
                                                                                <form id="demo-form2" method="post"
                                                                                    action="{{ url('addanswer', $ques->id) }}"
                                                                                    data-parsley-validate
                                                                                    class="form-horizontal form-label-left">
                                                                                    {{ csrf_field() }}
                                                                                    <input type="hidden"
                                                                                        name="question_id"
                                                                                        value="{{ $ques->id }}" />
                                                                                    <input type="hidden"
                                                                                        name="instructor_id"
                                                                                        value="{{ $course->user_id }}" />
                                                                                    <input type="hidden"
                                                                                        name="ans_user_id"
                                                                                        value="{{ Auth::user()->id }}" />
                                                                                    <input type="hidden"
                                                                                        name="ques_user_id"
                                                                                        value="{{ $ques->user_id }}" />
                                                                                    <input type="hidden"
                                                                                        name="course_id"
                                                                                        value="{{ $ques->course_id }}" />
                                                                                    <input type="hidden"
                                                                                        name="question_id"
                                                                                        value="{{ $ques->id }}" />
                                                                                    <input type="hidden" name="status"
                                                                                        value="1" />
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            {{ $ques->question }}
                                                                                            <br>
                                                                                            <br>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <label
                                                                                                for="detail">{{ __('frontstaticword.Answer') }}:<sup
                                                                                                    class="redstar">*</sup></label>
                                                                                            <textarea name="answer" rows="4" class="form-control" placeholder=""></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="box-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
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
                                                        <div class="modal fade"
                                                            id="myModalquesReport{{ $ques->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">
                                                                            {{ __('frontstaticword.Report') }} Question
                                                                        </h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="box box-primary">
                                                                        <div class="panel panel-sum">
                                                                            <div class="modal-body">
                                                                                <form id="demo-form2" method="post"
                                                                                    action="{{ route('question.report', $ques->id) }}"
                                                                                    data-parsley-validate
                                                                                    class="form-horizontal form-label-left">
                                                                                    {{ csrf_field() }}
                                                                                    <input type="hidden"
                                                                                        name="course_id"
                                                                                        value="{{ $course->id }}" />
                                                                                    <input type="hidden"
                                                                                        name="question_id"
                                                                                        value="{{ $ques->id }}" />
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="title">{{ __('frontstaticword.Title') }}:<sup
                                                                                                        class="redstar">*</sup></label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    name="title"
                                                                                                    id="title"
                                                                                                    placeholder="Please Enter Title"
                                                                                                    value=""
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="email">{{ __('frontstaticword.Email') }}:<sup
                                                                                                        class="redstar">*</sup></label>
                                                                                                <input type="email"
                                                                                                    class="form-control"
                                                                                                    name="email"
                                                                                                    id="title"
                                                                                                    placeholder="Please Enter Email"
                                                                                                    value="{{ Auth::user()->email }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="detail">{{ __('frontstaticword.Detail') }}:<sup
                                                                                                        class="redstar">*</sup></label>
                                                                                                <textarea name="detail" rows="4" class="form-control" placeholder="Enter Detail" required></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="box-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--Model close -->
                                                        <div id="collapseThree{{ $ques->id }}" class="collapse"
                                                            aria-labelledby="headingThree" data-parent="#accordion">
                                                            @php
                                                                $answers = App\Answer::where(
                                                                    'question_id',
                                                                    $ques->id,
                                                                )->get();
                                                            @endphp
                                                            @foreach ($answers as $ans)
                                                                @if ($ans->status == 1)
                                                                    <div class="card-body">
                                                                        <div class="answer-block">
                                                                            <div class="row no-gutters">
                                                                                <div class="col-lg-1 col-2">
                                                                                    <div
                                                                                        class="learning-questions-img-two">
                                                                                        {{ $ans->user->fname[0] }}{{ $ans->user->lname[0] }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-11 col-10">
                                                                                    <div class="section">
                                                                                        <a href="#"
                                                                                            title="questions">{{ $ans->user->fname }}</a>
                                                                                        <a href="#"
                                                                                            title="questions">{{ date('jS F Y', strtotime($ans->created_at)) }}</a>
                                                                                        <div class="author-tag">
                                                                                            {{ $ans->user->role }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="section-answer">
                                                                                        <a href="#"
                                                                                            title="Course">{{ $ans->answer }}</a>
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
                    <div class="tab-pane fade" id="nav-announcement" role="tabpanel"
                        aria-labelledby="nav-announcement-tab">
                        @if ($announcements->isEmpty())
                            <div class="learning-announcement-null text-center">
                                <div class="offset-lg-2 col-lg-8">

                                    <p>No Assignments </p>
                                </div>
                            </div>
                        @else
                            <div class="learning-announcement text-center">
                                <div class="col-lg-12">
                                    <div id="accordion" class="second-accordion">
                                        {{-- @dd($announcements) --}}
                                        @foreach ($announcements as $announcement)
                                            <div class="card">
                                                <div class="card-header" id="headingFour{{ $announcement->id }}">
                                                    <div class="mb-0">



                                                        <!-- Sender Info -->


                                                        <!-- Date -->
                                                        <div class="row mb-2">
                                                            <div class="col-8">
                                                                <div class="d-flex align-items-center mt-2">

                                                                    <div>
                                                                        <strong>{{ $announcement->assignment ?? '' }}
                                                                        </strong>
                                                                        <br>
                                                                        {{-- <small
                                                                                class="text-muted">{{ ucfirst($announcement->sender->role ?? 'User') }}</small> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 d-flex justify-content-end">
                                                                <div class="section">
                                                                    <i class="fa fa-calendar mr-1"></i>
                                                                    {{ date('jS F Y \a\t g:i A', strtotime($announcement->created_at)) }}

                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>

                                                <div id="collapseFour{{ $announcement->id }}" class="collapse"
                                                    aria-labelledby="headingFour{{ $announcement->id }}"
                                                    data-parent="#accordion">
                                                    <div class="card-body">
                                                        <p class="announcement-text">{{ $announcement->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
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
                                    @if (count($topics) > 0)
                                        @foreach ($topics as $topic)
                                            {{-- @php
                                                                            $claprog=App\ClassProgress::where('course_id',$course->id)->where('chapter_id',$topic->coursechapter_id)->where('user_id', Auth::user()->id)->get();
                                                                            @endphp --}}
                                            @if ($topic->status == 1)
                                                @if (Auth::User()->role == 'instructor' || Auth::User()->role == 'user')
                                                    <?php
                                                    $order = App\Order::where(
                                                        "course_id",
                                                        $course->id
                                                    )
                                                        ->where(
                                                            "user_id",
                                                            "=",
                                                            Auth::user()->id
                                                        )
                                                        ->first();

                                                    $days = $topic->due_hours;
                                                    $orderDate =
                                                        $order["created_at"];
                                                    $startDate = date(
                                                        "Y-m-d",
                                                        strtotime(
                                                            "$orderDate +$days days"
                                                        )
                                                    );
                                                    ?>
                                                @else
                                                    <?php $startDate = "0"; ?>
                                                @endif
                                                @php
                                                    $mytime = Carbon\Carbon::now();
                                                @endphp
                                                @if ($mytime >= $startDate)
                                                    {{-- <div class="col-md-6 col-lg-4">
                                                        
                                                    </div> --}}
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
                                            @foreach ($assignment as $assign)
                                                <div class="col-md-12">
                                                    <div class="assignment-tab-block">
                                                        <div class="categories-block assign-tab-one text-center">
                                                            <ul>
                                                                <li class="btm-5"><span>{{ $assign->title }}</span>
                                                                </li>
                                                                <li>
                                                                  
                                                                    <a
                                                                        href="{{ route('download.assignment', $assign->assignment) }}">
                                                                        {{ __('frontstaticword.Download') }} <i
                                                                            class="fa fa-download"></i>
                                                                    </a>
                                                                    <form method="post"
                                                                        action="{{ url('assignment/delete/' . $assign->id) }}"
                                                                        ata-parsley-validate
                                                                        class="form-horizontal form-label-left">
                                                                        {{ csrf_field() }}
                                                                        <button type="submit"
                                                                            class="cart-remove-btn display-inline btn btn-danger "
                                                                            title="Remove From cart">
                                                                            {{ __('frontstaticword.Delete') }}</button>
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
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#assignmodel">{{ __('frontstaticword.SubmitAssignment') }}
                                                </button>
                                            </div>
                                            <div class="modal fade" id="assignmodel" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                {{ __('frontstaticword.SubmitAssignment') }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="box box-primary">
                                                            <div class="panel panel-sum">
                                                                <div class="modal-body">
                                                                    <form id="assigment_form" method="post"
                                                                        action="{{ route('assignment.submit', $course->id) }}"
                                                                        data-parsley-validate
                                                                        class="form-horizontal form-label-left"
                                                                        enctype="multipart/form-data">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ Auth::user()->id }}" />
                                                                        <input type="hidden" name="instructor_id"
                                                                            value="{{ $course->user_id }}" />
                                                                        <div class="row text-center">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="title">{{ __('frontstaticword.Title') }}:<sup
                                                                                            class="redstar">*</sup></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="title" id="assign_title"
                                                                                        placeholder="Please Enter Title"
                                                                                        value="">
                                                                                    <div id="title-error"
                                                                                        class="text-danger"
                                                                                        style="display:none;"></div>
                                                                                    <!-- Error placeholder -->
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="wrapper">
                                                                                        <label
                                                                                            for="detail">{{ __('frontstaticword.AssignmentUpload') }}:<sup
                                                                                                class="redstar">*</sup></label>
                                                                                        <div class="file-upload">
                                                                                            <input type="file"
                                                                                                name="assignment"
                                                                                                class="form-control" />
                                                                                            <i class="fa fa-arrow-up"></i>
                                                                                        </div>
                                                                                        <div id="assignment-error"
                                                                                            class="text-danger"
                                                                                            style="display:none;"></div>
                                                                                        <!-- Error placeholder -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="box-footer text-center">
                                                                            <button type="submit"
                                                                                id="assignment_submit"
                                                                                class="btn btn-sm btn-primary">{{ __('frontstaticword.Submit') }}</button>
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

                    <div class="tab-pane fade" id="nav-feedback" role="tabpanel" aria-labelledby="nav-feedback-tab">
                        <div class="review-block">
                            <div class="row">
                                <div class="col-lg-2">
                                    <h5 class="top-20">{{ __('frontstaticword.Reviews') }}</h5>
                                </div>
                                <div class="col-lg-10 col-12">
                                    <form id="Feedback_form" method="post"
                                        action="{{ route('coursecert.rating', $course->id) }}" data-parsley-validate
                                        class="form-horizontal form-label-left">
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
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <td>
                                                                <input type="radio" name="learn"
                                                                    value="{{ $i }}"
                                                                    id="option{{ $i }}" autocomplete="off"
                                                                    {{ old('learn', $savedLearnValue ?? '') == $i ? 'checked' : '' }}>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @if ($errors->has('learn'))
                                                        <tr>
                                                            <td colspan="6">
                                                                <span
                                                                    class="text-danger">{{ $errors->first('learn') }}</span>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <th scope="row">Quality</th>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <td>
                                                                <input type="radio" name="price"
                                                                    value="{{ $i }}"
                                                                    id="option{{ $i + 5 }}" autocomplete="off"
                                                                    {{ old('price', $savedPriceValue ?? '') == $i ? 'checked' : '' }}>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @if ($errors->has('price'))
                                                        <tr>
                                                            <td colspan="6">
                                                                <span
                                                                    class="text-danger">{{ $errors->first('price') }}</span>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <th scope="row">Support</th>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <td>
                                                                <input type="radio" name="value"
                                                                    value="{{ $i }}"
                                                                    id="option{{ $i + 10 }}" autocomplete="off"
                                                                    {{ old('value', $savedValueValue ?? '') == $i ? 'checked' : '' }}>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @if ($errors->has('value'))
                                                        <tr>
                                                            <td colspan="6">
                                                                <span
                                                                    class="text-danger">{{ $errors->first('value') }}</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <div class="review-text btm-30">
                                                <label for="review">{{ __('frontstaticword.Writereview') }}:</label>
                                                <textarea name="review" rows="4" class="form-control" placeholder=""></textarea>
                                                @if ($errors->has('review'))
                                                    <span class="text-danger">{{ $errors->first('review') }}</span>
                                                @endif
                                            </div>
                                            <div class="review-rating-btn text-right">
                                                <button type="submit" class="btn btn-success"
                                                    title="Review">{{ __('frontstaticword.Submit') }}</button>
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
            $(document).ready(function() {

                $(".group1").colorbox({
                    rel: 'group1'
                });
                $(".group2").colorbox({
                    rel: 'group2',
                    transition: "fade"
                });
                $(".group3").colorbox({
                    rel: 'group3',
                    transition: "none",
                    width: "75%",
                    height: "75%"
                });
                $(".group4").colorbox({
                    rel: 'group4',
                    slideshow: true
                });
                $(".ajax").colorbox();
                $(".youtube").colorbox({
                    iframe: true,
                    innerWidth: 640,
                    innerHeight: 390
                });
                $(".vimeo").colorbox({
                    iframe: true,
                    innerWidth: 500,
                    innerHeight: 409
                });
                $(".iframe").colorbox({
                    iframe: true,
                    width: "100%",
                    height: "100%"
                });
                $(".inline").colorbox({
                    inline: true,
                    width: "50%"
                });
                $(".callbacks").colorbox({
                    onOpen: function() {
                        alert('onOpen: colorbox is about to open');
                    },
                    onLoad: function() {
                        alert('onLoad: colorbox has started to load the targeted content');
                    },
                    onComplete: function() {
                        alert('onComplete: colorbox has displayed the loaded content');
                    },
                    onCleanup: function() {
                        alert('onCleanup: colorbox has begun the close process');
                    },
                    onClosed: function() {
                        alert('onClosed: colorbox has completely closed');
                    }
                });

                $('.non-retina').colorbox({
                    rel: 'group5',
                    transition: 'none'
                })
                $('.retina').colorbox({
                    rel: 'group5',
                    transition: 'none',
                    retinaImage: true,
                    retinaUrl: true
                });


                $("#click").click(function() {
                    $('#click').css({
                        "background-color": "#f00",
                        "color": "#fff",
                        "cursor": "inherit"
                    }).text("Open this window again and this message will still be here.");
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
            $(document).ready(function() {
                $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                    localStorage.setItem('activeTab', $(e.target).attr('href'));
                });
                var activeTab = localStorage.getItem('activeTab');
                if (activeTab) {
                    $('#nav-tab a[href="' + activeTab + '"]').tab('show');
                }
            });
        })(jQuery);
    </script>
    <!-- link for another tab -->
    <script>
        (function($) {
            "use strict";
            $("#goTab4").click(function() {
                $("#nav-tab a:nth-child(4)").click();
                return false;
            });

            $("#goTab3").click(function() {
                $("#nav-tab a:nth-child(3)").click();
                return false;
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        $('#select-all').click(function(event) {
            if (this.checked) {
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
        function pdfvisicheck(id, chapter_id) {
            var class_id = id;
            $('#downchap' + class_id).css("color", "green");
            classprogress(id, chapter_id);
        }


        function pdfvisiviewcheck(event, id, chapter_id) {
            var class_id = id;
            let el = event.target.closest("a");
            if (el) {

                el.style.color = "green";

            }
            $('#pdfclassview' + id).css("color", "green");
            classprogress(id, chapter_id);

            setTimeout(function() {
                location.reload();
            }, 1000);

            return true;
        }

function classprogress(id, chapter_id, el) {
    var class_id = id;
    var course_id = $('#course_id').val();
    $(el).addClass("completed-class");
    console.log(el);

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.ajax({
        type: "POST",
        url: '{{ url('/classprogress') }}',
        data: { class_id, course_id, chapter_id },
        success: function(data) {

            if (data.status === 'completed') {
                $('#assessment_' + chapter_id).addClass('d-none'); 
            }

            if (data.allchapter_id && data.allchapter_id.mark_chapter_id) {
                let completedChapters = data.allchapter_id.mark_chapter_id;
                completedChapters.forEach(function(chap_id) {
                    $('#assessment_' + chap_id).removeClass('d-none');
                });
            }

            if (data.course_completed) {
                $('#course_completed').removeClass('d-none');
            }

            if (data.next_module && data.next_module != chapter_id) { // only reload if next_module is different
                let next_module = data.next_module;

                $('#collapseChapter' + next_module + ' .course-check-table tr.disabled-row')
                    .removeClass('disabled-row');

                $('#collapseChapter' + next_module).collapse('show');

                $('#module-status-' + next_module)
                    .removeClass('badge-danger badge-success')
                    .addClass('badge-warning')
                    .text('On Progress');

                $('#module-status-' + chapter_id)
                    .removeClass('badge-danger badge-success badge-warning')
                    .addClass('badge-success')
                    .text('Completed');

                // reload after a slight delay so users can see the status update
                setTimeout(function() {
                    location.reload();
                }, 500); 
            }
            if(data.next_module == null)
            {
                location.reload();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}



        $(document).ready(function() {

            let onload = 1;
            let course_id = '{{ $course->id }}';
            let user_id = '{{ Auth::user()->id }}';

            $.ajax({
                type: "POST",
                url: '{{ url('/classprogress') }}',
                data: {
                    flag_onload: onload,
                    course_id: course_id,
                    user_id: user_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    if (data.status) {


                        if (data.allchapter_id && data.allchapter_id.mark_chapter_id) {
                            let completedChapters = data.allchapter_id.mark_chapter_id;
                            completedChapters.forEach(function(chap_id) {
                                $('#assessment_' + chap_id).removeClass('d-none');
                            });
                        }
                        if (data.allchapter_id.next_module) {
                            let next_module = data.allchapter_id.next_module;


                            $('#collapseChapter' + next_module + ' .course-check-table tr.disabled-row')
                                .removeClass('disabled-row');
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

        });


        document.getElementById('assigment_form').addEventListener('submit', function(e) {
            e.preventDefault();
            const titleError = document.getElementById('title-error');
            const assignmentError = document.getElementById('assignment-error');
            titleError.style.display = 'none';
            assignmentError.style.display = 'none';
            titleError.innerText = '';
            assignmentError.innerText = '';

            let hasError = false;

            const title = document.getElementById('assign_title').value.trim();
            if (!title) {
                titleError.style.display = 'block';
                titleError.innerText = 'Title is required.';
                hasError = true;
            }
            const assignmentInput = this.assignment;
            const assignment = assignmentInput.files[0];
            if (!assignment) {
                assignmentError.style.display = 'block';
                assignmentError.innerText = 'Please upload your assignment file.';
                hasError = true;
            } else {
                const maxSize = 5 * 1024 * 1024;
                if (assignment.size > maxSize) {
                    assignmentError.style.display = 'block';
                    assignmentError.innerText = 'File size must be less than 5MB.';
                    hasError = true;
                }

                const allowedTypes = ['application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'
                ];

                if (!allowedTypes.includes(assignment.type)) {
                    assignmentError.style.display = 'block';
                    assignmentError.innerText = 'Only PDF, DOC, DOCX, or TXT files are allowed.';
                    hasError = true;
                }
            }

            if (!hasError) {
                this.submit();
            }
        });
    </script>
    <script>
        (function($) {
            "use strict";
            tinymce.init({
                selector: 'textarea'
            });
        })(jQuery);
    </script>

    <!--disabled the assignment submit button -->

    <script>
        $(document).ready(function() {
            $("#assigment_form").on("submit", function(e) {
                var $btn = $("#assignment_submit");

                // check if any error messages are visible
                if ($("#assignment-error:visible").length > 0 || $("#title-error:visible").length > 0) {
                    // stop button disable + uploading text
                    return true; // just allow normal validation
                }

                // Disable the button immediately
                $btn.prop("disabled", true).text("Uploading...");

                // Re-enable after 10 seconds (adjust time as needed)
                setTimeout(function() {
                    $btn.prop("disabled", false).text("{{ __('frontstaticword.Submit') }}");
                }, 10000);
            });
        });
    </script>


@endsection
<style>
    .completed-class {
        color: green !important;
    }

    .completed-class i {
        color: green !important;
    }

    .content a {
        font-size: 24px;
        margin-left: 10px !important;
    }

    .content:hover {
        background-color: #dee2e6;
    }

    .hidden {
        position: absolute;
        visibility: hidden;
        opacity: 0;
    }

    input[type=checkbox]+label {
        color: #0c1e3f;
        font-style: italic;
    }

    input[type=checkbox]:checked+label {
        color: #0c1e3f;
        font-style: normal;
    }

    td.class-type.content.txt-rgt.pdfvisicheck a:visited {
        color: green;
    }

    td.class-type.content.txt-rgt.pdfvisiviewcheck a:visited {
        color: green;
    }

    .learning-courses-about-main-block .second-accordion .card-header {
        padding: 18px !important;
        background: transparent;
        border-bottom: 0;
    }

    .profile-heading {
        font-size: 16px;
        font-weight: 500;
        white-space: normal !important;
        padding: 15px !important;
    }

    .card-body a {
        color: var(--primary-color) !important;
    }

    i.fas.fa-file-powerpoint {
        color: #b80601;
    }
</style>
