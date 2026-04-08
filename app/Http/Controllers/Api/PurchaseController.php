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
        $result = $this->purchaseService->proccesPurchase($request->validated());
        if($request->type == "trail"){
            if($result['status']){
                return $this->successResponse(
                    new UserResource($result['data']),
                    $result['message'],
                    201
                );
            }
            return $this->errorResponse(
                $result['message'],
                null,
                400
            );
        }else{
            return $this->errorResponse(
                'For non-trial purchases, please proceed to payment',
                null,
                400
            );
        }
    }
}
