<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Image;
use App\BBL;
use Session;
use App\Cart;
use App\City;
use App\Quiz;
use App\User;
use App\Order;
use App\State;
use App\Answer;
use App\Course;
use App\Allcity;
use App\Country;
use App\Meeting;
use App\Allstate;
use App\Question;
use App\Wishlist;
use App\Allcountry;
use App\Assignment;
use App\Instructor;
use App\QuizAnswer;
use App\Announcement;
use App\BundleCourse;
use App\ReviewRating;
use App\CourseChapter;
use App\CourseProgress;
use App\UserTestAtempt;
use Illuminate\Http\Request;
use App\DailyLearningProgress;

class UserController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function viewAllUser()
    {
        $users = User::whereNotIn('role', ['admin', Auth::User()->role])->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function create()
    // {
    //     $cities = Allcity::all();
    //     $states = Allstate::all();
    //     $countries = Country::all();
    //     return view('admin.user.adduser')->with(['cities' => $cities, 'states' => $states, 'countries' => $countries]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'mobile' => 'required|regex:/[0-9]{9}/',
            'address' => 'required|max:2000',
            'email' => 'required|unique:users,email',
            // 'password' => 'required|min:6|max:20',
            'status' => 'required|boolean',
            'role' => 'required',
            'user_img' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);


        $input = $request->all();
        if ($file = $request->file('user_img')) {
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user_img/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);
            $input['user_img'] = $image;
        }

        // $input['password'] = Hash::make($request->password);
        $input['detail'] = $request->detail;
        $data = User::create($input);
        $data->save();

        Session::flash('success', 'User Added Successfully !');
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $user = User::findorfail($id);
        return view('admin.user.edit', compact('cities', 'states', 'countries', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $user = User::findorfail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $input = $request->all();


        if ($file = $request->file('user_img')) {

            if ($user->user_img != null) {
                $content = @file_get_contents(public_path() . '/images/user_img/' . $user->user_img);
                if ($content) {
                    unlink(public_path() . '/images/user_img/' . $user->user_img);
                }
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user_img/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);
            $input['user_img'] = $image;
        }


        if (isset($request->update_pass)) {

            $input['password'] = Hash::make($request->password);
        } else {
            $input['password'] = $user->password;
        }

        // if (isset($request->status)) {
        //     $input['status'] = '1';
        // } else {
        //     $input['status'] = '0';
        // }


        $user->update($input);

        Session::flash('success', 'User Updated Successfully !');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);
        if ($user->user_img != null) {

            $image_file = @file_get_contents(public_path() . '/images/user_img/' . $user->user_img);

            if ($image_file) {
                unlink(public_path() . '/images/user_img/' . $user->user_img);
            }
        }

        $value = $user->delete();
        Course::where('user_id', $id)->delete();
        Wishlist::where('user_id', $id)->delete();
        Cart::where('user_id', $id)->delete();
        Order::where('user_id', $id)->delete();
        ReviewRating::where('user_id', $id)->delete();
        Question::where('user_id', $id)->delete();
        Answer::where('ans_user_id', $id)->delete();
        Meeting::where('user_id', $id)->delete();
        BundleCourse::where('user_id', $id)->delete();
        BBL::where('instructor_id', $id)->delete();
        Instructor::where('user_id', $id)->delete();
        CourseProgress::where('user_id', $id)->delete();

        if ($value) {
            session()->flash("success", "User Has Been Deleted");
            return redirect("user");
        }
    }
    
    public function Userinfo()
    {
        $courseProgress = CourseProgress::with('user')
            ->whereHas('user', function ($query) {
                $query->whereNotIn('role', ['admin', 'trainer']);
            })
            ->get();
            
        return view('admin.UserProgress.info', compact('courseProgress'));
    }
public function ShowUserCourseProgress(Request $request, $id)
{
    $user_id = $id;
    $selectedCourseId = $request->course_id;

    $courses = Course::orderBy('title')->get();
    $course  = Course::findOrFail($selectedCourseId);

    $chapters = CourseChapter::where('course_id', $selectedCourseId)
        ->whereIn('module_type', ['Hair', 'Skin'])
        ->with('quizTopics')
        ->get()
        ->groupBy('module_type');

    $moduleStats = [];

    foreach ($chapters as $module => $moduleChapters) {
        $topicIds = $moduleChapters
            ->pluck('quizTopics')
            ->flatten()
            ->pluck('id')
            ->unique();

        $totalQuestions = Quiz::where('course_id', $selectedCourseId)
            ->whereIn('topic_id', $topicIds)
            ->count();

        $correctQuestions = QuizAnswer::from('quiz_answers as qa')
            ->join('quiz_questions as q', 'q.id', '=', 'qa.question_id')
            ->joinSub(
                QuizAnswer::selectRaw('question_id, MAX(id) as latest_id')
                    ->where('course_id', $selectedCourseId)
                    ->where('user_id', $user_id)
                    ->groupBy('question_id'),
                'latest_answers',
                fn ($join) => $join->on('qa.id', '=', 'latest_answers.latest_id')
            )
            ->whereIn('q.topic_id', $topicIds)
            ->whereColumn('qa.user_answer', 'qa.answer')
            ->count();

        $latestAttempt = UserTestAtempt::where('user_id', $user_id)
            ->where('course_id', $selectedCourseId)
            ->whereIn('chapter_id', $moduleChapters->pluck('id'))
            ->latest('id')
            ->first();

        $moduleStats[$module] = [
            'module_type'       => $module,
            'total_questions'   => $totalQuestions,
            'correct_questions' => $correctQuestions,
            'attempts_left'     => $latestAttempt?->attempts,
            'retest_status'     => $latestAttempt?->retest_status,
        ];
    }

    // dd($moduleStats);    

    $entries = DailyLearningProgress::where('user_id', $user_id)
        ->orderBy('learning_date', 'desc')
        ->paginate(10);

    return view('admin.UserProgress.show', compact(
        'user_id',
        'courses',
        'selectedCourseId',
        'course',
        'moduleStats',
        'entries'
    ));
}


    public function ShowUserDetails($id)
    {
        $user_id = $id;
        $userAttempts =  UserTestAtempt::where('user_id', $id)->get();
        $courseProgress = CourseProgress::with('user')->get();
        $courses = Course::all();
        $entries = DailyLearningProgress::where('user_id', $id)
                    ->orderBy('learning_date', 'desc')
                    ->paginate(10);
        return view('admin.UserProgress.show', compact('userAttempts', 'courseProgress', 'courses', 'user_id' ,'entries'));
        // dd($userdetails);
    }
    public function AssigmentInfo()
    {
        $Announcement = Assignment::with('user')->with('courses')->paginate(10);

        return view('admin.announcement.index', compact('Announcement'));
    }
    public function assignmentdest($id)
    {
         $topic = Assignment::where('id', $id)->first();

        if($topic != NULL)
        {
          Assignment::where('id', $id)->delete();
        }
        // return redirect()->route('course.show',$topic->course_id);
               return redirect()->route('assignment/assignmentinfo');



    }
}