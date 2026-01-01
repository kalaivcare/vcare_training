<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Cart;
use App\Course;
use App\Wishlist;
use App\Order;
use Session;
use App\Coupon;
use Illuminate\Support\Facades\App;
use App\Adsense;
use App\Currency;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        
        return view('admin.cart.index', compact('carts'));
    }

    public function destroy($id)
    {
        $cart = Cart::findorfail($id);
        $cart->delete();

        return back()->with('delete','Course is removed from your cart');
    }

    public function addtocart(Request $request)
    {
        

        $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->first();
         // $clientIP = request()->ip();
         // $countryip = \Location::get($clientIP);
         // $userip = $countryip->countryCode;
         // $counname = $countryip->countryName;
          $cartemp = DB::table('orderid')->orderBy('id','desc')->first();
        
        if(empty($cartemp)){
            $orderid ='nih_'.'7563908';
        }
        else{
            $incid = substr($cartemp->orderid,4)+1;
             $orderid ='nih_'.$incid;
        }
     
        DB::table('orderid')->insert([
             'orderid'=>$orderid,
             'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
       
 $currency_value=Session::get('currency_value');
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }
      
        if(!empty($cart)){

            return back()->with('delete','Item is already in your cart');
        }
        else {
            
            DB::table('carts')->insert(
            array(

            'user_id' => Auth::User()->id,
            'course_id' => $request->course_id,
            'workshop_id' => $request->workshop_id,
            'category_id' => $request->category_id,
            'orderid' => $orderid,
            'price' => $request->price,
            'offer_price' => $request->discount_price,
            'currency' => $money->currency,
            'currency_icon' => $money->icon,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            )
        );
        if($request->workshop_id != Null){
           return redirect('all/cart')->with('success','Workshop is added to your cart !');
        }
        else{
           return redirect('all/cart')->with('success','Course is added to your cart !');
        }
        }

    	
    }
    
    public function offline_tutor(Request $request)
    {
        $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->first();
        $course = Course::where('id',$request->course_id)->first();
        
         //  $clientIP = request()->ip();
         // $countryip = \Location::get($clientIP);
         // $userip = $countryip->countryCode;
         // $counname = $countryip->countryName;
         
       
  $currency_value=Session::get('currency_value');
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }
        
        if(isset($cart)){
            Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->update([
                 'offline_tutor' => $request->offline_tutor*$request->no_hours_off,'no_hours_off' => $request->no_hours_off
               
            ]);
        }
        else{
            
        
            
             DB::table('carts')->insert(
            array(

            'user_id' => Auth::User()->id,
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
            'offline_tutor' => $request->offline_tutor*$request->no_hours_off,
            'orderid' => rand(),
            'no_hours_off' => $request->no_hours_off,
            'currency' => $money->currency,
            'currency_icon' => $money->icon,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
            );
        }
        return redirect('all/cart')->with('success','Offline Tutor for '.$request->no_hours_off.' hours for ' . $course->title.' is added to your cart !');
    }
    public function online_tutor_one(Request $request)
    {
        $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->first();
        $course = Course::where('id',$request->course_id)->first();
        if(isset($cart)){

            Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->update([
                'online_tutor_one' => $request->online_tutor_one*$request->no_hours,'no_hours' => $request->no_hours
            ]);     
        }
         else{
             
        // $clientIP = request()->ip();
        //  $countryip = \Location::get($clientIP);
        //  $userip = $countryip->countryCode;
        //  $counname = $countryip->countryName;
         
       
  $currency_value=Session::get('currency_value');
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }
             DB::table('carts')->insert(
            array(

            'user_id' => Auth::User()->id,
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
            'orderid' => rand(),
            'online_tutor_one' => $request->online_tutor_one*$request->no_hours,
            'no_hours' => $request->no_hours,
            'currency' => $money->currency,
            'currency_icon' => $money->icon,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
            );
        }
        return redirect('all/cart')->with('success','Live Tutor for '.$request->no_hours.' hours for '. $course->title.' is added to your cart !');
    }
     public function online_tutor_two(Request $request)
    {
        $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->first();
        $course = Course::where('id',$request->course_id)->first();
        if(isset($cart)){
            Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->update([
                'online_tutor_two' => $request->online_tutor_two
            ]);    
        }
         else{
             DB::table('carts')->insert(
            array(

            'user_id' => Auth::User()->id,
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
            'online_tutor_two' => $request->online_tutor_two,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
            );
        }
        return redirect('all/cart')->with('success','Live Tutor for 3 hour for '. $course->title.' is added to your cart !');
    }
    public function hard_course(Request $request)
    {
        $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->first();
        $course = Course::where('id',$request->course_id)->first();
        if(isset($cart)){
            Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->update([
                'hard_course' => $request->hard_course
            ]);    
        }
         else{
             
        // $clientIP = request()->ip();
        //  $countryip = \Location::get($clientIP);
        //  $userip = $countryip->countryCode;
        //  $counname = $countryip->countryName;
         
       
  $currency_value=Session::get('currency_value');
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }
             DB::table('carts')->insert(
            array(

            'user_id' => Auth::User()->id,
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
            'orderid' => rand(),
            'hard_course' => $request->hard_course,
            'currency' => $money->currency,
            'currency_icon' => $money->icon,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
            );
        }
        return redirect('all/cart')->with('success','Hard copy of course material for '. $course->title.' is added to your cart !');
    }

    public function removefromcart($id)
    {
        $cart = Cart::findorfail($id);
        $cart->delete();

        if($cart->workshop_id != Null){
            return back()->with('delete','Workshop is removed from your cart');
        }
        else{
            return back()->with('delete','Course is removed from your cart');
        }
    }
    public function removeoffline_tutor($id)
    {
        $cart = Cart::findorfail($id);
        $course = Course::where('id', $cart->course_id)->first();
        
        Cart::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->update([
            'offline_tutor' => NULL
        ]);
        
         if ($cart->price ==NULL && $cart->online_tutor_one==NULL && $cart->online_tutor_two ==NULL && $cart->hard_course ==NULL){ 
            $cart->delete();
        }
        return back()->with('delete','Offline Tutor for '.$course->title. ' is removed from your cart');

    }
    public function removeonline_tutor_one($id)
    {
        $cart = Cart::findorfail($id);
        $course = Course::where('id', $cart->course_id)->first();
       
        Cart::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->update([
            'online_tutor_one' => NULL,'no_hours'=>NULL
        ]);
        
         if ($cart->price ==NULL && $cart->offline_tutor==NULL && $cart->online_tutor_two ==NULL && $cart->hard_course ==NULL){ 
            $cart->delete();   
        }
        return back()->with('delete','Live Tutor for '.$cart->no_hours.' hours for '.$course->title. ' is removed from your cart');
    }
      public function removeonline_tutor_two($id)
    {
        $cart = Cart::findorfail($id);
        $course = Course::where('id', $cart->course_id)->first();
        
        Cart::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->update([
            'online_tutor_two' => NULL
        ]);
    // dd($cart);
         if ($cart->price ==null && $cart->offline_tutor==null && $cart->online_tutor_one==null && $cart->hard_course ==null){
            $cart->delete();
        }
        return back()->with('delete','Live Tutor for 3 hours for '.$course->title. ' is removed from your cart');
    }
    public function removehard_course($id)
    {
        $cart = Cart::findorfail($id);
        $course = Course::where('id', $cart->course_id)->first();
        
        Cart::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->update([
            'hard_course' => NULL
        ]);
        
         if ($cart->price ==NULL && $cart->online_tutor_one==NULL && $cart->online_tutor_two ==NULL && $cart->offline_tutor ==NULL){
            $cart->delete();
        }
        return back()->with('delete','Hard copy of course materials for '.$course->title. ' is removed from your cart');
    }
  

    public function cartpage(Request $request)
    {
         //  $clientIP = request()->ip();
         // $countryip = \Location::get($clientIP);
         // $userip = $countryip->countryCode;
         // $counname = $countryip->countryName;
         
       
// $amcurr = Currency::all();
// foreach($amcurr as $exchange){
//   if($userip == $exchange->countrycode ){
//          $money = Currency::where('countrycode',$exchange->countrycode)->first();

//   }
//   else{
//                $money = Currency::where('countrycode','US')->first();

//   }
// }

$currency_value=Session::get('currency_value');
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }

        $coupanapplieds = Session::get('coupanapplied');
        if(empty($coupanapplieds) == true ){
                 
            Cart::where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => NULL, 'disamount' => NULL]);

        }

        $wishlist = Wishlist::all();
        $course = Course::all();
        $carts = Cart::where('user_id', Auth::User()->id)->get();

        $ad = Adsense::first();

       
        
        $cartitems = Cart::where('user_id', Auth::User()->id)->first();
        if ($cartitems == NULL){

            //when cart empty 
            return view('front.cart',compact('course','money', 'carts', 'wishlist', 'ad'));

            
           
        }
        else {

            $price_total = 0;
            $offer_total = 0;
            $cpn_discount = 0;


            //cart price after offer
            foreach ($carts as $key => $c)
            {
                if ($c->offer_price != 0)
                {
                    $offer_total = $offer_total + $c->offer_price;
                }
                else
                {
                    $offer_total = $offer_total + $c->price;
                }
            }

            //for price total
            foreach ($carts as $key => $c)
            {
                
                $price_total = $price_total + $c->price;
                
            }


             //for referral discount total
           
                 $referral = Auth::user()->referrals;
                 if(isset($referral)){
                     
                     foreach($referral as $refer){
                         $order = Order::where('user_id',$refer->id)->get();
                         $i = 0;
                         $usorder = Order::where('user_id',$refer->id)->first();
                         

                         foreach ($carts as $key => $c)
                         {
                         if(count($order)==$i+1){
                            $cpn_discount = $cpn_discount + $c->price*5/100;
                            DB::table('carts')->where('user_id',Auth::user()->id)->update(['disamount'=>$cpn_discount, 'distype'=>'refer']);
                        }
                         elseif(isset($usorder)){
                            $cpn_discount = $cpn_discount + $c->price*5/100;
                            DB::table('carts')->where('user_id',Auth::user()->id)->update(['disamount'=>$cpn_discount, 'distype'=>'refer']);

                         }
                        

                        
                        }
                     }
                 }
                 
                  //for coupon discount total
            foreach ($carts as $key => $c)
            {       

                if($cpn_discount==0){
                    $cpn_discount = $cpn_discount + $c->disamount;  
                }   
                else{
                   
                }    
            }
 

         


            $cart_total = 0;
            
            foreach ($carts as $key => $c)
            {

                if ($cpn_discount != 0)
                {
                    $cart_total = $offer_total - $cpn_discount;
                }
                else{

                     $cart_total = $offer_total;
                }
            }

            //for offer percent
            foreach ($carts as $key => $c)
            {
                if ($cpn_discount != 0)
                {
                  if ($price_total != null) {
                    $offer_amount  = $price_total - ($offer_total - $cpn_discount);
                    $value         =  $offer_amount / $price_total;
                    $offer_percent = $value * 100;
                  }
                   else{
                        $offer_percent = 0;
                    }
                }
                else
                {
                  if ($price_total != null) {
                    $offer_amount  = $price_total - $offer_total;
                    $value         =  $offer_amount / $price_total;
                    $offer_percent = $value * 100; 
                  }
                   else{
                        $offer_percent = 0;
                    }
                }
            }
            $offer_total = $price_total-$offer_total;

             foreach ($carts as $key => $c)
            {
                
                $price_total = $price_total + $c->offline_tutor + $c->online_tutor_one+$c->online_tutor_two + $c->hard_course;
                
            }

        }

        $cart_total = $price_total - $offer_total-$cpn_discount;



        return view('front.cart',compact('course','money', 'carts', 'wishlist','offer_total','price_total', 'offer_percent', 'cart_total', 'cpn_discount', 'ad'));
       
    }
    
      public function cartpagebefore(Request $request){

        $wishlist = Wishlist::all();
        $course = Course::all();
        $carts = Cart::where('user_id', 0)->get();

        $ad = Adsense::first();
    
          return view('front.cartbefore',compact('course', 'carts', 'wishlist', 'ad'));

   
    }
   
    
}
