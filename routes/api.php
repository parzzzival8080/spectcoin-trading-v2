<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BinanceAPIController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDepositController;
use App\Http\Controllers\ClientWalletController;
use App\Http\Controllers\ClientWithdrawController;
use App\Http\Controllers\CoinChartDataController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\CoinPairController;
use App\Http\Controllers\FutureController;
use App\Http\Controllers\FutureTransferController;
use App\Http\Controllers\FutureWalletController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Models\ClientWithdraw;
use Illuminate\Http\Request;
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

Route::group(['middleware' => 'forceJsonResponse'], function () {

    Route::group(['prefix' => 'v1'], function() {
        Route::get('top-list', [BinanceAPIController::class, 'topTenList']);
        Route::get('getOrder', [BinanceAPIController::class, 'getOrder']);

        Route::post('/login', [AuthController::class, 'login']);
        // Route::post('/login', 'AuthController@login');
        // Route::post('/register', 'OccupantController@store');

        // Route::get('/verification', [VerificationController::class, 'verifyContactNumber']);
        Route::get('/verification', [VerificationController::class, 'verifyContactNumber']);
        // Route::put('/forgot-password', 'VerificationController@sendCodeToContactNumber');
        // Route::put('/forgot-password/verify-code', 'VerificationController@verifyForgotPasswordCode');
        // Route::put('/forgot-password/change-password', 'VerificationController@forgotPasswordChangePassword');

        Route::group(['middleware' => 'auth:api'], function() {

            Route::post('/logout', [AuthController::class, 'logout']);

            Route::get('/user', function() { return request()->user(); });
            Route::put('/user/change-password', [UserController::class, 'changePassword']);
            

            // Route::apiResource();
            Route::get('wallet-balance', [ClientWalletController::class, 'getWalletBalance']);
            Route::get('future/wallet-balance', [FutureWalletController::class, 'getWalletBalance']);
            Route::get('offline-deposit-audit', [ClientDepositController::class,'depositAudit']);
            Route::get('offline-deposit-record', [ClientDepositController::class,'depositRecord']);
            Route::get('currency-transfer-review', [ClientDepositController::class ,'depositRecord']);
            Route::apiResource('clients', ClientController::class);
            Route::apiResource('coins', CoinController::class);
            Route::apiResource('deposits', ClientController::class);
            Route::apiResource('withdrawals', ClientWithdrawController::class);
            Route::apiResource('wallets/spot', ClientWalletController::class);
            Route::apiResource('chart', CoinChartDataController::class);
            Route::apiResource('coinpairs', CoinPairController::class);
            Route::get('latest-candle', [CoinPairController::class, 'latestCandle']);
            Route::get('latest-candle/update', [CoinPairController::class,'updateCandle']);
            Route::post('latest-candle/add', [CoinPairController::class, 'addChartData']);
            Route::apiResource('order', OrderController::class);
            

            Route::apiResource('transfers', FutureTransferController::class);
            Route::post('futures/transfer', [FutureTransferController::class, 'transfer']);
            Route::post('update/transfers', [FutureTransferController::class, 'updateTransfer']);
            Route::apiResource('wallets/future', FutureWalletController::class);

            Route::get('ongoing/future', [FutureController::class, 'updateFuture']);

            Route::apiResource('futures/order', FutureController::class);

            Route::get('margin', [FutureController::class, 'margin']);

           Route::get('future-records', [FutureController::class, 'index']); 
           
            /** For API */
            

        }
    );

    });

    
});
