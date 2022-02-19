<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ProjectCategoryController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\SubscribeController;
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

// Frontend Routes

//Login & Registration Route
Route::get('/user/login', function(){
    return response()->json([
        'error' => 'Please Log In First..!!',
    ], 422);
})->name('login');


Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/registration', [AuthController::class, 'registration']);
Route::post('/subscribe', [SubscribeController::class, 'store']);
Route::post('/contact', [ContactController::class, 'store']);



// Backtend Routes

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth::guard('sanctum')->user();
});

Route::middleware('auth:sanctum')->group(function () {
     
    // Profile Update route
    Route::post('/user/logout', [AuthController::class, 'logout']);
    Route::get('/user/profile', [AuthController::class, 'show']);
    Route::post('/user/profile/update/{id}', [AuthController::class, 'update']);

    
    //  Header Route
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::post('/slider/create', [SliderController::class, 'store']);
    Route::get('/slider/show/{id}', [SliderController::class, 'show']);
    Route::post('/slider/update/{id}', [SliderController::class, 'update']);
    Route::post('/slider/delete/{id}', [SliderController::class, 'destroy']);
    Route::post('/slider/status-change/{id}', [SliderController::class, 'changeStatus']);
    Route::get('/active-sliders', [SliderController::class, 'activeSliderData']);

    //  Service Route
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/service/create', [ServiceController::class, 'store']);
    Route::get('/service/show/{id}', [ServiceController::class, 'show']);
    Route::post('/service/update/{id}', [ServiceController::class, 'update']);
    Route::post('/service/delete/{id}', [ServiceController::class, 'destroy']);
    Route::post('/service/status-change/{id}', [ServiceController::class, 'changeStatus']);
    Route::get('/active-services', [ServiceController::class, 'activeServiceData']);

    //  About Us Route
    Route::get('/about-us/show', [AboutController::class, 'show']);
    Route::post('/about-us/update/{id}', [AboutController::class, 'update']);

    //  Service Route
    Route::get('/skills', [SkillController::class, 'index']);
    Route::post('/skill/create', [SkillController::class, 'store']);
    Route::get('/skill/show/{id}', [SkillController::class, 'show']);
    Route::post('/skill/update/{id}', [SkillController::class, 'update']);
    Route::post('/skill/delete/{id}', [SkillController::class, 'destroy']);
    Route::post('/skill/status-change/{id}', [SkillController::class, 'changeStatus']);
    Route::get('/active-skills', [SkillController::class, 'activeSkillData']);

    //  FAQ Route
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::post('/faq/create', [FaqController::class, 'store']);
    Route::get('/faq/show/{id}', [FaqController::class, 'show']);
    Route::post('/faq/update/{id}', [FaqController::class, 'update']);
    Route::post('/faq/delete/{id}', [FaqController::class, 'destroy']);
    Route::post('/faq/status-change/{id}', [FaqController::class, 'changeStatus']);
    Route::get('/active-faqs', [FaqController::class, 'activeFaqData']);

    //  Team Route
    Route::get('/teams', [TeamController::class, 'index']);
    Route::get('/teams/active-latest-members', [TeamController::class, 'latestActiveMembers']);
    Route::post('/team/create', [TeamController::class, 'store']);
    Route::get('/team/show/{id}', [TeamController::class, 'show']);
    Route::post('/team/update/{id}', [TeamController::class, 'update']);
    Route::post('/team/delete/{id}', [TeamController::class, 'destroy']);
    Route::post('/team/status-change/{id}', [TeamController::class, 'changeStatus']);
    Route::get('/active-teams', [TeamController::class, 'activeTeamData']);

    //  Project Categories Route
    Route::get('/categories', [ProjectCategoryController::class, 'index']);
    Route::post('/category/create', [ProjectCategoryController::class, 'store']);
    Route::get('/category/show/{id}', [ProjectCategoryController::class, 'show']);
    Route::post('/category/update/{id}', [ProjectCategoryController::class, 'update']);
    Route::post('/category/delete/{id}', [ProjectCategoryController::class, 'destroy']);
    Route::post('/category/status-change/{id}', [ProjectCategoryController::class, 'changeStatus']);
    Route::get('/active-project-category', [ProjectCategoryController::class, 'activeCategoryData']);

    //  Porjects Route
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/project/create', [ProjectController::class, 'store']);
    Route::get('/project/show/{id}', [ProjectController::class, 'show']);
    Route::post('/project/update/{id}', [ProjectController::class, 'update']);
    Route::post('/project/delete/{id}', [ProjectController::class, 'destroy']);
    Route::post('/project/status-change/{id}', [ProjectController::class, 'changeStatus']);
    Route::get('/active-projects', [ProjectController::class, 'activeProjectData']);

    //  Testimonial Route
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/testimonial/create', [TestimonialController::class, 'store']);
    Route::get('/testimonial/show/{id}', [TestimonialController::class, 'show']);
    Route::post('/testimonial/update/{id}', [TestimonialController::class, 'update']);
    Route::post('/testimonial/delete/{id}', [TestimonialController::class, 'destroy']);
    Route::post('/testimonial/status-change/{id}', [TestimonialController::class, 'changeStatus']);
    Route::get('/active-testimonials/{id}', [TestimonialController::class, 'activeTestimonialData']);

    //  Blog Categories Route
    Route::get('/blog-categories', [BlogCategoryController::class, 'index']);
    Route::post('/blog-category/create', [BlogCategoryController::class, 'store']);
    Route::get('/blog-category/show/{id}', [BlogCategoryController::class, 'show']);
    Route::post('/blog-category/update/{id}', [BlogCategoryController::class, 'update']);
    Route::post('/blog-category/delete/{id}', [BlogCategoryController::class, 'destroy']);
    Route::post('/blog-category/status-change/{id}', [BlogCategoryController::class, 'changeStatus']);
    Route::get('/active-blog-categories', [BlogCategoryController::class, 'activeCategoryData']);

    //  Blog Route
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blog/create', [BlogController::class, 'store']);
    Route::get('/blog/show/{id}', [BlogController::class, 'show']);
    Route::post('/blog/update/{id}', [BlogController::class, 'update']);
    Route::post('/blog/delete/{id}', [BlogController::class, 'destroy']);
    Route::post('/blog/status-change/{id}', [BlogController::class, 'changeStatus']);
    Route::get('/active-blog', [BlogController::class, 'activeCategoryData']);

    //  Setting Route
    Route::get('/setting/show', [SettingController::class, 'show']);
    Route::post('/setting/update/{id}', [SettingController::class, 'update']);

    //  Contact Route
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contact/delete/{id}', [ContactController::class, 'destroy']);

});








