<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Currency;
use Session;

class TabController extends Controller
{
    public function show($id){
    	 $cate = $id;
    	 // $clientIP = request()->ip();
      //    $countryip = \Location::get($clientIP);
      //    $userip = $countryip->countryCode;
      //    $counname = $countryip->countryName;
         
      $currency_value=Session::get('currency_value');
   
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }



       
    	return view('tabs',compact('cate','money'));
    }
}
