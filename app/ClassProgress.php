<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassProgress extends Model
{
    protected $fillable = [
        'user_id','course_id','chapter_id','class_id','status'
    ];
}
