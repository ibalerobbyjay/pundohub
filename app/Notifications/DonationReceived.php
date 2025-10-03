<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DonationReceived extends Notification
{
    use Queueable;

    protected $donationMessage;

    public function __construct($donationMessage)
    {
        $this->donationMessage = $donationMessage;
    }

    public function via($notifiable)
    {
        return ['database']; // store in notifications table
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->donationMessage
        ];
    }
}
