<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'users'
], function ($router) {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show'])->missing(function () {
        return response(['message' => 'User not found'], 404);
    });
    Route::put('/{user}', [UserController::class, 'update'])->missing(function () {
        return response(['message' => 'User not found'], 404);
    });
    Route::delete('/{user}', [UserController::class, 'destroy'])->missing(function () {
        return response(['message' => 'User not found'], 404);
    });
});