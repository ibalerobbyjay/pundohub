<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\DeathReport;

class DuplicateDeathReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $report;
    protected $duplicateCount;
    protected $similarReports;

    public function __construct(DeathReport $report, $similarReports = null)
    {
        $this->report = $report;
        $this->similarReports = $similarReports;
        $this->duplicateCount = $similarReports ? $similarReports->count() : 0;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Add email notification
    }

    public function toDatabase($notifiable)
    {
        $similarNames = [];
        if ($this->similarReports) {
            $similarNames = $this->similarReports->pluck('name_of_deceased')->toArray();
        }

        return [
            'message' => $this->getNotificationMessage(),
            'report_id' => $this->report->id,
            'deceased_name' => $this->report->name_of_deceased,
            'reporter' => $this->report->user->name ?? 'Unknown Reporter',
            'duplicate_count' => $this->duplicateCount,
            'similar_names' => $similarNames,
            'date_of_death' => $this->report->date_of_death->format('M d, Y'),
            'submitted_at' => $this->report->created_at->format('M d, Y H:i'),
            'link' => route('admin.death-reports.show', $this->report->id),
            'admin_link' => route('admin.death-reports.index', ['search' => $this->report->name_of_deceased]),
            'type' => 'duplicate_alert',
            'severity' => $this->duplicateCount > 0 ? 'high' : 'medium',
        ];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject($this->getMailSubject())
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->getNotificationMessage())
            ->line('**Deceased Name:** ' . $this->report->name_of_deceased)
            ->line('**Date of Death:** ' . $this->report->date_of_death->format('F j, Y'))
            ->line('**Submitted By:** ' . ($this->report->user->name ?? 'Unknown User'))
            ->line('**Submitted On:** ' . $this->report->created_at->format('F j, Y g:i A'));

        if ($this->duplicateCount > 0) {
            $mail->line('**Potential Duplicates Found:** ' . $this->duplicateCount);
            
            if ($this->similarReports) {
                $mail->line('**Similar Names in System:**');
                foreach ($this->similarReports->take(5) as $similar) {
                    $mail->line('- ' . $similar->name_of_deceased . ' (Died: ' . $similar->date_of_death->format('M d, Y') . ')');
                }
            }
        }

        $mail->action('Review Death Report', route('admin.death-reports.show', $this->report->id))
            ->line('Please review this report and take appropriate action.')
            ->line('Thank you for using our application!')
            ->salutation('Regards, ' . config('app.name'));

        return $mail;
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->getNotificationMessage(),
            'report_id' => $this->report->id,
            'deceased_name' => $this->report->name_of_deceased,
            'duplicate_count' => $this->duplicateCount,
        ];
    }

    /**
     * Get the notification message based on duplicate count
     */
    private function getNotificationMessage(): string
    {
        if ($this->duplicateCount > 0) {
            return "🚨 Potential duplicate detected: '{$this->report->name_of_deceased}' - {$this->duplicateCount} similar report(s) found in system";
        }

        return "⚠️ New death report submitted for '{$this->report->name_of_deceased}' - Please verify for potential duplicates";
    }

    /**
     * Get the mail subject based on duplicate count
     */
    private function getMailSubject(): string
    {
        if ($this->duplicateCount > 0) {
            return "🚨 Duplicate Death Report Alert: {$this->report->name_of_deceased}";
        }

        return "⚠️ New Death Report Requires Verification: {$this->report->name_of_deceased}";
    }

    /**
     * Determine which queues should be used for each channel.
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'emails',
            'database' => 'database',
        ];
    }

    /**
     * Determine the time to wait before retrying the job.
     */
    public function retryAfter(): int
    {
        return 60; // 1 minute
    }
}