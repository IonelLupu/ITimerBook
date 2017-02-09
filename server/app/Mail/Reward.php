<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Reward extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    $address = 'rewards@itimerbook.io';
	    $name = 'ITimerBook Team';
	    $subject = 'Competition Reward';

	    return $this->view('emails.reward')
		    ->from($address, $name)
		    ->cc($address, $name)
		    ->bcc($address, $name)
		    ->replyTo($address, $name)
		    ->subject($subject);
    }
}
