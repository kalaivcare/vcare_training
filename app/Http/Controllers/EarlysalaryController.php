<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Order;
use Redirect,Response;
use App\Cart;
use Auth;
use DB;
use App\Currency;
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
use App\Earlysalary;
use Storage;


class EarlysalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
// dd($request->cart_id);
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.earlysalary.com/prod/esapi/generateToken",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{\n\"username\": \"NIHAWSUser\",\n    \"password\": \"NI#@WS@123\"\n, \n    \"applicationName\": \"APP\"\n}",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
          ),
        ));


      
        $response = curl_exec($curl);
        curl_close($curl);

        
        $tokenresponse = json_decode($response);
        $token = $tokenresponse->{'token'};

        $userdata = array(
          'mobile_number' => $request->mobile,
          'merchant_id' => '3735' , 
          'product_name'  => $request->course,
          'order_id' => $request->orderid,
          'order_amount' => $request->price,
          'requestType' => 'saveOrder'
        
      );

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.socialworth.in/checkout-prod/escheckout/leadGen",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($userdata),
      
        
          CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
             "Authorization:".$token
          ),
        ));
        $saveresponse = curl_exec($curl);
        
        curl_close($curl);
      
 
        $ordersave = json_decode($saveresponse, true);

 
        if(isset($ordersave)){
          if(!empty($ordersave['errorMessage'])){
          
            Session::flash('delete','Invalid credentials !');
            return redirect('/all/cart');
      
          }
          elseif($ordersave['status_code'] == 200 || $ordersave['error_code'] == 'OK'){


            $esorder = Earlysalary::where('orderid', $request->orderid)->first();
            if(empty($esorder)){

              $data = Earlysalary::create(
                [
                  'orderid' =>$request->orderid ,
                   'customerid' => $ordersave['customerId'],
                    'customerRefId' => $ordersave['customerRefId'],
                    
                   'orderamount' => $request->price,
                   'username' => $request->username,
                   'userid' => $request->user_id,
                   'mobile_number' => $request->mobile,
                   'product_name' => $request->course,
                   'email'  => $request->email,
                   'cart_id'  => $request->cart_id

                ]
              ); 

            }
            else{
              $data = Earlysalary::where('orderid',$request->orderid)->update(
                [
                    
                  'customerid' => $ordersave['customerId'],
                   'customerRefId' => $ordersave['customerRefId'],
                  
                  'orderamount' => $request->price,
                  'username' => $request->username,
                  'userid' => $request->user_id,
                  'mobile_number' => $request->mobile,
                   'product_name' => $request->course,
                   'email'  => $request->email,
                   'cart_id'  => $request->cart_id,


                ]
              );
            }
            $esorderid = Earlysalary::where('orderid', $request->orderid)->first();

              return view('esportal', compact('esorderid'));
          
          }
          
          else{
            Session::flash('delete','Please enter mobile number in profile !');

            return redirect('/all/cart');
          }
        }    
        else{
            Session::flash('delete','Something went wrong, Please try again !');
            return redirect('/all/cart');
        }
        
    }

    public function esgetcheck(Request $request){
     // dd($request);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.earlysalary.com/prod/esapi/generateToken",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n\"username\": \"NIHAWSUser\",\n    \"password\": \"NI#@WS@123\"\n, \n    \"applicationName\": \"APP\"\n}",
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json"
        ),
      ));


    
      $response = curl_exec($curl);
      curl_close($curl);

      
      $tokenresponse = json_decode($response);
      $token = $tokenresponse->{'token'};


      $data = Earlysalary::where('orderid',$request->orderid)->first();
     // dd($data);

      $userdata =[
        
          "customerRefId"=> $data->customerRefId,
          "applicationNo"=>  $request->orderid
         
      ];

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.earlysalary.com/checkout-merchant-prod/merchantapi/get-checkout-status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($userdata),
    
      
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
           "Authorization:".$token
        ),
      ));

      $statusresponse = curl_exec($curl);
      curl_close($curl);

      
      $statresponse = json_decode($statusresponse, true);
     // print_r($statresponse);die;
      Earlysalary::where('orderid',$request->orderid)->update([
        'status' => $statresponse['esStatus']
      ]);

      if($statresponse['esStatus'] == 'ES_DISBURSED'){


        
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
	            'transaction_id' => $data->customerid,
	            'payment_method' => 'EMI',
	            'total_amount' => $pay_amount,
	            'offline_tutor' => $cart->offline_tutor,
                'online_tutor_one' => $cart->online_tutor_one,
                'online_tutor_two' => $cart->online_tutor_two,
                'hard_course' => $cart->hard_course,
                'no_hours' => $cart->no_hours,
                'no_hours_off' => $cart->no_hours_off,
	            'coupon_discount' => $cpn_discount,
	            'currency' => 'INR',
	            'currency_icon' => 'fa fa-inr',
	            'status' => 0,
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
							$order = $created_order;
						/*sending email*/
						 if($cart->workshop_id != Null){
          					$x = 'You are successfully enrolled in '.$created_order->workshops->title;
						 }
						 else{
     						$x = 'You are successfully enrolled in '.$created_order->courses->title;
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
        \Session::flash('success', 'Payment success');
		    return redirect()->route('thankyou');

      }
      else{
        \Session::flash('delete', 'Please complete EMI Procedure');
        return redirect('/');

      }

     

    }
    
  
   
    
    
