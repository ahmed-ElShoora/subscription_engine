<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Traits\ApiResponse;

class PlanController extends Controller
{
    use ApiResponse;
    public function __invoke()
    {
        $plans = Plan::select('id', 'name', 'month_price', 'year_price', 'trail_days', 'currency')->get();
        return $this->successResponse($plans,'Plans retrieved successfully');
    }
}
