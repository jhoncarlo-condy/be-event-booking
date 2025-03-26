<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\RegisterController;
use App\Http\Controllers\User\UserController;

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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);

    Route::resource('/event', EventController::class);

    //user
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{email}', [UserController::class, 'show']);
    Route::put('/update/{email}', [UserController::class, 'update']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
});
