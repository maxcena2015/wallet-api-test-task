<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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


Route::get('{walletId}/transactions-on-wallet', [ApiController::class, 'transactionsOnWallet']);
Route::get('{userId}/all-user-transactions', [ApiController::class, 'allUserTransactions']);
Route::post('{walletId}/withdraw', [ApiController::class, 'withdraw']);
Route::post('{walletId}/deposit', [ApiController::class, 'deposit']);
