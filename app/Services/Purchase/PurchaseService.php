<?php

namespace App\Services\Purchase;
use Illuminate\Support\Facades\Http;
use App\Models\Plan;

class PurchaseService
{
    //check if user want to start trial or buy plan now
    public function proccesPurchase(array $data)
    {
        if($data['type'] == 'trial'){
            return $this->startTrial($data);
        }
        return $this->purchasePlan($data);
    }
    //if user want start trial
    public function startTrial(array $data)
    {
        //check if user already start trial before
        if(auth()->user()->status != 'new'){
            return [
                'status' => false,
                'message' => 'You have already started your trial before or you have an active,cancelled subscription'
            ];
        }
        //if not start trial before give him access to trial plan for X days
        $days_count = Plan::find($data['plan_id'])->trial_days;
        auth()->user()->update([
            'status' => 'trial',
            'subscription_ends_at' => now()->addDays($days_count),
            'plan_id' => $data['plan_id']
        ]);
        return [
            'status' => true,
            'message' => 'You have started your trial successfully',
            'data' => auth()->user()
        ];
    }
    //if user want buy plan
    // public function purchasePlan(array $data)
    // {
    //     $paymentResponse = $this->pay($data);
    //     if ($paymentResponse) {
    //         return true;
    //     }
    //     return false;
    // }

    // public function pay(array $data)
    // {
    //     $response = Http::post(env('APP_URL').'/api/v1/payment-simulator', [
    //         'amount' => $data['amount'],
    //         'currency' => $data['currency'],
    //         'card_number' => $data['card_number'],
    //         'expiry_month' => $data['expiry_month'],
    //         'expiry_year' => $data['expiry_year'],
    //         'cvv' => $data['cvv'],
    //     ]);
    //     if ($response->json('status') == 200) {
    //         return $response->json('data');
    //     } 
    //     return false;
    // }
}