<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\BereavementCase;

class JobAssignmentNotification extends Notification
{
    use Queueable;

    protected $case;
    protected $jobType;

    public function __construct(BereavementCase $case, $jobType)
    {
        $this->case = $case;
        $this->jobType = $jobType;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Add mail channel
    }

    public function toArray($notifiable)
    {
        return [
            'message'    => "You have a new {$this->jobType} assignment for bereavement case: {$this->case->title}",
            'case_id'    => $this->case->id,
            'case_title' => $this->case->title,
            'job_type'   => $this->jobType,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("New {$this->jobType} Assignment")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("You have been assigned a new {$this->jobType} task for the bereavement case: \"{$this->case->title}\".")
                    ->action('View Case', url(route('bereavement-cases.show', $this->case->id)))
                    ->line('Please review the case details and complete the task accordingly.');
    }
}
