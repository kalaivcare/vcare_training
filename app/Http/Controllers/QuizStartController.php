<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuizTopic;
use App\QuizAnswer;
use App\CourseClass;
use App\ClassProgress;
use App\CourseProgress;
use App\CourseChapter;
use App\UserTestAtempt;
use Mail;

use Auth;
use App\Quiz;
use App\Course;

class QuizStartController extends Controller
{
  public function quizstart(Request $request, $course, $type)
{
    abort_unless(in_array($type, ['Hair', 'Skin']), 404);
    $chapterIds = CourseChapter::where('course_id', $course)
        ->where('module_type', $type)
        ->pluck('id')
        ->toArray();
    $topicIds = QuizTopic::whereIn('coursechapter_id', $chapterIds)
        ->pluck('id')
        ->toArray();
    $que = Quiz::whereIn('topic_id', $topicIds)->get();
    $que_count = $que->count();
    $userAnswers = [];
    if (Auth::check()) {
        $userAnswers = QuizAnswer::where('user_id', Auth::id())
            ->whereIn('topic_id', $topicIds)
            ->pluck('answer', 'question_id')
            ->toArray();
    }

    return view('front.quiz.main_quiz', compact(
        'que',
        'que_count',
        'userAnswers',
        'type',
        'course'
    ));
}
  public function store(Request $request,$type)
  {

    // $topics = QuizTopic::where('id', $id)->first();

    for ($i = 1; $i <= count($request->answer); $i++) {


      $answers[] = [
        'user_id' => Auth::user()->id,
        'user_answer' => $request->answer[$i] ?? '',
        'question_id' => $request->question_id[$i],
        'course_id' => $request->course_id[$i],
        'topic_id' => $request->topic_id[$i],
        'answer' => $request->canswer[$i] ?? '',
        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
      ];
    }

    QuizAnswer::insert($answers);

    return redirect()->route('start.quiz.show', [
        'id' => (int) $request->course_id[1], 
        'type' => $type
    ]);

  }

  public function show($id, $type)
  {
    //    dd($id);
      $auth = Auth::user();
    //   $topic   = QuizTopic::findOrFail($id);
      $course  = Course::findOrFail($id);
     $topicIds = QuizTopic::whereIn(
                    'coursechapter_id',
                    CourseChapter::where('course_id', $course->id)
                        ->where('module_type', $type)
                        ->pluck('id')
                )->pluck('id');
      $questions = Quiz::whereIn('topic_id', $topicIds)->get();
    
      $count_questions = $questions->count();

    $topicIds = collect($topicIds)->toArray(); // safety

    $answers = QuizAnswer::from('quiz_answers as qa')
    ->joinSub(
        QuizAnswer::selectRaw('question_id, MAX(id) as latest_id')
            ->where('user_id', $auth->id)
            ->whereIn('topic_id', $topicIds)
            ->groupBy('question_id'),
        'latest_answers',
        function ($join) {
            $join->on('qa.id', '=', 'latest_answers.latest_id');
        }
    )
    ->whereIn('qa.topic_id', $topicIds)
    ->where('qa.user_id', $auth->id)
    ->whereColumn('qa.answer', 'qa.user_answer')
    ->get();
      $chapterIds = CourseChapter::where('course_id', $course->id)
          ->where('module_type', $type)
          ->pluck('id');
      $courseclass = CourseClass::where('course_id', $course->id)
          ->whereIn('coursechapter_id', $chapterIds)
          ->count();
      $courseprog = ClassProgress::where('user_id', $auth->id)
          ->where('course_id', $course->id)
          ->whereIn('chapter_id', $chapterIds)
          ->distinct('class_id') 
          ->count('class_id');
      $overall = null;
      $userAttempt = UserTestAtempt::firstOrCreate(
          [
              'user_id'    => $auth->id,
              'course_id'  => $course->id,
            //   'chapter_id' => $topic->coursechapter_id,
                'module_type' => $type,
          ],
          [
              'attempts'      => 3,
              'retest_status' => 0,
          ]
      );
    //   if ($courseclass === $courseprog && $count_questions > 0) {

          $correctCount = $answers->filter(function ($a) {
              return $a->answer == $a->user_answer;
          })->count();

          $percentage = ($correctCount / $count_questions) * 100;
          $overall    = round($percentage, 2);
         
          if ($overall >= 50) {

              $progress = CourseProgress::firstOrCreate([
                  'course_id' => $topic->course_id,
                  'user_id'   => $auth->id,
              ]);

              $markChapterId = $progress->mark_chapter_id ?? [];

              if (!in_array($topic->coursechapter_id, $markChapterId)) {
                  $markChapterId[] = $topic->coursechapter_id;
                  $progress->update([
                      'mark_chapter_id' => json_encode($markChapterId)
                  ]);
              }
              $userAttempt->attempts = max(0, $userAttempt->attempts - 1);
              $userAttempt->retest_status = 1; 

          } 
        else {

                    $userAttempt->attempts = max(0, $userAttempt->attempts - 1);
                    $userAttempt->retest_status = 0;

                    if ($userAttempt->attempts == 0 && $userAttempt->fail_mail == 0) {
                        \Mail::to($auth->email)
                            ->cc(['test@gmail.com'])
                        ->send(
                            new \App\Mail\TestAttemptMail(
                                $auth,      
                                $course,     
                                $type,        
                                $userAttempt 
                            )
                        );

                    $userAttempt->fail_mail = 1;
                }
            }
          $userAttempt->save();

    //   }
      return view('front.quiz.finish', compact('auth','questions',
          'count_questions',
          'answers',
          'course',
          'overall',
          'type',
          'userAttempt'
      ));
  }


