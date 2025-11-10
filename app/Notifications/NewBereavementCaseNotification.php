<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\BereavementCase;

class NewBereavementCaseNotification extends Notification
{
    use Queueable;

    protected $case;

    public function __construct(BereavementCase $case)
    {
        $this->case = $case;
    }

    // Only database and mail for members
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Email notification for members
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Bereavement Case Added')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new bereavement case has been added.')
            ->line('Member: ' . ($this->case->user->name ?? 'N/A'))
            ->line('Title: ' . $this->case->title)
            ->line('Date of Death: ' . $this->case->date_of_death->format('F j, Y'))
            ->line('Description: ' . $this->case->description)
            ->action('View Case', route('bereavement-cases.show', $this->case->id))
            ->line('Please offer your support if possible.');
    }

    // Database notification
    public function toArray($notifiable)
    {
        return [
            'message'       => 'A new bereavement case was created for ' . ($this->case->user->name ?? 'N/A'),
            'user_name'     => $this->case->user->name ?? 'N/A',
            'title'         => $this->case->title,
            'date_of_death' => $this->case->date_of_death->format('Y-m-d'),
            'description'   => $this->case->description,
            'link'          => route('bereavement-cases.show', $this->case->id),
        ];
    }
}
