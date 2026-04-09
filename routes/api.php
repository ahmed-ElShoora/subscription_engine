<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\UserTransactionsController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\TestPlanController;
Route::group(['prefix' => 'v1'], function () {

    //user routes [login, register, me, logout]
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    //test use have plan or not
    Route::get('/test-plan', TestPlanController::class)->middleware(['auth:sanctum','check.plan']);
    
    //plans routes [get all plans]
    Route::get('/plans', PlanController::class);

    //simulate payment provider
    Route::post('/payment-simulator', PaymentController::class);

    //user transactions route
    Route::get('/transactions', UserTransactionsController::class)->middleware('auth:sanctum');

    //plans purchase route
    Route::post('/purchase-plan', [PurchaseController::class, 'purchasePlan'])->middleware('auth:sanctum');


});

