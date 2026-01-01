<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earlysalary extends Model
{
    protected $fillable = [
             'orderid', 'customerid','customerRefId','orderamount','username','userid','mobile_number', 'product_name','status','email','cart_id',
             'user_mobile','description','order_id','amount','created_on',
            
             
    ];
}
