<?php

namespace App\Mail;

use App\Models\Penalty;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenaltyNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $penalty;

    public function __construct(Penalty $penalty)
    {
        $this->penalty = $penalty;
    }

    public function build()
    {
        return $this->subject('Donation Penalty Notice')
            ->markdown('emails.penalty_notification');
    }
}
