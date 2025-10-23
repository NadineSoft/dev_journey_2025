<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyBirthdaysMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $name,
        public $birthdays,
    )
    {
    }

    public function build()
    {
        return $this->subject('🎂 Birthdays this week')
            ->markdown('mail.weekly_birthdays', [
                'userName' => $this->name,
                'items'    => $this->birthdays,
            ]);
    }

}
