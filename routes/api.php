<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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


// Login
Route::post('/auth/login', [AuthController::class, 'login']); 

Route::middleware('auth:api')->group(function() {

    // User
    Route::resource('/users', UserController::class); 

    // Posts
    Route::resource('/posts', PostController::class);
    
    // User session
    Route::get('/auth/user', [AuthController::class, 'user']); 

    // Logout
    Route::get('/auth/logout', [AuthController::class, 'logout']); 
}); 