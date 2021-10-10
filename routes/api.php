<?php

use App\Http\Controllers\MpesaController;
use App\Http\Controllers\PaymentController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v2/access/token', [MpesaController::class,'generateAccessToken'])->name('token.generate');
Route::post('v2/dashlite/stk/push', [MpesaController::class,'customerMpesaSTKPush']);
Route::post('mpesa/response', [MpesaController::class,'mpesaConfirmation']);
Route::post('v2/dashlite/validation', [MpesaController::class,'mpesaValidation']);
Route::post('v2/dashlite/transaction/confirmation', [MpesaController::class,'mpesaConfirmation']);

