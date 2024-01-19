<?php

use App\Http\Controllers\Transaction\GetPharmacyActivePointsController;
use App\Http\Controllers\Transaction\GetPharmacyPointsToUserController;
use App\Http\Controllers\Transaction\GivePointsController;
use App\Http\Controllers\User\GetUserBalanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/{userId}/balance', [GetUserBalanceController::class, 'getBalance']);
Route::get('/transactions/pharmacy/{pharmacyId}/{startDay}/{endDay}', [GetPharmacyActivePointsController::class, 'getActivePoints']);
Route::get('/transactions/pharmacy/{pharmacyId}/user/{userId}', [GetPharmacyPointsToUserController::class, 'getPointsGivenToUser']);
Route::post('/transactions/{transactionId}/pharmacy/{pharmacyId}/user/{$userId}/give?={points}', [GivePointsController::class, 'givePointsTransaction']);
