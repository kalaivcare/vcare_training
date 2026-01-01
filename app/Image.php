<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Translatable\HasTranslations;

class Image extends Model
{
	  // use HasTranslations;
   
    
    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
  
    

    protected $table = 'images'; 

    protected $fillable = [

	    'user_id', 'course_id', 'chapter_id', 'image_one','image_two'
	];
}
