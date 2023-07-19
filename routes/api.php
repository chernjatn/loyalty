<?php

use App\Http\Controllers\LoyaltyController;
use Illuminate\Support\Facades\Route;

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
    Route::prefix('{loyaltyType}')->group(function () {
        Route::prefix('client')->group(function () {
            Route::prefix('{clientTel}')->group(function () {
                Route::get('', [LoyaltyController::class, 'checkIsCard']);
                Route::get('card', [LoyaltyController::class, 'card']);
                Route::post('card/{cardId}/balance', [LoyaltyController::class, 'balance']);
                Route::post('verify', [LoyaltyController::class, 'verify']);
                Route::post('create', [LoyaltyController::class, 'create']);
            });
        });
    });
});
