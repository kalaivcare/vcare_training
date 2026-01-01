<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshopinclude extends Model
{
    protected $fillable =[
        'workshop_id', 'detail', 'status','icon'

    ];

    public function workshops()
    {
    	return $this->belongsTo('App\Workshop','workshop_id','id');
    }
}
