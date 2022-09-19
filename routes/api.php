<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoyaltyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.api')->group(function () {
    Route::prefix("{loyalty_id}")->group(function () {
        Route::prefix("client")->group(function () {
            Route::post('{clientTel}/verify', [LoyaltyController::class, 'verify']);
            Route::get('{clientTel}/card', [LoyaltyController::class, 'card']);
            Route::get('{clientTel}/card/balance', [LoyaltyController::class, 'balance']);
        });
        Route::resource('client', LoyaltyController::class)->only([
            'store', 'show'
        ]);
    });

});
