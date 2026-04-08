<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class UserTransactionsController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $transactions = auth()->user()->transactions()->latest()->get();
        return $this->successResponse(
            $transactions,
            'User transactions retrieved successfully'
        );
    }
}
