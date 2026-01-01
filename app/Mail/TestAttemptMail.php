<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestAttemptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;
    public $type;
    public $testAttempt;

    public function __construct($user, $course, $type, $testAttempt)
    {
        $this->user = $user;
        $this->course = $course;
        $this->type = $type;
        $this->testAttempt = $testAttempt;
    }

    public function build()
    {
       
        return $this
            ->subject($this->course->title)
            ->from(config('mail.from.address'), $this->course->title)
            ->view('mail')
            ->with([
                'user'        => $this->user,
                'course'      => $this->course,
                'type'        => $this->type,
                'testAttempt' => $this->testAttempt,
            ]);
    }
}

