<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/signup/professional', [App\Http\Controllers\Auth\RegisterController::class, 'professionalSignup']);
Route::post('/signup/professional', [App\Http\Controllers\Auth\RegisterController::class, 'registerProfessional']);

Route::get('/signup/user', [App\Http\Controllers\Auth\RegisterController::class, 'userSignup']);
Route::post('/signup/user', [App\Http\Controllers\Auth\RegisterController::class, 'registerUser']);

Route::post("send-verify-code",[App\Http\Controllers\BackendController::class, 'sendVerifyCode']);

Route::get('/login/{provider}', [App\Http\Controllers\SocialLoginController::class, 'redirect']);
Route::get('/login/{provider}/callback', [App\Http\Controllers\SocialLoginController::class, 'Callback']);


// Super Admin
Route::group(array('prefix' => 'super-admin', 'middleware' => 'super_admin'), function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'dashboard']);

    Route::get('/edit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'editProfile']); 

    Route::post('/submit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'updateProfile']); 

    Route::group(array('prefix' => 'licence-bodies'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'licenceBodies']);

        Route::post('/list', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'getList']); 

        Route::get('/add', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'add']);

        Route::post('/save', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'save']); 

        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'delete']); 

        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'edit']); 

        Route::post('/update', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'update']);

        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'search']); 

    });

    Route::group(array('prefix' => 'languages'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'languages']);

        Route::post('/list', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'getList']); 

        Route::get('/add', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'add']);

        Route::post('/save', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'save']); 

        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'delete']); 

        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'edit']); 

        Route::post('/update', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'update']);

        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'search']); 

    });


    Route::group(array('prefix' => 'visa-services'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'visaServices']);

        Route::post('/list', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'getList']); 

        Route::get('/add', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'add']);

        Route::post('/save', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'save']); 

        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'delete']); 

        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'edit']); 

        Route::post('/update', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'update']);

        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\visaServicesController::class, 'search']); 
    });


    Route::group(array('prefix' => 'lead-qualities'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'leadQualities']);

        Route::post('/list', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'getList']); 

        Route::get('/add', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'add']);

        Route::post('/save', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'save']); 

        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'delete']); 

        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'edit']); 

        Route::post('/update', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'update']);

        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LeadQualitiesController::class, 'search']); 

    });

    
});


// User
Route::group(array('prefix' => 'user', 'middleware' => 'user'), function () {
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'dashboard']);
});

// Professional Admin
Route::group(array('prefix' => 'professional', 'middleware' => 'professional'), function () {
    Route::get('/', [App\Http\Controllers\Professional\DashboardController::class, 'dashboard']);

    Route::get('/profile', [App\Http\Controllers\Professional\DashboardController::class, 'profile']);

    Route::get('/articles', [App\Http\Controllers\Professional\DashboardController::class, 'articles']);

    Route::get('/events', [App\Http\Controllers\Professional\DashboardController::class, 'events']);

    Route::get('/services', [App\Http\Controllers\Professional\DashboardController::class, 'services']);

    Route::get('/complete-profile', [App\Http\Controllers\Professional\DashboardController::class, 'completeProfile']);

    Route::get('/edit-profile', [App\Http\Controllers\Professional\DashboardController::class, 'editProfile']);	
});


// Admin of Professional Side
Route::group(array('prefix' => 'admin', 'middleware' => 'admin'), function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
});