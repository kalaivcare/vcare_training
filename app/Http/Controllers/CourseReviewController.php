<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\ReviewRating;

use Auth;

class CourseReviewController extends Controller
{
    public function index()
    {
        $ReviewRating = ReviewRating::with('user')->latest()->get();

        // dd($ReviewRating);
        return view('admin.course_review.index', compact('ReviewRating'));
    }
    public function destroy($id)
    {
        $ReviewRating = ReviewRating::findOrFail($id)->delete();
        return redirect()->back();
    }
}
