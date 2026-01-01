<?php

namespace App\Http\Controllers;
use App\Course;
use App\Order;
use App\Cart;
use Auth;
use Redirect;
use PDF;
use DB;
use App\Mail\Certificate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class CertificateController extends Controller
{
    public function show($id)
    {
        $order = Order::where('course_id', $id)->where('user_id',Auth::user()->id)->first();
    	$course = Course::where('id', $id)->first();
    	return view('front.certificate.certificate', compact('course', 'order'));
    }

    public function pdfdownload($id)
    {
    	$course = Course::where('id', $id)->first();
        $orders = Order::where('course_id', $id)->where('user_id',Auth::user()->id)->first();
        $pdf = PDF::loadView('front.certificate.download', compact('orders','course'))->setPaper('a4', 'portrait');
        return $pdf->download('certificate.pdf');
       //  return $pdf->stream();
      // return view('front.certificate.download',compact('orders','course'));
    }
    
      public function originalcertificate($id, Request $request){

        $data = Cart::create([
            'user_id' => Auth::User()->id,
            'course_id' => $id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'offer_price' => $request->discount_price,
            'certificate_price' => '1',
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),

        ]
    );
    
    
    
    
    
    
          //dd($data->price);

    $courses = Course::where('id',$id)->first();
    $orders = Order::where('course_id',$id)->where('user_id',Auth::user()->id)->first();

   
            $course = $courses->title;
           // dd($courses);
            if($orders['transaction_id']!=""){
                $order = "Paid";
            }else{
                $order = "Pending";
            }
                Mail::to('rajesh.n@vcaregroup.in')->send(new Certificate($data, $course, $order));
                return back()->with('success','Certificate Request Sent Successfully ! Please check your cart for payment');     
}

}
