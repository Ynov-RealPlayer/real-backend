<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ResourceOwner;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\CommentaryController;

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

// ! Api routes for AuthController::class
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('me');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

// ! Api routes for UserController::class
Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/top', [UserController::class, 'top']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
});

// ! Api routes for MediaController::class
Route::group(['prefix' => 'media', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MediaController::class, 'index']);
    Route::get('/{media}', [MediaController::class, 'show']);
    Route::post('/', [MediaController::class, 'store']);
    Route::put('/{media}', [MediaController::class, 'update']);
    Route::delete('/{media}', [MediaController::class, 'destroy']);
    Route::get('/category/{category}', [MediaController::class, 'category']);
});

// ! Api routes for CommentaryController::class
Route::group(['prefix' => 'commentaries', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CommentaryController::class, 'index']);
    Route::get('/{commentary}', [CommentaryController::class, 'show']);
    Route::post('/', [CommentaryController::class, 'store']);
    Route::put('/{commentary}', [CommentaryController::class, 'update']);
    Route::delete('/{commentary}', [CommentaryController::class, 'destroy']);
});

// ! Api routes for CategoryController::class
Route::group(['prefix' => 'categories', 'middleware' => 'auth:sanctum'], function () {
// ? The index method is for getting all categories at the launch of the app
    Route::get('/', [CategoryController::class, 'index']);
});

// ! Api routes for LikeController::class
Route::group(['prefix' => 'likes', 'middleware' => 'auth:sanctum'], function () {
// ? The store method is for liking a media/commentary or unliking it automatically
    Route::post('/', [LikeController::class, 'store']);
});
