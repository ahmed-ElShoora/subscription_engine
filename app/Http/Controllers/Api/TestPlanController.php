<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
class TestPlanController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return $this->successResponse(
            null,
            'You have active plan'
        );
    }
}
