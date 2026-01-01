<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Order;
use Redirect,Response;
use App\Cart;
use Auth;
use DB;
use App\Currency;
use Session;
use App\Wishlist;
use Mail;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Course;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use App\Setting;
use App\Mail\WelcomeUser;


class RazorpayController extends Controller
{

	public function pay() {
        return view('razorpay');
    }
    
    
    public function payorder(Request $request){
        
            //   $api = new Api('rzp_live_JecF8FlWyMaAW0','Zs1rEHyiUO1t0LzlFObk3s7O');

        
         $PUBLIC_KEY = 'rzp_live_JecF8FlWyMaAW0';
         $PRIVATE_KEY = 'Zs1rEHyiUO1t0LzlFObk3s7O';
         
         
         
      
             
         $userdata = array(
          "amount"=> $request->amount*100,
          "currency"=>$request->currency,
          'notes' => [
              'nih_user_id' => $request->user_id,
              'nih_order_id' => $request->orderid,
              ]

        
      );

         
     $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.razorpay.com/v1/orders",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_USERPWD => $PUBLIC_KEY.":".$PRIVATE_KEY ,
          CURLOPT_POSTFIELDS =>json_encode($userdata),
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response,true);

         	$carts = Cart::where('user_id',$request->user_id)->get();
         	
         
            