  public function showtest($id, $type)
  {
    $auth = Auth::user();
          $topic = QuizTopic::findOrFail($id);
          $course = Course::findOrFail($topic->course_id);
      return view('front.quiz.finish', compact(
              
              'course',
              'type'
          ));
  }
public function show_report($id, $type)
 {
    
      $auth = Auth::user();
      $course  = Course::findOrFail($id);
     $topicIds = QuizTopic::whereIn(
                    'coursechapter_id',
                    CourseChapter::where('course_id', $course->id)
                        ->where('module_type', $type)
                        ->pluck('id')
                )->pluck('id');
               
      $questions = Quiz::whereIn('topic_id', $topicIds)->get();
      $count_questions = $questions->count();
      $topicIds = collect($topicIds)->toArray();
    $answers = QuizAnswer::from('quiz_answers as qa')->joinSub(QuizAnswer::selectRaw('question_id, MAX(id) as latest_id')->where('user_id', $auth->id)->whereIn('topic_id', $topicIds)->groupBy('question_id'),'latest_answers',function ($join) {$join->on('qa.id', '=', 'latest_answers.latest_id');})->whereIn('qa.topic_id', $topicIds)->where('qa.user_id', $auth->id)->whereColumn('qa.answer', 'qa.user_answer')->get();
      $chapterIds = CourseChapter::where('course_id', $course->id)
          ->where('module_type', $type)
          ->pluck('id');
      $courseclass = CourseClass::where('course_id', $course->id)
          ->whereIn('coursechapter_id', $chapterIds)
          ->count();
      $courseprog = ClassProgress::where('user_id', $auth->id)
          ->where('course_id', $course->id)
          ->whereIn('chapter_id', $chapterIds)
          ->distinct('class_id') // safet
          ->count('class_id');
      $overall = null;
      if ($courseclass === $courseprog && $count_questions > 0) {

          $correctCount = $answers->filter(function ($a) {
              return $a->answer == $a->user_answer;
          })->count();

          $percentage = ($correctCount / $count_questions) * 100;
          $overall    = round($percentage, 2);
      }
      return view('front.quiz.finish', compact('auth','questions',
          'count_questions',
          'answers',
          'course',
          'overall',
          'type',
         
      ));
    }


  public function tryagain($id)
  {
    QuizAnswer::where('topic_id', $id)->where('user_id', Auth::User()->id)->delete();

    return redirect()->route('start_quiz', $id);
  }
}
  function getNextActiveChapter($currentChapterId, $allChapters)
  {
    $currentIndex = array_search($currentChapterId, $allChapters);

    if ($currentIndex === false) {
      return null;
    }

    for ($i = $currentIndex + 1; $i < count($allChapters); $i++) {
      $chapter = CourseChapter::find($allChapters[$i]);

      if ($chapter && $chapter->status == 1) {
        return $chapter->id;
      }
    }

    return null;
  }
