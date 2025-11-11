<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
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
        return ['database']; // ONLY database for now
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
}