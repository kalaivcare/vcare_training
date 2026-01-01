<?php
namespace App\Imports;

use App\Quiz;
use App\QuizTopic;
use App\CourseChapter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuizImport implements ToModel, WithHeadingRow
{
    protected $courseId;
    protected $topicId;

    public function __construct($courseId, $topicId)
    {
        $this->courseId = $courseId;
        $this->topicId = $topicId;
    }

    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);
        $row = array_map('trim', $row);

        return new Quiz([
            'course_id'     => $this->courseId,
            'topic_id'      => $this->topicId, 
            'question'      => $row['question'] ?? null,
            'question_time' => $row['question_time'] ?? null,
            'a'             => $row['a'] ?? null,
            'b'             => $row['b'] ?? null,
            'c'             => $row['c'] ?? null,
            'd'             => $row['d'] ?? null,
            'answer'        => isset($row['answer']) ? strtoupper($row['answer']) : null,
            'answer_exp'    => $row['answer_exp'] ?? null,
        ]);
    }
}

