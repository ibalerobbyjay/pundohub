<?php

namespace App\Notifications;

use App\Models\DeathReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

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
        return ['database']; // can also use SMS or others
    }

    public function toMail($notifiable)
    {
        // Convert string date to Carbon for formatting
        $dateOfDeath = Carbon::parse($this->report->date_of_death);
        
        return (new MailMessage)
                    ->subject('New Death Report')
                    ->line("A new death has been reported by {$this->report->user->name}.")
                    ->line("Deceased: {$this->report->name_of_deceased}")
                    ->line("Date of Death: {$dateOfDeath->format('F j, Y')}")
                    ->line("Cause of Death: {$this->report->cause_of_death}")
                    ->line("Location of Death: {$this->report->location_of_death}")
                    ->action('Review Report', url('/admin/death-reports'))
                    ->line('Please review and add a bereavement case.');
    }

    public function toDatabase($notifiable)
    {
        // Convert string date to Carbon for formatting
        $dateOfDeath = Carbon::parse($this->report->date_of_death);
        
        // Combine cause of death with other_cause if applicable
        $causeDisplay = $this->report->cause_of_death;
        if ($this->report->cause_of_death === 'Other' && $this->report->other_cause) {
            $causeDisplay = $this->report->other_cause;
        }

        return [
            'report_id' => $this->report->id,
            'reporter_name' => $this->report->user ? $this->report->user->name : 'Unknown',
            'deceased_name' => $this->report->name_of_deceased,
            'date_of_death' => $dateOfDeath->format('Y-m-d'),
            'date_of_death_display' => $dateOfDeath->format('F j, Y'),
            'cause_of_death' => $causeDisplay,
            'location_of_death' => $this->report->location_of_death,
            'message' => "New death report: {$this->report->name_of_deceased} - " . 
                         $causeDisplay . " at {$this->report->location_of_death}",
        ];
    }
}