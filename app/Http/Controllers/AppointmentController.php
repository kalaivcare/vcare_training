<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Auth;
use App\Course;
use App\User;
use App\Order;
use Mail;
use App\Mail\UserAppointment;
use DB;

class AppointmentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appoint = Appointment::find($id);
        $orders = Order::where('course_id',$id)->where('user_id',Auth::user()->id)->first();
        return view('admin.course.appointment.view', compact('appoint','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $datas = Appointment::findorfail($id);
        $maincourse = Course::findorfail($request->course_id);
        $input['accept'] = $request->accept;
        

        if(isset($request->accept))
        {
            
            Appointment::where('id', $id)
                    ->update(['reply' => $request->reply, 'accept' => 1,'date' =>  $request->date]);
            $user = User::where('id',$datas->user_id)->first();
            $data = Appointment::findorfail($id);

            $x = 'Your Appointment was Accepted';
            Mail::to($user->email)->send(new UserAppointment($x, $data, $user,$maincourse));

            
        }
        else
        { 
            
            Appointment::where('id', $id)
                    ->update(['reply' => NULL, 'accept' => 0,'date' =>  $request->date]);
            
        }

        

        return redirect()->route('course.show',$maincourse->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appointment::where('id', $id)->delete();
        return back()->with('delete','Appointment is Deleted');
    }

    public function delete($id)
    {
        Appointment::where('id', $id)->delete();
        return back()->with('delete','Appointment is Deleted');
    }

    public function request(Request $request, $id)
    {
       $appointment = Appointment::create([
                'user_id' => Auth::User()->id,
                'course_id' => $id,
                'title' => $request->title,
                'detail' =>  $request->detail,
                'phone_no' => $request->phone_no,
                'accept' =>  '0',
                'date' =>  $request->date,
            ]
        );
     
        $users = User::where('id', $request->instructor_id)->first();


       

        return back()->with('success','Appointment Request Sent Successfully !'); 
    }
}
