<?php

namespace App\Http\Controllers;

use App\Moduleratings;
use App\ReviewRating;
use Illuminate\Http\Request;
use App\User;
use App\Course;
use DB;
use Auth;
use App\Order;
use PDF;

class ReviewratingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::table('review_ratings')->insert(
            array(
                'course_id' => $request->course,
                'user_id' => $request->user_id,
                'review' => $request->review,
                'status' => $request->status,
                'approved' => $request->approved,
                'featured' => $request->featured,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            )
        );
        return redirect()->route('course.show', $request->course);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $jp = ReviewRating::find($id);
        $users = User::all();
        $courses = Course::all();
        return view('admin.course.reviewrating.edit', compact('jp', 'courses', 'users'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function edit(reviewrating $reviewrating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = ReviewRating::findorfail($id);
        $input = $request->all();
        $data->update($input);

        return redirect()->route('course.show', $request->course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('review_ratings')->where('id', $id)->delete();
        return back();
    }


    public function courserating(Request $request, $id)
    {

        $orders = Order::where('user_id', Auth::User()->id)->where('course_id', $id)->first();
        $review = ReviewRating::where('user_id', Auth::User()->id)->where('course_id', $id)->first();

        if (!empty($orders)) {
            if (!empty($review)) {
                return back()->with('delete', 'You already reviewed this course');
            } else {

                $input = $request->all();
                $input['course_id'] = $id;
                $input['user_id'] = Auth::User()->id;
                $input['status'] = 0;
                $data = ReviewRating::create($input);
                $data->save();

                return back()->with('success', 'Review Successfully');
            }
            return back()->with('success', 'Review Successfully');
        } else {
            return back()->with('delete', 'Purchase to review this course');
        }
    }

    public function certrating(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
                'learn' => 'required|integer|between:1,5',
                'price' => 'required|integer|between:1,5',
                'value' => 'required|integer|between:1,5',
                'review' => 'required|string|min:2',
        ],
             [
        'learn.required' => 'Accessibility is required',
        'price.required' => 'Quality is required',
        'value.required' => 'Support is required',
        'review.required' => 'review is required',

    ]);

        $review = ReviewRating::where('user_id', Auth::User()->id)->where('course_id', $id)->first();

        $course = Course::where('id', $id)->first();
        $orders = Order::where('course_id', $id)->where('user_id', Auth::user()->id)->first();
        $input = $request->all();
        $input['course_id'] = $id;
        $input['user_id'] = Auth::User()->id;
        $data = ReviewRating::create($input);
        $data->save();

        $input['quality'] = $request->value;
        $input['support'] = $request->price;
        $input['accessibility'] = $request->learn;
        $data = Moduleratings::create($input);
        $data->save();



        return back()->with('success', 'Review Successfully Submitted');
        // $pdf = PDF::loadView('front.certificate.download', compact('orders', 'course'))->setPaper('A4', 'Portrait');

        // if (!empty($review)) {

        //     return $pdf->download('certificate');
        // } else {

        //     $input = $request->all();
        //     $input['course_id'] = $id;
        //     $input['user_id'] = Auth::User()->id;
        //     $data = ReviewRating::create($input);
        //     $data->save();

        //     return $pdf->download('certificate');
        // }
    }


    public function modulerating(Request $request, $id)
    {
        // dd($request->all());

        $orders = Order::where('user_id', Auth::User()->id)->where('course_id', $id)->first();
        $review = Moduleratings::where('user_id', Auth::User()->id)->where('course_id', $id)->where('chapter_id', $request->chapter_id)->first();



        $input = $request->all();
        $input['course_id'] = $id;
        $input['user_id'] = Auth::User()->id;
        // $input['quality'] = $request->value;
        // $input['support'] = $request->price;
        // $input['accessbility'] = $request->learn;
        $data = Moduleratings::create($input);
        $data->save();

        return back()->with('success', 'Review Successfully');
    }

    public function cert()
    {
        //dd($id);



        $course = Course::where('id', 1)->first();
        $orders = Order::where('course_id', 1)->where('user_id', Auth::user()->id)->first();
        $customPaper = array(0, 0, 595.275590551, 841.88976378);
        // return view('front.certificate.test', compact('orders','course'));


        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('front.certificate.test', compact('orders', 'course'))->setPaper($customPaper);



        return $pdf->stream();
    }
}
