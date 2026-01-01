<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable =[
        'title','short_detail','detail',  'price', 'discount_price','price2','discount_price2','video', 'video_url',
         'featured','requirement','url','slug','status','preview_image', 'type', 'preview_type', 'duration',        
    ];

    public function whatlearns()
    {
        return $this->hasMany('App\Workwhatlearn','workshop_id');
    }

    public function include()
    {
        return $this->hasMany('App\Workshopinclude','workshop_id');
    }
}
