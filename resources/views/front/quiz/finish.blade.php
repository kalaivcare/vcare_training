@extends('theme.master')
@section('title', 'Show Report')
@section('content')
@php
use App\CourseChapter;
use App\Quiz;
use App\QuizAnswer;
use App\UserTestAtempt;

$userId = Auth::id(); 

$chapters = CourseChapter::where('course_id', $course->id)
    ->where('module_type', $type)
    ->with('quizTopics')
    ->get();

$topicIds = $chapters->pluck('quizTopics')->flatten()->pluck('id')->toArray();


$lastAttempt = UserTestAtempt::where('user_id', $userId)
    ->where('course_id', $course->id)
    ->whereIn('chapter_id', $chapters->pluck('id'))
    ->latest('id')
    ->first();

$answers = QuizAnswer::from('quiz_answers as qa')
    ->joinSub(
        QuizAnswer::selectRaw('question_id, MAX(id) as latest_id')
            ->where('course_id', $course->id)
            ->where('user_id', $userId)
            ->whereIn('topic_id', $topicIds) 
            ->groupBy('question_id'),
        'latest_answers',
        function ($join) {
            $join->on('qa.id', '=', 'latest_answers.latest_id');
        }
    )
    ->whereIn('qa.topic_id', $topicIds) 
    ->with('quiz')
    ->orderByDesc('qa.id')
    ->get();

$totalQuestions = count($topicIds) > 0 ? Quiz::whereIn('topic_id', $topicIds)->count() : 0;
$correctCount = $answers->filter(fn($a) => $a->answer == $a->user_answer)->count();
$perQuestionMark = $topic->per_q_mark ?? 1;
$totalMarks = $correctCount * $perQuestionMark;
$percentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 0;
// var_dump($answers);
// dd($correctCount);
@endphp


<section class="main-wrapper finish-main-block">
    <div class="container">
        <br />

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="question-block">
                    <h3 class="text-center main-block-heading">
                        {{ __('frontstaticword.scorecard') }}
                    </h3>
                    <br />

                    <table class="table table-bordered result-table">
                        <thead>
                            <tr>
                                <th>Total Questions</th>
                                <th>Correct</th>
                                <th>Total Marks</th>
                                <th>Percentage</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $totalQuestions }}</td>
                                <td>{{ $correctCount }}</td>
                                <td>{{ $totalMarks }}</td>
                                <td>{{ $percentage }}%</td>
                                <td>
                                    @if($percentage >= 50)
                                        <span class="badge badge-success">Passed</span>
                                    @else
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <br />
                    <div class="finish-btn text-center">
                        <a href="{{ url('show/coursecontent/'.$course->id) }}"
                           class="btn btn-secondary">
                            {{ __('frontstaticword.Back') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