	   	foreach($carts as $cart)
	   	{ 
	   	   
	   		if ($cart->offer_price != 0)
            {
                $pay_amount =  $cart->offer_price+$cart->offline_tutor+$cart->online_tutor_one+$cart->online_tutor_two+$cart->hard_course;
            }
            else
            {
                $pay_amount =  $cart->price+$cart->offline_tutor+$cart->online_tutor_one+$cart->online_tutor_two+$cart->hard_course;
            }

            if ($cart->disamount != 0 || $cart->disamount != NULL)
            {
                $cpn_discount =  $cart->disamount;
            }
            else
            {
                $cpn_discount =  '';
            }


               

                if($cart->bundle_id!=Null)
                {
                    $bundle_id = $cart->bundle_id;
                    $bundle_course_id = $cart->bundle->course_id;
                    $course_id = NULL;
                    $duration = NULL;
                    $instructor_payout = NULL;
                    $todayDate = NULL;
                    $expireDate = NULL;
                    $instructor_id = $cart->bundle->user_id;
                }elseif($cart->workshop_id!=Null){
                    $course_id = NULL;
                    $bundle_id =NULL;
                    $bundle_course_id = NULL;
                    $duration = NULL;
                    $instructor_payout = NULL;
                    $todayDate = NULL;
                    $expireDate = NULL;
                    $instructor_id = NULL;
                    $workshop_id=$cart->workshop_id;
                }else{

                    if($cart->courses->duration != NULL && $cart->courses->duration !='')
                    {
                        $days = $cart->courses->duration * 30;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    }
                    else{
                        $todayDate = NULL;
                        $expireDate = NULL;
                    }

                    $setting = InstructorSetting::first();

                    if(isset($setting))
                    {
                        if($cart->courses->user->role == "instructor")
                        {
                            $x_amount = $pay_amount * $setting->instructor_revenue;
                            $instructor_payout = $x_amount / 100;
                        }
                        else
                        {
                            $instructor_payout = NULL;
                        }
                    }
                    else
                    {
                        $instructor_payout = NULL;
                    }

                    $bundle_id = NULL;
                    $course_id = $cart->course_id;
                    $bundle_course_id = NULL;
                    $duration = $cart->courses->duration;
                    $instructor_id = $cart->courses->user_id;
                    $workshop_id=NULL;
                }
                
                
    if($course_id != Null){
        $orderpay = DB::table('orderpay')->where('course_id',$cart->courses->id)->where('user_id',$request->user_id)->orderBy('id', 'DESC')->first();
        $bundle_course = NULL;  
    }else if($workshop_id){
        $orderpay = DB::table('orderpay')->where('workshop_id',$cart->workshops->id)->where('user_id',$request->user_id)->orderBy('id', 'DESC')->first();
        $bundle_course = NULL; 
    }else{
        $orderpay = DB::table('orderpay')->where('course_id',$cart->bundle_id)->where('user_id',$request->user_id)->orderBy('id', 'DESC')->first();
        $bundle_course = implode(",",$bundle_course_id);  
    }     
	 
      
    

		  DB::table('orderpay')->insert([
		        'cart_id' => $cart->id,
	        	'course_id' => $course_id,
	        	'workshop_id' => $workshop_id,
	        	'user_id' => $request->user_id,
	        	'instructor_id' => $instructor_id,
	        	'order_id' => $status['id'],
                'orderid' => $request->orderid,
	            'transaction_id' => NULL,
	            'payment_method' => 'Razorpay',
	            'total_amount' => $pay_amount,
	            'offline_tutor' => $cart->offline_tutor,
                'online_tutor_one' => $cart->online_tutor_one,
                'online_tutor_two' => $cart->online_tutor_two,
                'hard_course' => $cart->hard_course,
                'no_hours' => $cart->no_hours,
	            'coupon_discount' => $cpn_discount,
	            'currency' => $status['currency'],
	            'status' => $status['status'],
	            'currency_icon' => $cart->currency_icon,
	            'duration' => $duration,
	            'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'bundle_id' => $bundle_id,
                'bundle_course_id' => $bundle_course,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
	            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
	           
	            ]
	        );
	 return $status;
	 
	   	}
         
                

         
        
  
    }

    public function dopayment(Request $request) 
    {

        $user_email = Auth::User()->email;
    	$com_email = env('MAIL_FROM_ADDRESS');

		$carts = Cart::where('user_id',Auth::User()->id)->get();
        $thank_id = array(); 
	   	foreach($carts as $cart)
	   	{ 
	   		if ($cart->offer_price != 0)
            {
                $pay_amount =  $cart->offer_price+$cart->offline_tutor+$cart->online_tutor_one+$cart->online_tutor_two+$cart->hard_course;
            }
            else
            {
                $pay_amount =  $cart->price+$cart->offline_tutor+$cart->online_tutor_one+$cart->online_tutor_two+$cart->hard_course;
            }

            if ($cart->disamount != 0 || $cart->disamount != NULL)
            {
                $cpn_discount =  $cart->disamount;
            }
            else
            {
                $cpn_discount =  '';
            }


                $lastOrder = Order::orderBy('created_at', 'desc')->first();

                if ( ! $lastOrder )
                {
                    // We get here if there is no order at all
                    // If there is no number set it to 0, which will be 1 at the end.
                    $number = 0;
                }
                else
                { 
                    $number = substr($lastOrder->order_id, 3);
                }

                if($cart->type == 1)
                {
                    $bundle_id = $cart->bundle_id;
                    $bundle_course_id = $cart->bundle->course_id;
                    $course_id = NULL;
                    $duration = NULL;
                    $instructor_payout = NULL;
                    $todayDate = NULL;
                    $expireDate = NULL;
                    $instructor_id = $cart->bundle->user_id;
                }
                else{
                   if($cart->course_id != Null){
                    if($cart->courses->duration != NULL && $cart->courses->duration !='')
                    {
                        $days = $cart->courses->duration * 30;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    }
                    else{
                        $todayDate = date('Y-m-d');
                        $expireDate = NULL;
                    }
                   }
                    else{
                        $todayDate = date('Y-m-d');
                        $expireDate = NULL;
                    }

                    $setting = InstructorSetting::first();

                    if(isset($setting))
                    {
                        if($cart->courses->user->role == "instructor")
                        {
                            $x_amount = $pay_amount * $setting->instructor_revenue;
                            $instructor_payout = $x_amount / 100;
                        }
                        else
                        {
                            $instructor_payout = NULL;
                        }
                    }
                    else
                    {
                        $instructor_payout = NULL;
                    }

                    $bundle_id = NULL;
                    $course_id = $cart->course_id;
                    $bundle_course_id = NULL;
                    if ($cart->course_id != null) {
                        $duration = $cart->courses->duration;
                        $instructor_id = $cart->courses->user_id;
                    }
                    else{
                        $duration = Null;
                        $instructor_id = Null;
                    }
                }
                
               
             $created_order = Order::create([
	        	'course_id' => $course_id,
	        	'workshop_id' => $cart->workshop_id,
	        	'user_id' => Auth::User()->id,
	        	'instructor_id' => $instructor_id,
	        	'order_id' => $cart->orderid,
	            'transaction_id' => $request->razorpay_payment_id,
	            'payment_method' => 'RazorPay',
	            'total_amount' => $pay_amount,
	            'offline_tutor' => $cart->offline_tutor,
                'online_tutor_one' => $cart->online_tutor_one,
                'online_tutor_two' => $cart->online_tutor_two,
                'hard_course' => $cart->hard_course,
                'no_hours' => $cart->no_hours,
                'no_hours_off' => $cart->no_hours_off,
	            'coupon_discount' => $cpn_discount,
	            'currency' => $cart->currency,
	            'currency_icon' => $cart->currency_icon,
	            'duration' => $duration,
	            'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'bundle_id' => $bundle_id,
                'bundle_course_id' => $bundle_course_id,
	            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
	            ]
	        );

            
            array_push($thank_id,$created_order['id']);

	        Wishlist::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

	        Cart::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

	        if($created_order){

                if($cart->type == 0)
                {
                  if($cart->course_id != Null){
                    if($cart->courses->user->role == "instructor")
                    {

                        $created_payout = PendingPayout::create([
                            'user_id' => $cart->courses->user_id,
                            'course_id' => $cart->course_id,
                            'order_id' => $created_order->id,
                            'transaction_id' => $request->razorpay_payment_id,
                            'total_amount' => $pay_amount,
                            'currency' => $cart->currency,
	                        'currency_icon' => $cart->currency_icon,
                            'instructor_revenue' => $instructor_payout,
                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                  }
                }

            }
            if($created_order){
                if (env('MAIL_USERNAME')!=null) {
                    try{
                        
                        /*sending email*/
                        // $x = 'You are successfully enrolled in a course';
                        $order = $created_order;
                        if($cart->workshop_id != Null){
          					$x = 'You are successfully enrolled in '.$order->workshops->title;
						 }
						 elseif($cart->course_id != Null){
						     	$x = 'You are successfully enrolled in '.$order->courses->title;
						 }
						 else{
     						$x = 'You are successfully enrolled in '.$order->bundle->title;
						 }
                        Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));


                    }catch(\Swift_TransportException $e){
                        Session::flash('deleted','Payment Successfully ! but Invoice will not sent because of error in mail configuration !');
                        // return redirect('/');
                    }
                }
            }

	       

            if($cart->type == 0)
            {

    			if($created_order){
    				// Notification when user enroll
    				  if($cart->course_id != Null){
    		        $cor = Course::where('id', $cart->course_id)->first();

    		        $course = [
    		          'title' => $cor->title,
    		          'image' => $cor->preview_image,
    		        ];

    		        $enroll = Order::where('course_id', $cart->course_id)->get();
    				  }
    				

    		        if(!$enroll->isEmpty())
    		        {
    		            foreach($enroll as $enrol)
    		            {
    		                 if($cart->course_id != Null){
    		                $user = User::where('id', $enrol->user_id)->get();
    		                Notification::send($user,new UserEnroll($course));
    		                 }
    		            }
    		        }
    			}
            }
           
		}
        Session::put('details',$thank_id);
     
		    return redirect()->route('thankyou');
       
        
    }
    
   public function thankyou(){
       return view('thankyou');
    }


}
