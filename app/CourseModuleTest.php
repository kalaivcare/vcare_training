<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleTest extends Model
{
    use HasFactory;

    protected $table = 'course_module_tests';
    protected $fillable = [
        'course_id',
        'module_type',
        'title',
        'description',
        'max_attempts',
    ];

    protected $casts = [
        'max_attempts' => 'integer',
    ];

    /**
     * Optional: If you want to track attempts per test for a user
     * Define a relationship to the user attempts table if created
     */
    public function attempts()
    {
        return $this->hasMany(UserModuleTestAttempt::class, 'test_id', 'id');
    }
}
