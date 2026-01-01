<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use Session;
use DB;

class CurrencyController extends Controller
{
     public function index()
    {
        $money = Currency::all();
        return view('admin.currency.index',compact('money'));
    }
    public function store(Request $request)
    {

        $data = $this->validate($request,[
            'icon' => 'required',
            'currency' => 'required',
        ]);


        $input = $request->all();
        $data = Currency::create($input);

       
        $data->save();

        Session::flash('success','Currency Added Successfully !');
        return redirect('currency');
    }
   

    public function edit($id)
    {

    	$show = Currency::find($id);
    	return view('admin.currency.edit',compact('show'));
    }

    public function update(Request $request,$id)
    {

    	$data = Currency::find($id);
        $input = $request->all();

        if(isset($data))
        {
            $data->update($input);
        }
        else
        {
            $data = Currency::create($input);
            $data->save();
        }

		return redirect('currency')->with('success','Updated Successfully');
    }
   public function destroy($id)
    {
        $curr = Currency::find($id);
        $curr->delete();
        return back()->with('success', 'Currency deleted successfully');
    }
    
  public function get_currency(Request $request){
     
      Session::put('currency_value',$request->icon_value);
      return $request->icon_value;
  }
    
   public function eurexchange(){
       
       $access_key = 'dc18df1719719797f8b9efb08cb062c6';
       $ch = curl_init('http://api.exchangeratesapi.io/v1/latest?access_key=dc18df1719719797f8b9efb08cb062c6');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$exchangeRates = json_decode($json, true);



// Access the exchange rate values, e.g. GBP:
 $inr = $exchangeRates['rates']['INR'];
 
 

 
 $money = Currency::all();
 
 foreach($money as $curr_exch){
     $curr_sym = $curr_exch->currency;
     $curr_excsym = $exchangeRates['rates'][$curr_sym];
     
     $curr_cal_amount = number_format($inr/$curr_excsym,2);
     
     Currency::where('currency',$curr_sym)->update(['currency_value'=>$curr_excsym, 'amount'=>$curr_cal_amount]);
     
 }
 
 
 return 'success';
   } 
   
   public function currencySchedule(){
         DB::table('schedule')->insert(['name'=>'suhaina']);
         return 'success';
   }
    
    
    public function exchangefgh(){
        // set API Endpoint and API key
$endpoint = 'latest';
$access_key = 'dc18df1719719797f8b9efb08cb062c6';

// Initialize CURL:
$ch = curl_init('https://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$exchangeRates = json_decode($json, true);

// Access the exchange rate values, e.g. GBP:
return $exchangeRates;
    }
    
    public function convert(){
        $endpoint = 'convert';
$access_key = 'dc18df1719719797f8b9efb08cb062c6';

$from = 'USD';
$to = 'EUR';
$amount = 10;

// initialize CURL:
$ch = curl_init('https://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// get the JSON data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$conversionResult = json_decode($json, true);

// access the conversion result
return $conversionResult;
    }
    
}
