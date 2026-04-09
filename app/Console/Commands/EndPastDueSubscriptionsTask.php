<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('subscription:end-past-due-subscriptions-task')]
#[Description('Check if any user subscription has been past due')]
class EndPastDueSubscriptionsTask extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::whereNotNull('subscription_ends_at')
            ->where('subscription_ends_at', '<', now())
            ->where('status', 'past_due')
            ->update([
                'status' => 'canceled',
                'subscription_ends_at' => null,
                'plan_id' => null,
            ]);
    }
}
