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

class ModuleratingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
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
        
        DB::table('module_ratings')->insert(
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
        return redirect()->route('course.show',$request->course);
    }   
 

    /**
     * Display the specified resource.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $jp = Moduleratings::find($id);
        $users = User::all();
        $courses = Course::all();
        return view('admin.course.reviewrating.edit',compact('jp','courses','users'));
   
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
    public function update(Request $request,$id)
    {

        $data = Moduleratings::findorfail($id);
        $input = $request->all();
        $data ->update($input);
       
        return redirect()->route('course.show',$request->course);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('module_ratings')->where('id',$id)->delete();
        return back();
    }


   
      public function modulerating(Request $request,$id)
    {
dd($request);

        $orders = Order::where('user_id', Auth::User()->id)->where('course_id', $id)->first();
        $review = Moduleratings::where('user_id', Auth::User()->id)->where('course_id', $id)->where('chapter_id',$request->chapter_id)->first();
        if(!empty($orders)){
          

                $input = $request->all();
                $input['course_id'] = $id;
                $input['user_id'] = Auth::User()->id;
                $input['status']=0;
                $input['approved']=0;
                $input['featured']=0;
                $data = Moduleratings::create($input);
                $data->save();

                return back()->with('success','Review Successfully');
          
        }
        else{
            return back()->with('delete','Purchase to review this course');

        }
        
    }
    
  

    
}
