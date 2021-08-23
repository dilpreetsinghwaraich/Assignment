<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    UserController
};

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

Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/completeRegisteration', [AuthController::class, 'completeRegisteration']);  
    Route::group([
        'middleware' => ['userToken'],

    ], function ($router) {
        Route::post('/sendRegisterRequest', [AuthController::class, 'register']);  
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user-profile', [UserController::class, 'userProfile']);  
        Route::post('/update-profile', [UserController::class, 'updateProfile']); 
    });
});
