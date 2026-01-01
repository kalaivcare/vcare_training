<?php

namespace App;

use App\CourseChapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function chapters()
    {
        return $this->belongsToMany(CourseChapter::class, 'course_chapter_module');
    }
}
