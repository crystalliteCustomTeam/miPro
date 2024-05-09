<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasicController;

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


Route::get('/fetchStripe/transaction',[BasicController::class,'fetchRecord']);

Route::get('/fetch-projects', [BasicController::class, 'fetchprojects']);
Route::get('/fetch-projectdata', [BasicController::class, 'fetchprojectdata']);

Route::get('/fetch-username', [BasicController::class, 'ajax_username']);

Route::get('/fetch-paymentdata', [BasicController::class, 'fetchPaymentdata']);
