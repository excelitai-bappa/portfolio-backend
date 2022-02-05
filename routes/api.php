<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ProjectCategoryController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\UserProfileUpdateController;
use App\Models\ProjectCategory;
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
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::post('/slider/create', [SliderController::class, 'store']);
    Route::post('/slider/update/{id}', [SliderController::class, 'update']);
    Route::post('/slider/delete/{id}', [SliderController::class, 'destroy']);

    //  Service Route
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/service/create', [ServiceController::class, 'store']);
    Route::post('/service/update/{id}', [ServiceController::class, 'update']);
    Route::post('/service/delete/{id}', [ServiceController::class, 'destroy']);

    //  About Us Route
    Route::post('/about-us/update/{id}', [AboutController::class, 'update']);

    //  Service Route
    Route::get('/skills', [SkillController::class, 'index']);
    Route::post('/skill/create', [SkillController::class, 'store']);
    Route::post('/skill/update/{id}', [SkillController::class, 'update']);
    Route::post('/skill/delete/{id}', [SkillController::class, 'destroy']);

    //  FAQ Route
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::post('/faq/create', [FaqController::class, 'store']);
    Route::post('/faq/update/{id}', [FaqController::class, 'update']);
    Route::post('/faq/delete/{id}', [FaqController::class, 'destroy']);

    //  Team Route
    Route::get('/teams', [TeamController::class, 'index']);
    Route::post('/team/create', [TeamController::class, 'store']);
    Route::post('/team/update/{id}', [TeamController::class, 'update']);
    Route::post('/team/delete/{id}', [TeamController::class, 'destroy']);

    //  Categories Route
    Route::get('/categories', [ProjectCategoryController::class, 'index']);
    Route::post('/categorie/create', [ProjectCategoryController::class, 'store']);
    Route::post('/categorie/update/{id}', [ProjectCategoryController::class, 'update']);
    Route::post('/categorie/delete/{id}', [ProjectCategoryController::class, 'destroy']);

    //  Porjects Route
    Route::get('/porjects', [ProjectController::class, 'index']);
    Route::post('/porject/create', [ProjectController::class, 'store']);
    Route::post('/porject/update/{id}', [ProjectController::class, 'update']);
    Route::post('/porject/delete/{id}', [ProjectController::class, 'destroy']);

    //  Testimonial Route
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/testimonial/create', [TestimonialController::class, 'store']);
    Route::post('/testimonial/update/{id}', [TestimonialController::class, 'update']);
    Route::post('/testimonial/delete/{id}', [TestimonialController::class, 'destroy']);



});

//Login & Registration Route
Route::get('/user/login', function(){
    return response()->json([
        'error' => 'Please Log In First..!!',
    ], 422);
})->name('login');


Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/registration', [AuthController::class, 'registration']);
Route::post('/contact', [ContactController::class, 'store']);


//Registration Route
//Route::post('/user/registration', [UserRegistrationController::class, 'registration']);



