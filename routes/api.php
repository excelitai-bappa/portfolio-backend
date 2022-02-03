<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\UserProfileUpdateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth::guard('sanctum')->user();
});

Route::middleware('auth:sanctum')->group(function () {
     
    // Profile Update route
    Route::post('/user/profile/update/{id}', [UserProfileUpdateController::class, 'profile_update']);
    Route::post('/user/logout', [AuthController::class, 'logout']);
    Route::get('/user/profile', [AuthController::class, 'show']);

    
    //  Header Route
    Route::post('/slider/create', [SliderController::class, 'store']);
    Route::post('/slider/update/{id}', [SliderController::class, 'update']);
    Route::post('/slider/delete/{id}', [SliderController::class, 'destroy']);


});

//Login & Registration Route
Route::get('/user/login', function(){
    return response()->json([
        'error' => 'Please Log In First..!!',
    ], 422);
})->name('login');

Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/registration', [AuthController::class, 'registration']);


//Registration Route
//Route::post('/user/registration', [UserRegistrationController::class, 'registration']);



