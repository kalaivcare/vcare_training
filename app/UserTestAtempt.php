<?php

namespace App;

use App\User;
use App\CourseChapter;

use App\Course;

use Illuminate\Database\Eloquent\Model;

class UserTestAtempt extends Model
{
    protected $fillable = ['user_id', 'course_id', 'topic_id', 'chapter_id', 'retest_status', 'fail_mail','module_type', 'attempts'];
    protected $table = 'user_test_attempts';




    public function quizAnswers()
    {
        return $this->hasMany(\App\QuizAnswer::class, 'user_id', 'user_id')
            ->whereColumn('topic_id', 'topic_id');
        // ->whereColumn('chapter_id', 'chapter_id');
    }


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class, 'chapter_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
