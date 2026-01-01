<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\CourseChapter;

class QuizTopic extends Model
{
    use HasTranslations;

    protected $table = 'quiz_topics';

    protected $fillable = [
        'course_id',
        'title',
        'coursechapter_id',
        'description',
        'per_q_mark',
        'timer',
        'status',
        'final_assess',
        'quiz_again',
        'due_hours',
        'due_minutes'
    ];

    public $translatable = ['title', 'description'];

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
    public function questions()
    {
        return $this->hasMany(Quiz::class, 'topic_id');
    }

    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class, 'coursechapter_id');
    }
    
}