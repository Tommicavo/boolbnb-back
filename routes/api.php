<?php

use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\EstateController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

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

Route::get('/users', [UserController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/services/filter', [EstateController::class, 'filter']);

// Messages
Route::post('/messages', [MessageController::class, 'store']);

// All API Estate Route
Route::apiResource('estates', EstateController::class);


Route::get('estates/filter-by-title/{query}', [EstateController::class, 'filterByTitle']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
