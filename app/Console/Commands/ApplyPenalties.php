<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Penalty;
use App\Mail\PenaltyNotificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ApplyPenalties extends Command
{
    protected $signature = 'penalties:apply';
    protected $description = 'Apply penalties to users who missed donations for 3 days and send email notifications';

    public function handle()
    {
        $this->info('Running penalty job...');

        $users = User::where('role', '!=', 'admin')->get();

        foreach ($users as $user) {
            $lastDonation = $user->last_donation_date
                ? Carbon::parse($user->last_donation_date)
                : null;

            if (!$lastDonation || $lastDonation->diffInDays(now()) > 3) {
                $recentPenalty = Penalty::where('user_id', $user->id)
                    ->whereDate('created_at', '>=', now()->subDays(3))
                    ->first();

                if (!$recentPenalty) {
                    $penalty = Penalty::create([
                        'user_id' => $user->id,
                        'amount' => 50.00,
                        'reason' => 'Missed donation within 3 days',
                        'applied_at' => now(),
                    ]);

                    Mail::to($user->email)->queue(new PenaltyNotificationMail($penalty));

                    $this->info("Penalty applied to {$user->email}");
                }
            }
        }

        $this->info('Penalty job completed.');
    }
}
