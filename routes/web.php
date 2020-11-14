<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
Route::get('/states', [App\Http\Controllers\CommonController::class, 'stateList']);
Route::get('/cities', [App\Http\Controllers\CommonController::class, 'cityList']);
Route::get('/licence-bodies', [App\Http\Controllers\CommonController::class, 'licenceBodies']);

Route::get('/signup/professional', [App\Http\Controllers\Auth\RegisterController::class, 'professionalSignup']);
Route::post('/signup/professional', [App\Http\Controllers\Auth\RegisterController::class, 'registerProfessional']);

Route::get('/signup/user', [App\Http\Controllers\Auth\RegisterController::class, 'userSignup']);
Route::post('/signup/user', [App\Http\Controllers\Auth\RegisterController::class, 'registerUser']);

Route::post("send-verify-code",[App\Http\Controllers\BackendController::class, 'sendVerifyCode']);

Route::get('/login/{provider}', [App\Http\Controllers\SocialLoginController::class, 'redirect']);
Route::get('/login/{provider}/callback', [App\Http\Controllers\SocialLoginController::class, 'Callback']);

Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware(['guest'])->name('password.request');


// Super Admin
Route::group(array('prefix' => 'super-admin', 'middleware' => 'super_admin'), function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'dashboard']);
    Route::get('/edit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'editProfile']); 
    Route::post('/submit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'updateProfile']); 

    Route::group(array('prefix' => 'licence-bodies'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'licenceBodies']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'delete']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'languages'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'languages']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'delete']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'search']); 
    });


    Route::group(array('prefix' => 'visa-services'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServices']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'delete']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'document-folder'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'delete']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'search']); 
    });
    Route::group(array('prefix' => 'professionals'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'activeProfessionals']);
        Route::post('/ajax-active', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getActiveList']);
        Route::get('/inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'inactiveProfessionals']);
        Route::post('/ajax-inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getPendingList']);

        Route::post('/status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'changeStatus']);
        Route::post('/profile-status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'profileStatus']);
    });

    Route::group(array('prefix' => 'user'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\UserController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\UserController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\SuperAdmin\UserController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\UserController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'edit']);
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\UserController::class, 'deleteMultiple']);
        Route::get('/change-password/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'changePassword']);
        Route::post('/update-password/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'updatePassword']);
        });

});

// User
Route::group(array('prefix' => 'user', 'middleware' => 'user'), function () {
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'dashboard']);
    Route::get('/edit-profile', [App\Http\Controllers\User\DashboardController::class, 'editProfile']);
    Route::post('/update-profile', [App\Http\Controllers\User\DashboardController::class, 'updateProfile']);
    Route::get('/change-password', [App\Http\Controllers\User\DashboardController::class, 'changePassword']);
    Route::post('/update-password', [App\Http\Controllers\User\DashboardController::class, 'updatePassword']);
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
Route::group(array('prefix' => 'admin'), function () {
    Route::group(array('middleware' => 'auth'), function () {
        Route::get('/complete-profile', [App\Http\Controllers\Admin\ProfileController::class, 'completeProfile']);
        Route::post('/save-profile', [App\Http\Controllers\Admin\ProfileController::class, 'saveProfile']);
    });
    Route::group(array('middleware' => 'admin'), function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
        Route::get('/profile', [App\Http\Controllers\Admin\DashboardController::class, 'profile']);
        Route::group(array('prefix' => 'services'), function () {
            Route::get('/', [App\Http\Controllers\Admin\ServicesController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\ServicesController::class, 'getAjaxList']); 
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'update']);
            Route::post('/select-services', [App\Http\Controllers\Admin\ServicesController::class, 'selectServices']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteService']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\ServicesController::class, 'deleteMultipleService']);
            Route::get('/documents/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'serviceDocuments']);
            Route::get('/add-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'addFolder']);
            Route::post('/add-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'createFolder']);
            Route::get('/edit-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'editFolder']);
            Route::post('/edit-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'updateFolder']);
            Route::get('/delete-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteFolder']);

        });
        
        Route::group(array('prefix' => 'staff'), function () {
            Route::get('/', [App\Http\Controllers\Admin\StaffController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\StaffController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\StaffController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\StaffController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\StaffController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\StaffController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\StaffController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\StaffController::class, 'deleteMultiple']);
            Route::get('/change-password/{id}', [App\Http\Controllers\Admin\StaffController::class, 'changePassword']);
            Route::post('/update-password/{id}', [App\Http\Controllers\Admin\StaffController::class, 'updatePassword']);
        });

        Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Admin\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Admin\LeadsController::class, 'assignedLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Admin\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Admin\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'update']);
        });
    });    
});

// Manager of Professional Side
Route::group(array('prefix' => 'manager'), function () {
    Route::group(array('middleware' => 'manager'), function () {
        Route::get('/', [App\Http\Controllers\Manager\DashboardController::class, 'dashboard']);
         Route::get('/edit-profile', [App\Http\Controllers\Manager\DashboardController::class, 'editProfile']);
         Route::post('/update-profile/', [App\Http\Controllers\Manager\DashboardController::class, 'updateProfile']);
         Route::get('/change-password', [App\Http\Controllers\Manager\DashboardController::class, 'changePassword']);
         Route::post('/update-password', [App\Http\Controllers\Manager\DashboardController::class, 'updatePassword']);
    });
});


// Telecaller of Professional Side
Route::group(array('prefix' => 'telecaller'), function () {
    Route::group(array('middleware' => 'telecaller'), function () {
        Route::get('/', [App\Http\Controllers\Telecaller\DashboardController::class, 'dashboard']);
        Route::get('/edit-profile', [App\Http\Controllers\Telecaller\DashboardController::class, 'editProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Telecaller\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Telecaller\DashboardController::class, 'changePassword']);     
        Route::post('/update-password', [App\Http\Controllers\Telecaller\DashboardController::class, 'updatePassword']);

    });
});