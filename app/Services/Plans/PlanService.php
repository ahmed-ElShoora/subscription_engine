<?php

namespace App\Services\Plans;
use Illuminate\Support\Facades\Http;
use App\Models\Plan;

class PlanService
{
    public function getAllPlans($currency = "USD")
    {

        $plans = Plan::select('id', 'name', 'month_price', 'year_price', 'trial_days', 'currency')->get();
        foreach($plans as $plan){
            $plan->month_price = convert_currency($plan->month_price, $plan->currency, $currency);
            $plan->year_price = convert_currency($plan->year_price, $plan->currency, $currency);
            $plan->currency = $currency;
        }
        return $plans;
    }
}