<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Course;
use App\QuizTopic;
use App\QuizAnswer;
use App\CourseChapter;
use App\Imports\QuizImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuizController extends Controller
{


    public function index()
    {
        $courses = Course::all();
        $topics = CourseChapter::all();
        $questions = Quiz::with(['course'])->paginate(10);
        //  $questions = Quiz::with(['course'])->get();

        return view('admin.course.quiz.index', compact('questions', 'topics', 'courses'));
    }
    public function import(Request $request)
{
    // Validate first
// dd($request->all());
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
        'course_id' => 'required|exists:courses,id',
        'chapter_id' => 'required|exists:course_chapters,id',
    ]);

    // Get the topic id
    $topic_id = QuizTopic::where('coursechapter_id', $request->chapter_id)
        ->value('id');
            // dd($topic_id);

    if (!$topic_id) {
        return back()->withErrors('No topic found for selected chapter');
    }

    $request->merge(['topic_id' => $topic_id]);
    
    Excel::import(
        new QuizImport($request->course_id, $request->topic_id),
        $request->file('file')
    );

    return back()->with('success', 'Questions imported successfully!');
}


    public function create()
    {
        // 
    }


    public function store(Request $request)
    {

        $request->merge([
            'topic_id' => QuizTopic::where('coursechapter_id', $request->chapter_id)->value('id'),
        ]);
        $request->validate([
            'course_id' => 'required',
            'topic_id' => 'required',
            'question' => 'required',
            'question_time' => 'required|numeric|max:10000',
            'a' => 'required',
            'b' => 'required',
            'answer' => 'required',
        ]);
        // $request->validate([
        //     'course_id' => 'required',
        //     'topic_id' => 'required',
        //     'question' => 'required',
        //     'question_time' => 'required|numeric|min:1|max:10000',
        //     'a' => 'required',
        //     'b' => 'required',
        //     'answer' => 'required',
        // ], [
        //     'question_time.numeric' => 'Question Time must be a number.',
        //     'question_time.min' => 'Question Time must be at least 1 minute.',
        //     'question_time.max' => 'Question Time must not exceed 10000 minutes.',
        // ]);


        $input = $request->all();


        $input['answer_exp'] = $request->answer_exp;
        Quiz::create($input);
        return back()->with('added', 'Question has been added');
    }


    public function show($id)
    {
        $topic = QuizTopic::findOrFail($id);
        $quizes = Quiz::where('topic_id', $topic->id)->get();
        return view('admin.course.quiz.index', compact('topic', 'quizes'));
    }


    public function edit($id)
    {
        $chapters = CourseChapter::all();
        $topic = QuizTopic::findOrFail($id);
        $editquizes = Quiz::where('$id', $topic->id)->get();
        return view('admin.course.quiz.index', compact('topic', 'editquizes', 'chapters'));
    }


    public function update(Request $request, $id)
    {
        $question = Quiz::findOrFail($id);
        $request->merge([
            'topic_id' => QuizTopic::where('coursechapter_id', $request->chapter_id)->value('id'),
        ]);

        $request->validate([
            'topic_id' => 'required',
            'question' => 'required',
            'question_time' => 'required',
            'regex:/^\d+(\.\d+)?$/',
            'min:1',
            'max:10000',
            'a' => 'required',
            'b' => 'required',
            'c' => 'required',
            'd' => 'required',
            'answer' => 'required',

        ]);


        $input = $request->all();
        // dd($input);


        $input['answer_exp'] = $request->answer_exp;
        $question->update($input);
        return back()->with('updated', 'Question has been updated');
    }


    public function destroy($id)
    {
        $question = Quiz::findOrFail($id);
        $question->delete();

        QuizAnswer::where('question_id', $id)->delete();

        return back()->with('deleted', 'Question has been deleted');
    }
}