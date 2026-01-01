@extends('admin.layouts.master')
@section('title', 'View User - Admin')
@section('body')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="content">
        @include('admin.message')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <?php
                    $chapters = App\CourseChapter::orderBy('id', 'asc')->get();
                    
                    ?>
                    @php
                        $attemptsByChapter = $userAttempts->keyBy('chapter_id');
                        // dd($attemptsByChapter);
                    @endphp




                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-responsive display nowrap">
                                <thead>
                                    <th>S.NO</th>


                                    <th>{{ __('adminstaticword.CompletedModules') }}</th>
                                    <th>{{ __('adminstaticword.Module') }}</th>
                                    <th>{{ __('adminstaticword.Percentage') }}</th>

                                </thead>

                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($chapters as $chapter)
                                        <tr>
                                            <td>{{ $i++ }}</td>

                                            <td>
                                                @if ($attemptsByChapter->has($chapter->id))
                                                    @php
                                                        $attempt = $attemptsByChapter[$chapter->id];

                                                        $totalQuestions = \App\QuizAnswer::where(
                                                            'course_id',
                                                            $attempt->course_id,
                                                        )
                                                            ->where('topic_id', $attempt->topic_id)
                                                            ->where('user_id', $attempt->user_id)
                                                            ->count();

                                                        $correctAnswers = \App\QuizAnswer::where(
                                                            'course_id',
                                                            $attempt->course_id,
                                                        )
                                                            ->where('topic_id', $attempt->topic_id)
                                                            ->where('user_id', $attempt->user_id)
                                                            ->whereColumn('user_answer', 'answer')
                                                            ->count();

                                                        $percentage =
                                                            $totalQuestions > 0
                                                                ? round(($correctAnswers / $totalQuestions) * 100, 2)
                                                                : 0;
                                                    @endphp

                                                    @if ($attempt->attempts == 0)
                                                        Last Attempt
                                                    @elseif ($attempt->attempts == 1)
                                                        Third Attempt
                                                    @elseif ($attempt->attempts == 2)
                                                        Second Attempt
                                                    @elseif ($attempt->attempts == 3)
                                                        First Attempt
                                                    @else
                                                        Last Attempt
                                                    @endif
                                                @else
                                                    @php$percentage = 'Not Completed';
                                                                                                                                                                        $topicIds = $chapter->quizTopics()->pluck('id');

                                                                                                                                                                        $totalQuestions = \App\Quiz::where(
                                                                                                                                                                            'course_id',
                                                                                                                                                                            $chapter->course_id,
                                                                                                                                                                        )
                                                                                                                                                                            ->whereIn('topic_id', $topicIds)
                                                                                                                                                                            ->count();
                                                                                                                                                            @endphp ?> ?>

                                                    @if ($totalQuestions == 0)
                                                        No Assessment
                                                    @else
                                                        Not Completed
                                                    @endif
                                                @endif
                                            </td>

                                            <td>
                                                Module: {{ $chapter->chapter_name ?? 'Chapter ' . $chapter->id }}
                                            </td>

                                            <td>

                                                @if ($totalQuestions == 0)
                                                    <span class="badge badge-pill badge-success"
                                                        style="background-color: #22930e;">No Assessment</span>
                                                @elseif($percentage != 'Not Completed')
                                                    <span class="badge badge-pill badge-success"
                                                        style="background-color: #22930e;">{{ $percentage }}%</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $percentage }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>
                        </div>
                    </div>

                    @if (Auth::user()->role != 'admin')
                        <div class="container">
                            <div class="col-md-12" id="fbcomment">
                                <div class="header_comment">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <span class="count_comment">Post Comments</span>
                                        </div>
                                        <div class="col-md-6 text-right">

                                        </div>
                                    </div>
                                </div>

                                <div class="body_comment">

                                    <div class="row">
                                        <div class="avatar_comment col-md-1">
                                            <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                                alt="avatar" />
                                        </div>
                                        <div class="box_comment col-md-11">
                                            <textarea class="commentar" id="comment" placeholder="Add a comment..."></textarea>

                                            <div class="box_post">

                                                <div class="pull-right">
                                                    <span>
                                                        <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                                            alt="avatar" />
                                                        <i class="fa fa-caret-down"></i>
                                                    </span>
                                                    <button onclick="submit_comment()" id="post-btn" class="btn-primary"
                                                        type="button" value="1">Post</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="showcomment">

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->role == 'admin')
                        <div class="container">
                            <div class="col-md-12" id="fbcomment">
                                <div class="header_comment">
                                    <div class="row" id="admin_comment">
                                        <div class="col-md-6 text-left">
                                            <span class="count_comment">Post Comments</span>
                                        </div>
                                        <div class="col-md-6 text-right">

                                        </div>
                                    </div>
                                </div>

                                <div class="body_comment">


                                    <div id="showcomment">

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function submit_comment() {
        let comment = $('#comment').val();

        if (comment.trim() === "") {
            alert("Please enter a comment.");
            return;
        }
        $('#post-btn').attr('disabled', true);
        $.ajax({
            url: '{{ route('comment.store') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                comment: comment,
                user_id: {{ $user_id }}
            },
            success: function(response) {
                if (response.status == "success") {
                    $('#comment').val('');
                    let now = new Date();
                    let formattedDateTime = now.toLocaleString();


                    let newComment = '<div class="comment-item">' +
                        '<div class="avatar-comment"><img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" /></div>' +
                        '<div class="comment-text">' + comment + '</div>' +
                        '<small><i>' + formattedDateTime + '</i></small>' +
                        '</div>';

                    $('.body_comment').append(newComment);
                    $('#post-btn').removeAttr('disabled');

                }
            },

        });
    }
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('comment.index') }}',
            method: 'GET',
            data: {
                User_id: {{ $user_id }},
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (response.role != 'admin') {
                        let comments = response.Comments;

                        comments.forEach(function(cmt) {
                            let html = '<div class="comment-item">' +
                                '<div class="avatar-comment"><img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" /></div>' +
                                '<div class="comment-text">' + cmt.content + '</div>' +
                                '<small><i>' + formatDateTime(cmt.created_at) +
                                '</i></small>' +
                                '</div>';
                            $('#showcomment').append(html);
                        });

                    } else {
                        let comments = response.Comments;
                        $('#admin_comment').html('');
                        debugger;
                        if (comments.length > 0) {
                            debugger;
                            comments.forEach(function(cmt) {

                                let html = `
                       <div class="row">
                                    <div class="avatar_comment col-md-1">
                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"/>
                                    <div class="text-center">
                                     <strong>${cmt.sender?.fname ?? 'Unknown'}</strong>
                                     <strong>${cmt.sender?.role ?? 'Unknown'}</strong>

                                      </div>
                                    
                                    </div>
                                    <div class="box_comment col-md-11">
                                    <textarea class="commentar" id="comment" placeholder="Add a comment..."disabled>${cmt.content}</textarea>
                                     <br><small><i>${formatDateTime(cmt.created_at)}</i></small>
                                   
                                    
                                    </div>
                                </div>
                      
                      `;
                                $('#admin_comment').append(html);


                            });
                        } else {
                            let html = `
                       <div class="row">
                                    <div class="avatar_comment col-md-1">
                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"/>
                                   <div class="text-center">
                                     

                                      </div>
                                    
                                    </div>
                                    <div class="box_comment col-md-11">
                                   
                                     <br><small><i>No Comment</i></small>
                                   
                                    
                                    </div>
                                  
                                </div>
                      
                      `;

                            $('#showcomment').append(html);

                        }


                    }
                }


            }
        });

    });

    function formatDateTime(datetime) {
        let d = new Date(datetime);
        return d.toLocaleString();
    }
