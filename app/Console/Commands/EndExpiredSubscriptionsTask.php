<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\User;

#[Signature('subscription:end-expired-subscriptions-task')]
#[Description('Check if any user subscription has been expired ')]
class EndExpiredSubscriptionsTask extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::whereNotNull('subscription_ends_at')
            ->where('subscription_ends_at', '<', now())
            ->where('status', 'active')
            ->update([
                'status' => 'past_due',
                'subscription_ends_at' => now()->addDays(3),
            ]);
    }
}
