<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DonationReceived extends Notification
{
    use Queueable;

    protected $donation;
    protected $donor;

    public function __construct($donation, $donor = null)
    {
        $this->donation = $donation;
        $this->donor = $donor;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $amountDisplay = $this->donation->type === 'Money' 
            ? '₱' . number_format($this->donation->amount, 2)
            : $this->donation->type;

        return [
            'type' => 'donation',
            'donor_name' => $this->donor->name ?? 'Anonymous Donor',
            'donor_id' => $this->donor->id ?? null,
            'amount' => $this->donation->amount,
            'amount_display' => $amountDisplay,
            'donation_type' => $this->donation->type,
            'donation_id' => $this->donation->id,
            'created_at' => $this->donation->created_at
        ];
    }
}