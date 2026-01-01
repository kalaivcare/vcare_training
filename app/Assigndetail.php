<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Assigndetail extends Model
{
    use HasTranslations;

    public $translatable = ['assigndetails'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */

    protected $table = 'assigndetails';

    protected $fillable = [ 'course_id', 'assignment'];

    
}
