<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Currency;
use DB;

class DailyQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

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
 
 
 
        \Log::info("Cron is working fine!");
       
    }
}
