<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use App\Assigndetail;

use App\CourseInclude;
use App\WhatLearn;
use App\CourseChapter;
use App\RelatedCourse;
use App\CourseClass;
use App\Categories;
use App\User;
use App\Wishlist;
use App\ReviewRating;
use App\Question;
use App\Announcement;
use App\Comment;

use App\Order;
use App\Answer;
use App\Cart;
use App\ReportReview;
use App\SubCategory;
use Session;
use App\QuizTopic;
use App\Quiz;
use Auth;
use Redirect;
use App\BundleCourse;
use App\CourseProgress;
use App\Adsense;
use App\Assignment;
use App\Appointment;
use App\BBL;
use App\Meeting;
use App\Subscriber;
use App\Currency;
use App\Moduleratings;
use App\DailyLearningProgress;



class CourseController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $course = Course::all();
    $coursechapter = CourseChapter::all();
    // dd($course);

    return view('admin.course.index', compact("course", 'coursechapter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function create()
  {
    // dd("test");
    $category = Categories::whereNotIn('id', [1])->get();
    $user =  User::all();
    $course = Course::all();
    $coursechapter = CourseChapter::all();
    $money = Currency::first();
    $amount = Currency::orderby('id', 'desc')->first();
    return view('admin.course.insert', compact("course", 'coursechapter', 'category', 'user', 'money', 'amount'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
    

    $this->validate($request, [
      // 'category_id' => 'required',
      'title' => 'required',
      'short_detail' => 'required',
      // 'detail' => 'required',
      // 'video' => 'mimes:mp4,avi,wmv',
      // 'slug' => 'required|unique:courses,slug',
    ]);

    $input = $request->all();
    if (isset($request->certified)) {
      $input['certified'] = implode(",", $request->certified);
    } else {
      $input['certified'] = $request->certified;
    }
    $data = Course::create($input);

    if (isset($request->type)) {
      $data->type = "1";
    } else {
      $data->type = "0";
    }


    if ($file = $request->file('preview_image')) {
      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/course/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $data->preview_image = $image;
    }

    if ($file = $request->file('player_image')) {
      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/class/player_image/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $data->player_image = $image;
    }

    if ($file = $request->file('transcript_pdf')) {
      $optimizePath = public_path() . '/files/transcript_pdf';
      $image = time() . $file->getClientOriginalName();
      $file->move($optimizePath, $image);

      $input['transcript_pdf'] = $image;
    }


    if (isset($request->preview_type)) {
      $data->preview_type = "video";
    } else {
      $data->preview_type = "url";
    }


    if (!isset($request->preview_type)) {
      $data->url = $request->url;
    } else if ($request->preview_type) {
      if ($file = $request->file('video')) {

        $filename = time() . $file->getClientOriginalName();
        $file->move('video/preview', $filename);
        $data->video = $filename;
      }
    }


    $data->save();

    return redirect('course');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    $cor = Course::find($id);
    return view('admin.course.editcor', compact('cor'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */

  public function edit(course $course)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id)
  {

    $request->validate([
      'title' => 'required',
      'video' => 'mimes:mp4,avi,wmv'

    ]);


    $course = Course::findOrFail($id);
    $input = $request->all();

    if (isset($request->certified)) {
      $input['certified'] = implode(",", $request->certified);
    } else {
      $input['certified'] = $request->certified;
    }

    if (isset($request->type)) {
      $input['type'] = "1";
    } else {
      $input['type'] = "0";
    }


    if ($file = $request->file('image')) {

      if ($course->preview_image != null) {
        $content = @file_get_contents(public_path() . '/images/course/' . $course->preview_image);
        if ($content) {
          unlink(public_path() . '/images/course/' . $course->preview_image);
        }
      }

      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/course/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $input['preview_image'] = $image;
    }

    if ($file = $request->file('player_image')) {

      if ($course->player_image != null) {
        $content = @file_get_contents(public_path() . '/images/class/player_image/' . $course->player_image);
        if ($content) {
          unlink(public_path() . '/images/course/' . $course->preview_image);
        }
      }

      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/class/player_image/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $input['player_image'] = $image;
    }

    if ($file = $request->file('transcript_pdf')) {

      if ($course->transcript_pdf != null) {
        $content = @file_get_contents(public_path() . '/files/transcript_pdf/' . $course->transcript_pdf);
        if ($content) {
          unlink(public_path() . '/files/transcript_pdf/' . $course->transcript_pdf);
        }
      }


      $optimizePath = public_path() . '/files/transcript_pdf';
      $image = time() . $file->getClientOriginalName();
      $file->move($optimizePath, $image);

      $input['transcript_pdf'] = $image;
    }


    if (isset($request->preview_type)) {
      $input['preview_type'] = "video";
    } else {
      $input['preview_type'] = "url";
    }


    if (!isset($request->preview_type)) {
      $course->url = $request->video_url;
      $course->video = null;
    } else if ($request->preview_type) {
      if ($file = $request->file('video')) {
        if ($course->video != "") {
          $content = @file_get_contents(public_path() . '/video/preview/' . $course->video);
          if ($content) {
            unlink(public_path() . '/video/preview/' . $course->video);
          }
        }

        $filename = time() . $file->getClientOriginalName();
        $file->move('video/preview', $filename);
        $input['video'] = $filename;
        $course->url = null;
      }
    }



    Cart::where('course_id', $id)
      ->update([
        'price' => $request->price,
        'offer_price' => $request->discount_price,
      ]);


    $course->update($input);

    return redirect('course');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    $order = Order::where('course_id', $id)->get();

    if (!$order->isEmpty()) {
      return back()->with('delete', 'Users are Enrolled in Course');
    } else {

      $course = Course::find($id);

      if ($course->preview_image != null) {

        $image_file = @file_get_contents(public_path() . '/images/course/' . $course->preview_image);

        if ($image_file) {
          unlink(public_path() . '/images/course/' . $course->preview_image);
        }
      }
      if ($course->video != null) {

        $video_file = @file_get_contents(public_path() . '/video/preview/' . $course->video);

        if ($video_file != null) {
          unlink(public_path() . '/video/preview/' . $course->video);
        }
      }

      $value = $course->delete();


      Wishlist::where('course_id', $id)->delete();
      Cart::where('course_id', $id)->delete();
      ReviewRating::where('course_id', $id)->delete();
      Question::where('course_id', $id)->delete();
      Answer::where('course_id', $id)->delete();
      Announcement::where('course_id', $id)->delete();
      CourseInclude::where('course_id', $id)->delete();
      WhatLearn::where('course_id', $id)->delete();
      CourseChapter::where('course_id', $id)->delete();
      RelatedCourse::where('course_id', $id)->delete();
      CourseClass::where('course_id', $id)->delete();

      return back()->with('delete', 'Course is Deleted');
    }
  }

  public function upload_info(Request $request)
  {
    $id = $request['catId'];


    $categorys = Categories::findOrFail($id);
    $upload = [];

    foreach ($categorys as $category) {
      // Access subcategory relationship on each Category model
      $subcats = $category->subcategory()->where('category_id', $category->id)->pluck('title', 'id')->all();

      // Merge subcategories into $upload array
      $upload = array_merge($upload, $subcats);
    }


    return response()->json($upload);
  }


  public function gcato(Request $request)
  {

    $id = $request['catId'];

    $subcategory = SubCategory::findOrFail($id);
    $upload = $subcategory->childcategory->where('subcategory_id', $id)->pluck('title', 'id')->all();

    return response()->json($upload);
  }
 public function showedit($id)
{
  
    $cor = Course::find($id);
     $money = Currency::first();
    
    return view('admin.course.editcor', compact('cor','money'));
}
public function courseupdate(Request $request, $id)
{
    $request->validate([
        'language_id'   => 'required|exists:course_languages,id',
        'title'         => 'required|string|max:255',
        'slug'          => 'required|string|max:255|unique:courses,slug,' . $id,
        'short_detail'  => 'required|string|max:300',
      
        'course_require'=> 'nullable|string|max:300',
        'detail'        => 'required|string',
        'video'         => 'nullable|mimes:mp4,mov,avi|max:51200',
        'image'         => 'nullable|image|max:2048',
        'player_image'  => 'nullable|image|max:2048',
    ]);

    $course = Course::findOrFail($id);

    $course->language_id    = $request->language_id;
    $course->title          = $request->title;
    $course->slug           = $request->slug;
    $course->short_detail   = $request->short_detail;
    $course->requirement    = $request->requirement;
    $course->course_require = $request->course_require;
    $course->detail         = $request->detail;

    if (auth()->user()->role === 'admin') {
        $course->featured = $request->featured ?? 0;
        $course->status   = $request->status ?? 0;
    }

    $course->preview_type = $request->preview_type == 'on' ? 'video' : 'url';
    $course->url = $request->url;

    if ($request->hasFile('video')) {
        $video = time().'.'.$request->video->extension();
        $request->video->move(public_path('video/preview'), $video);
        $course->video = $video;
    }

    if ($request->hasFile('image')) {
        $image = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/course'), $image);
        $course->preview_image = $image;
    }

    if ($request->hasFile('player_image')) {
        $playerImage = time().'.'.$request->player_image->extension();
        $request->player_image->move(public_path('images/class/player_image'), $playerImage);
        $course->player_image = $playerImage;
    }

    $course->save();

    return redirect('/course')->with('success', 'Course updated successfully');
}


  public function showCourse($id)
  {
    
    $course = Course::all();

    $cor = Course::findOrFail($id);

    $courseinclude = CourseInclude::where('course_id', '=', $id)->get();
    $coursechapter = CourseChapter::where('course_id', '=', $id)->get();
    $whatlearns = WhatLearn::where('course_id', '=', $id)->get();
    $coursechapters = CourseChapter::where('course_id', '=', $id)->get();
    $relatedcourse = RelatedCourse::where('main_course_id', '=', $id)->get();
    $courseclass = CourseClass::where('course_id', '=', $id)->orderBy('position', 'ASC')->get();
    $announsments = Announcement::where('course_id', '=', $id)->get();
    $reports = ReportReview::where('course_id', '=', $id)->get();
    $questions = Question::where('course_id', '=', $id)->get();
    $answers = Answer::where('course_id', '=', $id)->get();
    $quizes = Quiz::where('course_id', '=', $id)->get();
    $topics = QuizTopic::where('course_id', '=', $id)->get();
    $assignment = Assignment::where('course_id', '=', $id)->get();
    $appointment = Appointment::where('course_id', '=', $id)->get();
    $money = Currency::first();
    $amount = Currency::orderby('id', 'desc')->first();
    $module = Moduleratings::all();
    return view('admin.course.show', compact('cor', 'module', 'course', 'money', 'amount', 'courseinclude', 'whatlearns', 'coursechapters', 'coursechapter', 'relatedcourse', 'courseclass', 'announsments', 'answers', 'reports', 'questions', 'quizes', 'topics', 'assignment', 'appointment'));
  }



  public function CourseDetailPage($id, $slug)
  {

    // $clientIP = request()->ip();
    // $countryip = \Location::get($clientIP);
    // $userip = $countryip->countryCode;
    // $counname = $countryip->countryName;


    $currency_value = Session::get('currency_value');
    $money = Currency::where('currency', $currency_value)->first();
    if (empty($money)) {
      $money = Currency::where('countrycode', 'IN')->first();
    }
    $course = Course::findOrFail($id);

    $courseinclude = CourseInclude::where('course_id', '=', $id)->get();
    $whatlearns = WhatLearn::where('course_id', '=', $id)->get();
    $coursechapters = CourseChapter::where('course_id', '=', $id)->get();
    $relatedcourse = RelatedCourse::where('main_course_id', '=', $id)->get();
    $coursereviews = ReviewRating::where('course_id', '=', $id)->get();
    $courseclass = CourseClass::orderBy('position', 'ASC')->get();
    $reviews = ReviewRating::where('course_id', '=', $id)->get();
    $bundle_check = BundleCourse::first();


    $bigblue = BBL::where('course_id', '=', $id)->get();

    $meetings = Meeting::where('course_id', '=', $id)->get();

    $ad = Adsense::first();

    if (!empty($bundle_check)) {
      if (Auth::check()) {

        if (Auth::user()->role == 'user') {
          $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

          $course_id = array();


          foreach ($bundle as $b) {
            $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            array_push($course_id, $bundle->course_id);
          }

          $course_id = array_values(array_filter($course_id));

          $course_id = array_flatten($course_id);

          return view('front.course_detail', compact('course', 'money', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'course_id', 'ad', 'bigblue', 'meetings'));
        } else {
          return view('front.course_detail', compact('course', 'money', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'ad', 'bigblue', 'meetings'));
        }
      } else {

        return view('front.course_detail', compact('course', 'money', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'ad', 'bigblue', 'meetings'));
      }
    } else {
      return view('front.course_detail', compact('course', 'money', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'ad', 'bigblue', 'meetings'));
    }
  }

public function CourseContentPage($id)
{
    $course = Course::findOrFail($id);

    $courseinclude   = CourseInclude::where('course_id', $id)->get();
    $whatlearns      = WhatLearn::where('course_id', $id)->get();
    $coursechapters  = CourseChapter::where('course_id', $id)->where('status', '1')->get();
    $coursequestions = Question::where('course_id', $id)->get();
    $courseclass     = CourseClass::get();

    $progress = CourseProgress::where('course_id', $id)
        ->where('user_id', Auth::id())
        ->first();

    $assignment = Assignment::where('course_id', $id)
        ->where('user_id', Auth::id())
        ->get();

    $announcements = Assigndetail::all();

    $entries = DailyLearningProgress::where('user_id', Auth::id())
        ->orderBy('learning_date', 'desc')
        ->paginate(10);

    $appointment = Appointment::where('course_id', $id)
        ->where('user_id', Auth::id())
        ->get();

    $chapter = CourseChapter::where('course_id', $id)->first();

    /*
    |--------------------------------------------------------------------------
    | Hair & Skin Topic IDs
    |--------------------------------------------------------------------------
    */
    $topicIdsByModule = CourseChapter::whereIn('module_type', ['Hair', 'Skin'])
        ->with('quizTopics:id,coursechapter_id')
        ->get()
        ->groupBy('module_type')
        ->map(function ($chapters) {
            return $chapters->pluck('quizTopics')->flatten()->pluck('id')->toArray();
        });

    $hairTopicIds = $topicIdsByModule['Hair'] ?? [];
    $skinTopicIds = $topicIdsByModule['Skin'] ?? [];

    /*
    |--------------------------------------------------------------------------
    | Question Counts
    |--------------------------------------------------------------------------
    */
    $hairQuestionCount = Quiz::whereIn('topic_id', $hairTopicIds)->count();
    $skinQuestionCount = Quiz::whereIn('topic_id', $skinTopicIds)->count();

    if (Auth::check()) {
        return view(
            'front.course_content',
            compact(
                'course',
                'entries',
                'chapter',
                'courseinclude',
                'whatlearns',
                'coursechapters',
                'courseclass',
                'coursequestions',
                'announcements',
                'progress',
                'assignment',
                'appointment',
                'hairTopicIds',
                'skinTopicIds',
                'hairQuestionCount',
                'skinQuestionCount'
            )
        );
    }

    return Redirect::route('login')
        ->withInput()
        ->with('delete', 'Please Login to access restricted area.');
}


  public function mycoursepage()
  {
    $course = Course::all();
    $enroll = Order::where('user_id', Auth::user()->id)->get();

    //  $clientIP = request()->ip();
    // $countryip = \Location::get($clientIP);
    // $userip = $countryip->countryCode;
    // $counname = $countryip->countryName;


    $currency_value = Session::get('currency_value');
    $money = Currency::where('currency', $currency_value)->first();
    if (empty($money)) {
      $money = Currency::where('countrycode', 'IN')->first();
    }
    return view('front.my_course', compact('course', 'enroll', 'money'));
  }

  public function chimpcurl(Request $request)
  {
    $subscriber = Subscriber::all();
    if (count($subscriber) > 0) {
      //  dd('no');
      foreach ($subscriber as $subscribers) {
        // dd($subscribers->email);
        if ($test = $subscribers->email == $request->email) {
          //  dd($test);

          $already = '1';
          return redirect()->back()->with('delete', 'You are already subscribed');
        }
      }
    }
    if (empty($test)) {
      // dd('yes');

      $subs = new Subscriber;
      $subs->email = $request->email;
      $subs->save();
    }

    $email = $request->email;
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      // MailChimp API credentials
    
      $apiKey = config('services.mailchimp.api_key');
      $listID = '7be1568b61';

      // MailChimp API URL
      $memberID = md5(strtolower($email));
      $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
      $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;

      // member information
      $json = json_encode([
        'email_address' => $email,
        'status'        => 'subscribed',

      ]);

      // send a HTTP POST request with curl
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      $result = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);

      // store the status message based on response code

      return redirect()->back()->with('success', 'Email Subscribed successfully');
    }
  }


  public function upload(Request $request)
  {
    
    $request->validate([
    'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    'profile_image_two' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'profile_image.required' => 'Please upload the first image.',
        'profile_image.image' => 'The first file must be an image.',
        'profile_image.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
        'profile_image.max' => 'The first image must not exceed 2MB.',

        'profile_image_two.required' => 'Please upload the second image.',
        'profile_image_two.image' => 'The second file must be an image.',
        'profile_image_two.mimes' => 'Only JPG, JPEG, and PNG formats are allowed.',
        'profile_image_two.max' => 'The second image must not exceed 2MB.',
    ]);


    
        if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $image_two = $request->file('profile_image_two');

        $filename1 = time() . '_1.' . $image->getClientOriginalExtension();
        $filename2 = time() . '_2.' . $image_two->getClientOriginalExtension();

        $image->move(public_path('test_images'), $filename1);
        $image_two->move(public_path('test_images'), $filename2);

        DB::table('images')->insert([
            'course_id'  => $request->course_id,
            'user_id'    => Auth::id(),
            'chapter_id' => $request->chapter_id,
            'image_one'  => 'test_images/' . $filename1,
            'image_two'  => 'test_images/' . $filename2,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Image uploaded successfully!');
    }


    return back()->withErrors(['profile_image' => 'Please select an image to upload.']);
  }



  public function uploadingImage(Request $request)
  {
    // Step 1: Validate the image  
    // dd($request->all());
    $request->validate([
      'profile_image_two' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Step 2: Store the image
    if ($request->hasFile('profile_image_two')) {
      // $path = $request->file('profile_image_two')->store('quiz_images', 'public');
      $path_two = $request->file('profile_image_two')->store('quiz_images', 'public');
      // Step 3: Save path in the database
      DB::table('images')->insert([
        'course_id'     => $request->course_id,
        // 'user_id'       => $request->Auth::User()->$id,
        'user_id'    => Auth::id(),
        'chapter_id'    => $request->chapter_id,
        // 'image_one'     => $path,
        'image_two'   => $path_two,
        'created_at'    => now(),
      ]);

      return back()->with('uploadSuccess', 'Image uploaded and saved successfully!')->with('path', $path_two);
    }

    return back()->withErrors(['profile_image' => 'Please select an image to upload.']);
  }
}