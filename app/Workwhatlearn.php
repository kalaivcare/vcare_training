<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workwhatlearn extends Model
{
    protected $fillable = [
		'workshop_id', 'detail', 'status' 
  	]; 

    public function workshop()
    {
    	return $this->belongsTo('App\Workshop','workshop_id','id');
    }
}
