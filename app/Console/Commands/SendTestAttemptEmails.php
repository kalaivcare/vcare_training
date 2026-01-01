<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserTestAtempt;
use App\Models\Course;
use App\Mail\TestAttemptMail;
use Illuminate\Support\Facades\Mail;

class SendTestAttemptEmails extends Command
{
    protected $signature = 'emails:send-test-attempts';
    protected $description = 'Send scheduled test attempt emails';

    public function handle()
    {
        $attempts = UserTestAtempt::where('fail_mail', 1)->get();

        foreach ($attempts as $attempt) {

            $user   = $attempt->user;
            $course = Course::find($attempt->course_id);
            $type   = $attempt->module_type;

            Mail::to($user->email)
                ->cc(['test@gmail.com'])
                ->send(
                    new TestAttemptMail(
                        $user,        // user
                        $course,      // course
                        $type,        // module type
                        $attempt      // test attempt
                    )
                );

            $this->info("Fail email sent for attempt ID: {$attempt->id}");

            // prevent duplicate mails
            $attempt->fail_mail = 0;
            $attempt->save();
        }
    }
}
