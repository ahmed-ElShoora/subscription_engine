<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\PurchaseRequest;
use App\Services\Purchase\PurchaseService;
use App\Http\Resources\UserResource;

class PurchaseController extends Controller
{
    use ApiResponse;
    public function __construct() {
        $this->purchaseService = new PurchaseService();
    }
    public function purchasePlan(PurchaseRequest $request)
    {
        $result = $this->purchaseService->process(
            user: $request->user(),
            data: $request->validated()
        );

        if (! $result['status']) {
            return $this->errorResponse(
                $result['message'],
                null,
                $result['code'] ?? 400
            );
        }

        return $this->successResponse(
            new UserResource($result['data']),
            $result['message'],
            201
        );
    }
}