</script>

<style>
    .pull-right {
        float: right;
    }

    #fbcomment {
        background: #fff;
        border: 1px solid #dddfe2;
        border-radius: 3px;
        color: #4b4f56;
        padding: 50px;
        margin-bottom: 71px;
    }

    .header_comment {
        font-size: 14px;
        border-bottom: 1px solid #e9ebee;
        line-height: 25px;
        margin-bottom: 24px;
        padding: 10px 0;
    }


    .count_comment {
        font-weight: 600;
    }

    .body_comment {
        padding: 0 8px;
        font-size: 14px;
        display: block;
        line-height: 25px;
        word-break: break-word;
    }

    .avatar_comment {
        display: block;
    }

    .avatar_comment img {
        height: 48px;
        width: 48px;
    }

    .box_comment {
        display: block;
        position: relative;
        line-height: 1.358;
        word-break: break-word;
        border: 1px solid #d3d6db;
        word-wrap: break-word;
        background: #fff;
        box-sizing: border-box;
        cursor: text;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 16px;
        padding: 0;
    }

    .box_comment textarea {
        min-height: 40px;
        padding: 12px 8px;
        width: 100%;
        border: none;
        resize: none;
    }

    .box_comment textarea:focus {
        outline: none !important;
    }

    .box_comment .box_post {
        border-top: 1px solid #d3d6db;
        background: #f5f6f7;
        padding: 8px;
        display: block;
        overflow: hidden;
    }

    .box_comment label {
        display: inline-block;
        vertical-align: middle;
        font-size: 11px;
        color: #90949c;
        line-height: 22px;
    }

    .box_comment button {
        margin-left: 8px;
        background-color: #06193a;
        border: 1px solid #06193a;
        color: #fff;
        text-decoration: none;
        line-height: 22px;
        border-radius: 2px;
        font-size: 14px;
        font-weight: bold;
        position: relative;
        text-align: center;
    }

    .box_comment button:hover {
        background-color: #06193a;
        border-color: #06193a;
    }

    .box_comment .cancel {
        margin-left: 8px;
        background-color: #f5f6f7;
        color: #4b4f56;
        text-decoration: none;
        line-height: 22px;
        border-radius: 2px;
        font-size: 14px;
        font-weight: bold;
        position: relative;
        text-align: center;
        border-color: #ccd0d5;
    }

    .box_comment .cancel:hover {
        background-color: #d0d0d0;
        border-color: #ccd0d5;
    }

    .box_comment img {
        height: 16px;
        width: 16px;
    }

    .box_result {
        margin-top: 24px;
    }

    .box_result .result_comment h4 {
        font-weight: 600;
        white-space: nowrap;
        color: #06193a;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        line-height: 1.358;
        margin: 0;
    }

    .box_result .result_comment {
        display: block;
        overflow: hidden;
        padding: 0;
    }

    .child_replay {
        border-left: 1px dotted #d3d6db;
        margin-top: 12px;
        list-style: none;
        padding: 0 0 0 8px
    }

    .reply_comment {
        margin: 12px 0;
    }

    .box_result .result_comment p {
        margin: 4px 0;
        text-align: justify;
    }

    .box_result .result_comment .tools_comment {
        font-size: 12px;
        line-height: 1.358;
    }

    .box_result .result_comment .tools_comment a {
        color: #06193a;
        cursor: pointer;
        text-decoration: none;
    }

    .box_result .result_comment .tools_comment span {
        color: #90949c;
    }

    .body_comment .show_more,
    .body_comment .show_less {
        background: #06193a;
        border: none;
        box-sizing: border-box;
        color: #fff;
        font-size: 14px;
        margin-top: 24px;
        padding: 12px;
        text-shadow: none;
        width: 100%;
        font-weight: bold;
        position: relative;
        text-align: center;
        vertical-align: middle;
        border-radius: 2px;
    }

    #post-btn {
        background-color:
    }
</style>
