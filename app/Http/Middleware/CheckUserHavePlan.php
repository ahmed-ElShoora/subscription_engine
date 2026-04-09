<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponse;

class CheckUserHavePlan
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user->status != 'active' || $user->status != 'trial' || $user->status != 'past_due') {
            return $this->errorResponse(
                'You do not have an active plan',
                null,
                403
            );
        }
        return $next($request);
    }
}
