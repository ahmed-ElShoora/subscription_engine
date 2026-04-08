<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('subscription:check-end-trail-task')]
#[Description('Check if any user trial has been ended and update their status to canceled')]
class CheckEndTrailTask extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNotNull('subscription_ends_at')
        ->where('subscription_ends_at', '<', now())
        ->get();

        foreach ($users as $user) {
            $user->update([
                'status' => 'canceled',
                'subscription_ends_at' => null,
                'plan_id' => null
            ]);
        }
    }
}
