<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\Enquiry;


class LandingController extends Controller
{
	public function index()
	{
		//$items = Contact::orderby('id','desc')->get();//
		
    	//return view('admin.contact.index',compact('items'));
		return view('landing.index');
	}

	

    public function enquire(Request $request)
    {
		$data = $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/(^[6-9]\d{9}$)/u',
            'location' => 'required',
            'qualification' => 'not_in:0',
            'course' => 'required',
            'comment' => 'required'
        ],[
			'qualification.not_in'=>'Qualification is required',
			'phone.regex'=>'Invalid Mobile Format'
			//'course.gt'=>'Course is required'
		]);
//dd($request);
        Mail::to('info@nihaws.com')->send(new Enquiry($data));

        
        return json_encode(['status'=>true,"message"=>"Mail Sent","error"=>false]);
       
    }
}
