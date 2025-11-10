<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;
use App\Models\MonthlyFund;

class MonthlyFundPaidNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $fund;

    public function __construct(User $user, MonthlyFund $fund)
    {
        $this->user = $user;
        $this->fund = $fund;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_name' => $this->user->name,
             'message' => "{$this->user->name} has submitted a ₱{$this->fund->amount} payment for " .
                     \Carbon\Carbon::parse($this->fund->month_year)->format('F Y') . ".",
            'title' => 'Monthly Fund Payment Submitted',
            'amount' => $this->fund->amount,
            'month' => $this->fund->month_year,
            'proof_link' => asset('storage/' . $this->fund->proof_of_payment),
        ];
    }
}
