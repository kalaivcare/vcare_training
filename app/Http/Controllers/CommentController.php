<?php

namespace App\Http\Controllers;

use App\User;
use App\Allstate;
use App\Allcity;
use App\Allcountry;
use Illuminate\Http\Request;
use Hash;
use Session;
use Image;
use Auth;
use App\Wishlist;
use App\Cart;
use App\Order;
use App\ReviewRating;
use App\Question;
use App\Answer;
use App\State;
use App\City;
use App\Country;
use App\Course;
use App\Meeting;
use App\BundleCourse;
use App\BBL;
use App\Instructor;
use App\UserTestAtempt;
use App\CourseProgress;

use App\Comment;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $receiver = $request->User_id;

        if ($user->role == 'admin') {
            $Comments = Comment::with(['sender', 'receiver'])
                ->where('receiver_id', $receiver)
                ->latest()
                ->get();

            return response()->json([
                'status' => 'success',
                'Comments' => $Comments,
                'role' => 'admin'
            ]);
        } else {
            $sender = $user->id;
            $Comments = Comment::with(['sender', 'receiver'])
                ->where('receiver_id', $receiver)
                ->where('sender_id', $sender)
                ->latest()
                ->get();

            return response()->json([
                'status' => 'success',
                'Comments' => $Comments,
                'role' => 'Trainer'
            ]);
        }
    }







    public function store(Request $request)
    {
        // dd('test');

        $request->validate([
            'comment' => 'required|string',

        ]);

        Comment::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->user_id,
            'content' => $request->comment
        ]);
        // dd($request->all());
        return response()->json(['status' => 'success']);
    }
}
