@extends('admin.layouts.master')
@section('title', 'View User - Admin')
@section('body')

<section class="content">
    
    @include('admin.message')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">

                {{-- Course Selection Dropdown --}}
                
                <form method="GET" action="{{ route('Userprogress.course.show', $user_id) }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label><strong>Select Course</strong></label>
                            <select name="course_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $courseItem)
                                    <option value="{{ $courseItem->id }}"
                                        {{ ($selectedCourseId ?? '') == $courseItem->id ? 'selected' : '' }}>
                                        {{ $courseItem->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                @if(isset($selectedCourseId))
                     <h4 class="text-primary">Course: {{ $course->title }}</h4>


                {{-- MODULE SUMMARY --}}
                <div class="box-body">
                    {{-- <div>
                        <a href="{{route('user.info')}}"> back</a>
                    </div> --}}
                    <div class="text-right">
                    <h4 class="admin-form-text"><a href="{{route('user.info')}} "  data-toggle="tooltip"
                            data-original-title="Go back" class="btn-floating" style="margin:10px"><i
                                class="material-icons">
                                <button class="btn btn-xs btn-success abc">
                                    << {{ __('adminstaticword.Back') }}</button> </i></a></h4>
                </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Module Type</th>
                                <th>Total Questions</th>
                                <th>Correct Questions</th>
                                <th>Percentage</th>
                                <th>Attempts Left</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp

                            @foreach(['Hair', 'Skin'] as $type)
                                @if(isset($moduleStats[$type]))
                                    @php
                                        $data = $moduleStats[$type];
                                        $percentage = $data['total_questions'] > 0
                                            ? round(($data['correct_questions'] / $data['total_questions']) * 100, 2)
                                            : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><strong>{{ $type }}</strong></td>
                                        <td>{{ $data['total_questions'] }}</td>
                                        <td>{{ $data['correct_questions'] }}</td>
                                        <td>{{ $percentage }}%</td>

                                        {{-- Attempts --}}
                                        <td>
                                            @if(is_null($data['attempts_left']))
                                                <span class="label label-default">Not Started</span>
                                            @else
                                                {{ $data['attempts_left'] }}
                                            @endif
                                        </td>

                                        {{-- Status --}}
                                        <td>
                                            @if(is_null($data['attempts_left']))
                                                <span class="label label-info">Not Started</span>

                                            @elseif($percentage >= 50)
                                                <span class="label label-success">Passed</span>

                                            @elseif($data['attempts_left'] <= 0)
                                                <span class="label label-danger">Attempts Over</span>

                                            @else
                                                <span class="label label-warning">Retry Available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>

                    </table>
                </div>
                    {{-- Daily Learning Progress --}}
                    <div class="box-body mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive display nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($entries as $entry)
                                        <tr>
                                            <td>{{ $entry->learning_date }}</td>
                                            <td>{{ $entry->content }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No entries yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $entries->links() }}
                    </div>

                @else
                    <p class="text-muted mt-3">Please select a course to view details.</p>
                @endif
                @if(Auth::user()->role !='admin')
          
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
                                    <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar"/>
                                    </div>
                                    <div class="box_comment col-md-11">
                                    <textarea class="commentar" id="comment" placeholder="Add a comment..."></textarea>
                                   
                                    <div class="box_post">
                                        
                                        <div class="pull-right">
                                        <span>
                                            <img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" />
                                            <i class="fa fa-caret-down"></i>
                                        </span>
                                        <button onclick="submit_comment()" id="post-btn" class="btn-primary" type="button" value="1">Post</button>
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
            @if(Auth::user()->role == 'admin')
            <div class="container">
                        <div class="col-md-12" id="fbcomment">
                            <div class="header_comment">
                                <div class="row"  id="admin_comment">
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

            </div>
        </div>
    </div>
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

                    let newComment = '<div class="comment-item">' +
                        '<div class="avatar-comment"><img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" /></div>' +
                        '<div class="comment-text">' + comment + '</div>' +
                        '</div>';
                    $('.body_comment').append(newComment);
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
    .date-column {
    width: 150px; 
}

    .pull-right {
        float: right;
    }
    .sec_pagination{
        display: flex;
        justify-content: end;
        margin:18px;
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
