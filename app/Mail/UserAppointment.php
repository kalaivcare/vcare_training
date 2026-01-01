<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAppointment extends Mailable
{
    use Queueable, SerializesModels;
    public $x, $data, $user, $maincourse;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($x, $data, $user, $maincourse)
    {
        $this->x = $x;
        $this->data = $data;
        $this->user = $user;
        $this->maincourse =$maincourse;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.userAppointment')->subject('Response for Appointment');
    }
}
