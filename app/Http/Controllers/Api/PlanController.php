<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Services\Plans\PlanService;
use App\Http\Requests\PlanCurrencyRequest;

class PlanController extends Controller
{
    use ApiResponse;
    public function __construct() {
        $this->planService = new PlanService();
    }
    public function __invoke(PlanCurrencyRequest $request)
    {
        $plans = $this->planService->getAllPlans(strtoupper($request->query('currency', 'USD')));
        return $this->successResponse($plans,'Plans retrieved successfully');
    }
}
