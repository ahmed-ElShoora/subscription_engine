<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\PaymentSimulateRequest;
use App\Services\SimulatePayment\SimulatePaymentService;

class PaymentController extends Controller
{
    use ApiResponse;
    public function __construct(
        private SimulatePaymentService $simulatePaymentService
    ) {}
    /**
     * Handle the incoming request.
     */
    public function __invoke(PaymentSimulateRequest $request)
    {
        $processPayment = $this->simulatePaymentService->processPayment($request->validated());
        if($processPayment['status']){
            return $this->successResponse(
                $processPayment['transaction'],
                'Payment processed successfully'
            );
        }
        return $this->errorResponse(
            'Payment failed',
            null,
            402
        );
    }
}
