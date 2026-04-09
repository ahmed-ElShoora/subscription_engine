<?php

namespace App\Services\Purchase;
use Illuminate\Support\Facades\Http;
use App\Models\Plan;
use App\Models\User;

class PurchaseService
{
    //check if user want to start trial or buy plan now
    public function process(User $user, array $data): array
    {
        if($data['type'] == 'trial'){
            return $this->startTrial($user,$data);
        }
        return $this->purchasePlan($user,$data);
    }
    //if user want start trial
    private function startTrial(User $user, array $data)
    {
        if ($user->status !== 'new') {
            return [
                'status' => false,
                'message' => 'You already used trial or used active subscription',
                'code' => 409
            ];
        }

        $plan = Plan::findOrFail($data['plan_id']);

        $user->update([
            'status' => 'trial',
            'subscription_ends_at' => now()->addDays($plan->trial_days),
            'plan_id' => $plan->id
        ]);

        return [
            'status' => true,
            'message' => 'Trial started successfully',
            'data' => $user
        ];
    }
    //if user want buy plan
    private function purchasePlan(User $user, array $data): array
    {
        $plan = Plan::findOrFail($data['plan_id']);

        $price = $data['time'] === 'month' ? $plan->month_price : $plan->year_price;

        $amount = convert_currency($price,$plan->currency,$data['currency']);

        $payment = $this->pay($user->id, $data, $amount);

        if (! $payment) {
            return [
                'status' => false,
                'message' => 'Payment failed',
                'code' => 402
            ];
        }

        $days = $data['time'] === 'month' ? 30 : 365;

        $user->update([
            'status' => 'active',
            'subscription_ends_at' => now()->addDays($days),
            'plan_id' => $plan->id
        ]);

        return [
            'status' => true,
            'message' => 'Plan purchased successfully',
            'data' => $user
        ];
    }

    //pay to payment gateway [Simulate payment for try]
    public function pay($user_id,$data,$amount)
    {
        $response = Http::post(env('APP_URL_TEST_PAYMENT').'/api/v1/payment-simulator', [
            'user_id' => $user_id,
            'amount' => $amount,
            'currency' => $data['currency'],
            'card_number' => $data['card_number'],
            'expiry_month' => $data['expiry_month'],
            'expiry_year' => $data['expiry_year'],
            'cvv' => $data['cvv'],
        ]);
        return $response->successful() && $response->json('status') === true;
    }
}