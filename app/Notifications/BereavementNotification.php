<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BereavementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $case;

    public function __construct($case)
    {
        $this->case = $case;
    }

    public function via($notifiable)
    {
        return ['mail']; // sends email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Bereavement Case')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new bereavement case has been created.')
                    ->line('Date of Death: ' . $this->case->date_of_death)
                    ->line('Remarks: ' . $this->case->remarks)
                    ->action('View Cases', url('/bereavement-cases'))
                    ->line('Thank you for using PundoHub!');
    }
}
