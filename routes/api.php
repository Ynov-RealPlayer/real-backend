<?php

use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('me');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::apiResource("users", UserController::class)->middleware('auth:sanctum');

Route::group(['prefix' => 'media', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MediaController::class, 'index']);
    Route::get('/{media}', [MediaController::class, 'show']);
    Route::post('/', [MediaController::class, 'store']);
    Route::put('/{media}', [MediaController::class, 'update']);
    Route::delete('/{media}', [MediaController::class, 'destroy']);
});
