<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StaffAssignmentNotification extends Notification
{
    use Queueable;

    protected $case;
    protected $jobType;

    public function __construct($case, $jobType)
    {
        $this->case = $case;
        $this->jobType = $jobType;
    }

    public function via($notifiable)
    {
        return ['database']; // only in-app
    }

    public function toArray($notifiable)
    {
        return [
            'message'    => "You have a new task as {$this->jobType} in bereavement case: {$this->case->title}.",
            'case_id'    => $this->case->id,
            'case_title' => $this->case->title,
            'job_type'   => $this->jobType,
        ];
    }
}
