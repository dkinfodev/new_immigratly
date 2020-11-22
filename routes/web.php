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


    Route::get('/preview-pdf/{id}', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'viewPdf']);

    Route::get('/preview-docx/{id}', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'viewDocx']);

    Route::get('/preview-image/{id}', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'viewImage']);


    Route::group(array('prefix' => 'licence-bodies'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'licenceBodies']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'languages'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'languages']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'search']); 
    });


    Route::group(array('prefix' => 'visa-services'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServices']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'document-folder'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'deleteMultiple']); 
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

    Route::group(array('prefix' => 'documents'), function () {
        Route::get('/', [App\Http\Controllers\User\MyDocumentsController::class, 'documents']);
        Route::get('/add-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'addFolder']);
        Route::post('/add-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'createFolder']);
        Route::get('/edit-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'editFolder']);
        Route::post('/edit-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'updateFolder']);
        Route::get('/delete-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteFolder']);

        Route::get('/view-documents', [App\Http\Controllers\User\MyDocumentsController::class, 'viewDocuments']);
        Route::post('/upload-documents', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadDocuments']);
    });    
                
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
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\ServicesController::class, 'deleteMultiple']);
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
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'confirmAsClient']);
        });

        Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Admin\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Admin\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Admin\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\CasesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Admin\CasesController::class, 'removeDocuments']);
            
            Route::post('/pinned-folder', [App\Http\Controllers\Admin\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Admin\CasesController::class, 'unpinnedFolder']);
            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/documents/{id}', [App\Http\Controllers\Admin\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Admin\CasesController::class, 'uploadDocuments']);
            });
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

    Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Manager\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Manager\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Manager\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Manager\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Manager\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Manager\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Manager\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Manager\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Manager\CasesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Manager\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Manager\CasesController::class, 'removeDocuments']);
            
            Route::post('/pinned-folder', [App\Http\Controllers\Manager\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Manager\CasesController::class, 'unpinnedFolder']);
            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/documents/{id}', [App\Http\Controllers\Manager\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Manager\CasesController::class, 'uploadDocuments']);
            });
        });

    Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Manager\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Manager\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Manager\LeadsController::class, 'assignedLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Manager\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Manager\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Manager\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'confirmAsClient']);
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

    Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Telecaller\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Telecaller\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Telecaller\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Telecaller\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Telecaller\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Telecaller\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Telecaller\CasesController::class, 'removeDocuments']);
            
            Route::post('/pinned-folder', [App\Http\Controllers\Telecaller\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Telecaller\CasesController::class, 'unpinnedFolder']);
            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/documents/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'uploadDocuments']);
            });
        });

    
    Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Telecaller\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Telecaller\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Telecaller\LeadsController::class, 'assignedLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Telecaller\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Telecaller\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'confirmAsClient']);
        });
});

// Telecaller of Professional Side
Route::group(array('prefix' => 'associate'), function () {
    Route::group(array('middleware' => 'telecaller'), function () {
        Route::get('/', [App\Http\Controllers\Associate\DashboardController::class, 'dashboard']);
        Route::get('/edit-profile', [App\Http\Controllers\Associate\DashboardController::class, 'editProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Associate\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Associate\DashboardController::class, 'changePassword']);     
        Route::post('/update-password', [App\Http\Controllers\Associate\DashboardController::class, 'updatePassword']);
    });

    Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Associate\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Associate\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Associate\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Associate\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Associate\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Associate\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Associate\CasesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Associate\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Associate\CasesController::class, 'removeDocuments']);
            
            Route::post('/pinned-folder', [App\Http\Controllers\Associate\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Associate\CasesController::class, 'unpinnedFolder']);
            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/documents/{id}', [App\Http\Controllers\Associate\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Associate\CasesController::class, 'uploadDocuments']);
            });
        });

    
    Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Associate\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Associate\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Associate\LeadsController::class, 'assignedLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Associate\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Associate\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Associate\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'confirmAsClient']);
        });
});
