<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\DeathReport;

class DuplicateDeathReportNotification extends Notification
{
    use Queueable;

    protected $report;

    public function __construct(DeathReport $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database']; // stored in notifications table
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "⚠️ The person '{$this->report->name_of_deceased}' has been reported more than once.",
            'report_id' => $this->report->id,
            'reporter' => $this->report->user->name ?? 'Unknown Reporter',
            'link' => route('death-reports.show', $this->report->id),
        ];
    }
}
