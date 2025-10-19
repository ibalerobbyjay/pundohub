<?php

namespace App\Notifications;

use App\Models\DeathReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DeathReportedNotification extends Notification
{
    use Queueable;

    protected $report;

    public function __construct(DeathReport $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // can also use SMS or others
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Death Report')
                    ->line("A new death has been reported by {$this->report->user->name}.")
                    ->line("Deceased: {$this->report->name_of_deceased}")
                    ->action('Review Report', url('/admin/death-reports'))
                    ->line('Please review and add a bereavement case.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'reporter_name' => $this->report->user->name,
            'deceased_name' => $this->report->name_of_deceased,
        ];
    }
}