public function emistatus(Request $request){
        
      
 Storage::disk('local')->put('_'.time().'_'.'emiini.txt', 'check');

            
 $json = $request->getContent();
 $emistatus = json_decode($json, true);
 
 
if(!empty($emistatus)){
 Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'emi.txt', $json);
 
    
     
      $this->saveemi($emistatus);

         $this->saveorder($emistatus);

}   
        
         $status = array(
        'status' => 200,
        'message' => "success"
        );
        
        $response = json_encode($status);
      
        return $response;
       
     


    }
    
    public function saveemi($emistatus){
        
         Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveemi.txt', $emistatus['order_id']);

        
        $esorder = Earlysalary::where('orderid', $emistatus['order_id'])->first();
        

           if(isset($esorder)){

              $data = Earlysalary::where('orderid',$emistatus['order_id'])->update(
                [
                  'order_id' =>$emistatus['order_id'] ,
                   'amount' => $emistatus['amount'],
                   'user_mobile' => $emistatus['user_mobile'],
                   'description' => $emistatus['description'],
                   'status'=>$emistatus['status'],
                   'created_on'=>$emistatus['created_on']
                ]
              );
           }
           else{
                $data = Earlysalary::create(
                [
                  'order_id' =>$emistatus['order_id'] ,
                   'amount' => $emistatus['amount'],
                   'user_mobile' => $emistatus['user_mobile'],
                   'description' => $emistatus['description'],
                   'status'=>$emistatus['status'],
                   'created_on'=>$emistatus['created_on']
                ]
              );
           }
                

            
           Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveemiend.txt', $data);

    }
    
    public function saveorder($emistatus){
            Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveorder.txt', $emistatus['status']);

          
             if($emistatus['status'] == 'DISBURSED'){
                 
                  $ordergen = Earlysalary::where('order_id', $emistatus['order_id'])->first();

                 Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveorderinif.txt', $ordergen);
        
       

		$cart = Cart::where('id',$ordergen->cart_id)->first();

		if(isset($cart)){ 		
	   	 $orderlist = Order::where('order_id',$ordergen->order_id)->first();
	   	 
	   	  if(empty($orderlist)){
             $created_order = Order::create([
	        	'course_id' => $cart->course_id,
	        	'workshop_id' => $cart->workshop_id,
	        	'user_id' => $cart->user_id,
	        	'instructor_id' => Null,
	        	'order_id' => $emistatus['order_id'],
	            'transaction_id' => str_random(32),
	            'payment_method' => 'EMI',
	            'total_amount' => $ordergen->orderamount,
	            'offline_tutor' => $cart->offline_tutor,
                'online_tutor_one' => $cart->online_tutor_one,
                'online_tutor_two' => $cart->online_tutor_two,
                'hard_course' => $cart->hard_course,
                'no_hours' => $cart->no_hours,
                'no_hours_off' => $cart->no_hours_off,
	            'coupon_discount' => $cart->disamount,
	            'currency' => 'INR',
	            'currency_icon' => 'fa fa-inr',
	            'duration' => Null,
	            'enroll_start' => $ordergen->created_on,
                'enroll_expire' => Null,
                'bundle_id' => $cart->bundle_id,
                'bundle_course_id' => Null,
	            'created_at'  => $ordergen->created_on,
	            ]
	        );
	   	  }
		  
	   	  
	        		 Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveorderaft.txt', $created_order);


	        Wishlist::where('user_id',$cart->user_id)->where('course_id', $cart->course_id)->delete();

	        Cart::where('id',$ordergen->cart_id)->delete();
		}     

	        if(isset($created_order)){
	        
						
						/*sending email*/
						
						  if($created_order->workshop_id != Null){
          				        $x = 'You are successfully enrolled in '.$created_order->workshops->title;
						    }
						    elseif($created_order->course_id != Null){
      					     	$x = 'You are successfully enrolled in '.$created_order->courses->title;
						   }
						   else{
     					    	$x = 'You are successfully enrolled in '.$created_order->bundle->title;
						   }
						
						$order = $created_order;
						Mail::to($ordergen->email)->send(new SendOrderMail($x, $order));
                       Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'completed.txt', $created_order);

				
			}

          		 Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveorderend.txt', $emistatus);

		


      }
            
            else{
                 Storage::disk('local')->put($emistatus['user_mobile'].'_'.time().'_'.'saveorderelse.txt', $emistatus['status']);
            }
   
        
    }
    
    
   

    
}
