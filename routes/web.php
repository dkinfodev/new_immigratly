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

    Route::group(array('prefix' => 'professionals'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'activeProfessionals']);
        Route::post('/ajax-active', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getActiveList']);
        Route::get('/inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'inactiveProfessionals']);
        Route::post('/ajax-inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getPendingList']);

        Route::post('/status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'changeStatus']);
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