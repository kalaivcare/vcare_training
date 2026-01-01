<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Storage;
use DB;
use App\Order;
use App\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOrderMail;


class TestController extends Controller
{
    
   public function test()
   {
   	 return view('front.instructor');
   }
   
   
   public function razorweb(){
       
       
       
       $client = new \GuzzleHttp\Client();
$res = $client->get('');
return $res;
       
       Storage::disk('local')->put('filename.txt', 'File content goes here check..');
            //   Storage::append('/home/jl2y6vbzibu0/public_html/nihaws.com/razorpay.txt','suhaina');
                           $che =   Storage::get('filename.txt');
                           return $che;


   }
   
       public function index(Request $request){


           
                //   $api = new Api('rzp_test_drEYKKn4b769KE', 'cqng4QIQCUaoGMHDUesSOMMr');

       $api = new Api('rzp_live_JecF8FlWyMaAW0','Zs1rEHyiUO1t0LzlFObk3s7O');
      
$json = $request->getContent();
      
$webhookBody = json_decode($json,true);
$webhookSecret='nihaws@123';
         Storage::disk('local')->put('_'.time().'jsweblive.txt',$json);

if(isset($webhookBody) && !empty($webhookBody['payload']['payment']['entity']['notes'])){

$contact= $webhookBody['payload']['payment']['entity']['contact'];

 
         Storage::disk('local')->put($contact.'_'.time().'weblivetwo.txt',$json);
         
  if($webhookBody['event'] == 'payment.failed'){
     $notes = $webhookBody['payload']['payment']['entity']['notes'];
     $note2 = $notes['nih_order_id'];
   }
  elseif($webhookBody['event'] == 'order.paid'){
    $notes = $webhookBody['payload']['order']['entity']['notes'];
    $note2 = $notes['nih_order_id'];
  }
  else{
    $notes = $webhookBody['payload']['payment']['entity']['notes'];
    $note2 = $notes['nih_order_id'];
  }    

        $order = DB::table('orderpay')->where('order_id',$webhookBody['payload']['payment']['entity']['order_id'])->first();
     
           if(isset($order)){
               DB::table('orderpay')->where('order_id',$webhookBody['payload']['payment']['entity']['order_id'])->update([
                    'razorkey' => $webhookBody['payload']['payment']['entity']['id'],
                    'order_id' => $webhookBody['payload']['payment']['entity']['order_id'],
                      'email' => $webhookBody['payload']['payment']['entity']['email'],
                    'contact' => $webhookBody['payload']['payment']['entity']['contact'],
                    'amount' => $webhookBody['payload']['payment']['entity']['amount']/100,
                     'status' => $webhookBody['payload']['payment']['entity']['status'],
                    'orderid' => $note2,
                   ]);
           }
           else{
                
                DB::table('orderpay')->insert([
                    'razorkey' => $webhookBody['payload']['payment']['entity']['id'],
                    'order_id' => $webhookBody['payload']['payment']['entity']['order_id'],
                    'email' => $webhookBody['payload']['payment']['entity']['email'],
                    'contact' => $webhookBody['payload']['payment']['entity']['contact'],
                    'amount' => $webhookBody['payload']['payment']['entity']['amount']/100,
                    'currency' => $webhookBody['payload']['payment']['entity']['currency'],
                    'status' => $webhookBody['payload']['payment']['entity']['status'],
                    'method' => $webhookBody['payload']['payment']['entity']['method'],
                    'orderid' => $note2,
                    ]);
                
           }  
       $status =  $webhookBody['payload']['payment']['entity']['status'];    

       if($status == 'captured' || $status == 'authorized'){
            $orderrazor = DB::table('orderpay')->where('orderid',$note2)->get();
           
            Storage::disk('local')->put($note2.'_'.time().'orderrazor.txt',$orderrazor);
          
            foreach($orderrazor as $payorder){
            
            $orderlist = Order::where('order_id',$payorder->order_id)->first();
                        Storage::disk('local')->put($note2.'_'.time().'orderlist.txt',$orderlist);

            if(empty($orderlist)){
            	        
            	   $insord =  Order::create([
            	       
            	       
            	'course_id' => $payorder->course_id,
	        	'workshop_id' => $payorder->workshop_id,
	        	'user_id' => $payorder->user_id,
	        	'instructor_id' => $payorder->instructor_id,
	        	'order_id' => $payorder->order_id,
	            'transaction_id' => $payorder->razorkey,
	            'payment_method' => 'RazorPay',
	            'total_amount' => $payorder->amount,
	            'offline_tutor' => $payorder->offline_tutor,
                'online_tutor_one' => $payorder->online_tutor_one,
                'online_tutor_two' => $payorder->online_tutor_two,
                'hard_course' => $payorder->hard_course,
                'no_hours' => $payorder->no_hours,
                'no_hours_off' => $payorder->no_hours_off,
	            'coupon_discount' => $payorder->coupon_discount,
	            'currency' => $payorder->currency,
	            'currency_icon' => $payorder->currency_icon,
	            'duration' => $payorder->duration,
	            'enroll_start' => $payorder->enroll_start,
                'enroll_expire' => $payorder->enroll_expire,
                'bundle_id' => $payorder->bundle_id,
                'bundle_course_id' => $payorder->bundle_course_id,
	            'created_at'  => $payorder->updated_at,
	            
	           
	            ]
	        );
	        
	        
	      $cart =  Cart::where('id',$payorder->cart_id)->delete();
	        
	        Storage::disk('local')->put($note2.'_'.time().'creatorder.txt',$insord);
	        
	       
				
						if($insord){
						    	$order =$insord;
						     if($insord->workshop_id != Null){
          				        $x = 'You are successfully enrolled in '.$order->workshops->title;
						    }
						    elseif($insord->course_id != Null){
      					     	$x = 'You are successfully enrolled in '.$order->courses->title;
						   }
						   else{
     					    	$x = 'You are successfully enrolled in '.$order->bundle->title;
						   }
						   
						   
						      Storage::disk('local')->put($note2.'_'.time().'mailbefore.txt',$x);

				        		Mail::to($payorder->email)->send(new SendOrderMail($x, $order));
                           Storage::disk('local')->put($note2.'_'.time().'mail.txt','success');
						}
					

            }else{
                Storage::disk('local')->put(time().'orderexist.txt',$orderlist);

            }
            
            }
         

       }
 
}
 
}
   
   
}
