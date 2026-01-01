<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseCompletion extends Model
{
    use HasFactory;

    protected $table = 'course_completions'; 

    protected $fillable = [
        'user_id',
        'completed_courses',
        'e_signature',
        
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
