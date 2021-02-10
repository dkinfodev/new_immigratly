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
Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome_page']);
Route::get('/dbupgrade', [App\Http\Controllers\HomeController::class, 'dbupgrade']);
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
Route::get('/google-callback', [App\Http\Controllers\SocialLoginController::class, 'googleCallback']);
Route::get('/dropbox-callback', [App\Http\Controllers\SocialLoginController::class, 'dropboxCallback']);
Route::get('/view-notification/{id}', [App\Http\Controllers\CommonController::class, 'readNotification']);


Route::post('/upload-files', [App\Http\Controllers\CommonController::class, 'uploadFiles']);

Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware(['guest'])->name('password.request');

// Super Admin
Route::group(array('prefix' => 'super-admin', 'middleware' => 'super_admin'), function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'dashboard']);
    Route::get('/edit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'editProfile']); 
    Route::post('/submit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'updateProfile']); 

    Route::get('/change-password', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'changePassword']);
    Route::post('/update-password', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'updatePassword']);

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

        Route::group(array('prefix' => 'cutoff/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServiceCutoff']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaCutoffList']); 
            Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'addCutoff']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'saveCutoff']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteSingleCutoff']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultipleCutoff']); 
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'editCutoff']); 
            Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'updateCutoff']);
        });

        Route::group(array('prefix' => 'content/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServiceContent']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaContentList']); 
            Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'addContent']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'saveContent']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteSingleContent']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultipleContent']); 
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'editContent']); 
            Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'updateContent']);
        });
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
    Route::group(array('prefix' => 'assessments'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'index']);
        Route::get('/assigned', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'assigned']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'getAjaxList']);
        // Route::get('/add', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'add']);
        // Route::post('/save', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'save']);
        Route::get('/view/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'edit']);
        // Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'deleteMultiple']);
        Route::get('/assign-to-professional/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'assignToProfessional']);
        Route::post('/assign-to-professional/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'assignAssessment']);
        // Route::post('/payment-success', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'assessmentPaymentSuccess']);
        // Route::post('/payment-failed', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'assessmentPaymentFailed']);
        
        Route::post('/documents/{ass_id}/{doc_id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'fetchDocuments']);
        
        Route::group(array('prefix' => 'files'), function () {
            Route::post('/upload-documents', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'uploadDocuments']);
            Route::get('/view-document/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'viewDocument']);
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'deleteDocument']);
        });
        
        Route::group(array('prefix' => 'google-drive'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'uploadFromDropbox']);
        });
        
    });
    Route::group(array('prefix' => 'professionals'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'activeProfessionals']);
        Route::post('/ajax-active', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getActiveList']);
        Route::get('/inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'inactiveProfessionals']);
        Route::post('/ajax-inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getPendingList']);
        Route::get('/update-all-databases', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'editAllDatabase']);
        Route::post('/update-all-databases', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'updateAllDatabase']);
        
        Route::post('/status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'changeStatus']);
        Route::post('/profile-status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'profileStatus']);

        Route::get('/view/{id}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'viewDetail']);
        Route::get('/add-notes/{id}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'addNotes']);
        Route::post('/save-notes', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'saveNotes']);
    });
    Route::group(array('prefix' => 'privileges'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'search']); 

        Route::group(array('prefix' => 'action'), function () {  
            Route::get('/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'getAjaxList']); 
            Route::get('/{id}/add', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'deleteMultiple']); 
            Route::get('/{mid}/edit/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'edit']); 
            Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'update']);
        });
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

    Route::group(array('prefix' => 'categories'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'category']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'update']);     
    }); 

    Route::group(array('prefix' => 'tags'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\TagsController::class, 'tags']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\TagsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\TagsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\TagsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\TagsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\TagsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\TagsController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\TagsController::class, 'update']);     
    }); 

    Route::group(array('prefix' => 'news'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\NewsController::class, 'news']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\NewsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\NewsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\NewsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\NewsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\NewsController::class, 'update']);
        
    }); 

    Route::group(array('prefix' => 'news-category'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategory']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryGetAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryAdd']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategorySave']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryDeleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryDeleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryEdit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryUpdate']);     
    });  

    Route::group(array('prefix' => 'noc-code'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'list']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'update']);     
    });

    Route::group(array('prefix' => 'primary-degree'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'list']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'update']);     
    });  

    Route::group(array('prefix' => 'staff'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\StaffController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\StaffController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\SuperAdmin\StaffController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\StaffController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\StaffController::class, 'deleteMultiple']);
            Route::get('/change-password/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'changePassword']);
            Route::post('/update-password/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'updatePassword']);
            Route::get('/privileges/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'setPrivileges']);
            Route::post('/privileges/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'savePrivileges']);
    });
    
    Route::group(array('prefix' => 'articles'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'publishArticles']);
        Route::get('/draft', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'draftArticles']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'edit']);
        Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'update']);
        Route::get('/remove-image/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'deleteImage']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'deleteMultiple']);
    });

    Route::group(array('prefix' => 'webinar'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'edit']);
        Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'update']);
        Route::get('/remove-image/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'deleteImage']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'deleteMultiple']);
    });
    Route::group(array('prefix' => 'employee-privileges'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'search']); 

        Route::group(array('prefix' => 'action'), function () {  
            Route::get('/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'getAjaxList']); 
            Route::get('/{id}/add', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'deleteMultiple']); 
            Route::get('/{mid}/edit/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'edit']); 
            Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'update']);
        });
    });
});
// Executive
Route::group(array('prefix' => 'executive'), function () {
    Route::group(array('middleware' => 'executive'), function () {
        Route::get('/', [App\Http\Controllers\Executive\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Executive\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Executive\DashboardController::class, 'editProfile']);
        Route::post('/update-profile/', [App\Http\Controllers\Executive\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Executive\DashboardController::class, 'changePassword']);
        Route::post('/update-password', [App\Http\Controllers\Executive\DashboardController::class, 'updatePassword']);

        Route::group(array('prefix' => 'news'), function () {

            Route::get('/', [App\Http\Controllers\Executive\NewsController::class, 'news']);
            Route::post('/ajax-list', [App\Http\Controllers\Executive\NewsController::class, 'getAjaxList']); 
            Route::get('/add', [App\Http\Controllers\Executive\NewsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Executive\NewsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\Executive\NewsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\Executive\NewsController::class, 'deleteMultiple']); 
            Route::get('/edit/{id}', [App\Http\Controllers\Executive\NewsController::class, 'edit']); 
            Route::post('/update', [App\Http\Controllers\Executive\NewsController::class, 'update']);
            
        }); 

        Route::group(array('prefix' => 'news-category'), function () {

            Route::get('/', [App\Http\Controllers\Executive\NewsController::class, 'newsCategory']);
            Route::post('/ajax-list', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryGetAjaxList']); 
            Route::get('/add', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryAdd']);
            Route::post('/save', [App\Http\Controllers\Executive\NewsController::class, 'newsCategorySave']); 
            Route::get('/delete/{id}', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryDeleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryDeleteMultiple']); 
            Route::get('/edit/{id}', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryEdit']); 
            Route::post('/update', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryUpdate']);     
        }); 
        Route::group(array('prefix' => 'visa-services'), function () {
            Route::get('/', [App\Http\Controllers\Executive\VisaServicesController::class, 'visaServices']);
            Route::post('/ajax-list', [App\Http\Controllers\Executive\VisaServicesController::class, 'getAjaxList']); 
            Route::group(array('prefix' => 'content/{visa_service_id}'), function () {
                Route::get('/', [App\Http\Controllers\Executive\VisaServicesController::class, 'visaServiceContent']);
                Route::post('/ajax-list', [App\Http\Controllers\Executive\VisaServicesController::class, 'visaContentList']); 
                Route::get('/add', [App\Http\Controllers\Executive\VisaServicesController::class, 'addContent']);
                Route::post('/save', [App\Http\Controllers\Executive\VisaServicesController::class, 'saveContent']); 
                Route::get('/delete/{id}', [App\Http\Controllers\Executive\VisaServicesController::class, 'deleteSingleContent']); 
                Route::post('/delete-multiple', [App\Http\Controllers\Executive\VisaServicesController::class, 'deleteMultipleContent']); 
                Route::get('/edit/{id}', [App\Http\Controllers\Executive\VisaServicesController::class, 'editContent']); 
                Route::post('/edit/{id}', [App\Http\Controllers\Executive\VisaServicesController::class, 'updateContent']);
            });
        });
    });
});
// User
Route::group(array('prefix' => 'user', 'middleware' => 'user'), function () {
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'dashboard']);
    Route::get('/notifications', [App\Http\Controllers\User\DashboardController::class, 'notifications']);
    Route::get('/edit-profile', [App\Http\Controllers\User\DashboardController::class, 'editProfile']);
    Route::post('/update-profile', [App\Http\Controllers\User\DashboardController::class, 'updateProfile']);
    Route::get('/change-password', [App\Http\Controllers\User\DashboardController::class, 'changePassword']);
    Route::post('/update-password', [App\Http\Controllers\User\DashboardController::class, 'updatePassword']);

    Route::get('/cv', [App\Http\Controllers\User\DashboardController::class, 'manageCv']);
    Route::post('/save-language-proficiency', [App\Http\Controllers\User\DashboardController::class, 'saveLanguageProficiency']);

    Route::group(array('prefix' => 'assessments'), function () {
        Route::get('/', [App\Http\Controllers\User\AssessmentsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\User\AssessmentsController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\User\AssessmentsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\User\AssessmentsController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'edit']);
        Route::post('/update/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\User\AssessmentsController::class, 'deleteMultiple']);
        Route::post('/payment-success', [App\Http\Controllers\User\TransactionController::class, 'assessmentPaymentSuccess']);
        Route::post('/payment-failed', [App\Http\Controllers\User\TransactionController::class, 'assessmentPaymentFailed']);
        
        Route::post('/documents/{ass_id}/{doc_id}', [App\Http\Controllers\User\AssessmentsController::class, 'fetchDocuments']);
        
        Route::group(array('prefix' => 'files'), function () {
            Route::post('/upload-documents', [App\Http\Controllers\User\AssessmentsController::class, 'uploadDocuments']);
            Route::get('/view-document/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'viewDocument']);
            Route::get('/delete/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'deleteDocument']);
        });
        
        Route::group(array('prefix' => 'google-drive'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\User\AssessmentsController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\User\AssessmentsController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\User\AssessmentsController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\User\AssessmentsController::class, 'uploadFromDropbox']);
        });
        
    });
    Route::group(array('prefix' => 'connect-apps'), function () {
        Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'connectApps']);
        Route::get('/unlink/{app}', [App\Http\Controllers\User\DashboardController::class, 'unlinkApp']);
        Route::get('/google-auth', [App\Http\Controllers\User\DashboardController::class, 'googleAuthention']);
        Route::get('/connect-google', [App\Http\Controllers\User\DashboardController::class, 'connectGoogle']);
        Route::get('/dropbox-auth', [App\Http\Controllers\User\DashboardController::class, 'dropboxAuthention']);
        Route::get('/connect-dropbox', [App\Http\Controllers\User\DashboardController::class, 'connectDropbox']);
    });

    Route::group(array('prefix' => 'work-experiences'), function () {
        Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'workExperiences']);
        Route::get('/add', [App\Http\Controllers\User\DashboardController::class, 'addWorkExperience']);
        Route::post('/add', [App\Http\Controllers\User\DashboardController::class, 'saveWorkExperience']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'editWorkExperience']);
        Route::post('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'updateWorkExperience']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\DashboardController::class, 'deleteExperience']);
    });
    
    Route::group(array('prefix' => 'educations'), function () {
        Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'educations']);
        Route::get('/add', [App\Http\Controllers\User\DashboardController::class, 'addEducation']);
        Route::post('/add', [App\Http\Controllers\User\DashboardController::class, 'saveEducation']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'editEducation']);
        Route::post('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'updateEducation']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\DashboardController::class, 'deleteEducation']);
    });

    Route::get('/pay-now/{subdomain}/{transaction_id}', [App\Http\Controllers\User\TransactionController::class, 'payNow']);
    Route::post('/pay-now', [App\Http\Controllers\User\TransactionController::class, 'submitPayNow']);
    Route::post('/validate-pay-now', [App\Http\Controllers\User\TransactionController::class, 'validatePayNow']);
    Route::post('/payment-success', [App\Http\Controllers\User\TransactionController::class, 'paymentSuccess']);
    Route::post('/payment-failed', [App\Http\Controllers\User\TransactionController::class, 'paymentFailed']);

    Route::get('/professional/{subdomain}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'professionalProfile']);
    
    Route::group(array('prefix' => 'documents'), function () {
        Route::get('/', [App\Http\Controllers\User\MyDocumentsController::class, 'myFolders']);
        Route::get('/add-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'addFolder']);
        Route::post('/add-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'createFolder']);
        Route::get('/edit-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'editFolder']);
        Route::post('/edit-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'updateFolder']);
        Route::get('/delete-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteFolder']);

        Route::group(array('prefix' => 'google-drive'), function () {
            Route::get('/folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\User\MyDocumentsController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::get('/folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\User\MyDocumentsController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadFromDropbox']);
        });
        Route::group(array('prefix' => 'files'), function () {
            Route::get('/lists/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'folderFiles']);
            Route::post('/upload-documents', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadDocuments']);
            Route::get('/delete/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteDocument']);
            Route::post('/delete-multiple', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteMultipleDocuments']);

            Route::get('/file-move-to/{file_id}', [App\Http\Controllers\User\MyDocumentsController::class, 'fileMoveTo']);
            Route::post('/file-move-to', [App\Http\Controllers\User\MyDocumentsController::class, 'moveFileToFolder']);

            Route::get('/view-document/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'viewDocument']);
        });

        Route::get('/documents-exchanger', [App\Http\Controllers\User\MyDocumentsController::class, 'documentsExchanger']);
        Route::post('/documents-exchanger', [App\Http\Controllers\User\MyDocumentsController::class, 'saveExchangeDocuments']);
    });
    
    

    Route::group(array('prefix' => 'cases'), function () {
        Route::get('/', [App\Http\Controllers\User\ProfessionalCasesController::class, 'cases']);
        Route::get('/view/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'view']);
        Route::get('/chats/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'chats']);
        Route::post('/fetch-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchChats']);
        Route::post('/save-chat', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveChat']);
        Route::post('/save-chat-file', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveChatFile']);
        Route::get('/chat-demo', [App\Http\Controllers\User\ProfessionalCasesController::class, 'chatdemo']);
        Route::group(array('prefix' => 'google-drive'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\User\ProfessionalCasesController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\User\ProfessionalCasesController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\User\ProfessionalCasesController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\User\ProfessionalCasesController::class, 'uploadFromDropbox']);
        });
        Route::group(array('prefix' => 'documents'), function () {
            Route::get('/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseDocuments']);
            Route::get('/default/{subdomain}/{case_id}/{folder_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'defaultDocuments']);
            Route::get('/other/{subdomain}/{case_id}/{folder_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'otherDocuments']);
            Route::get('/extra/{subdomain}/{case_id}/{folder_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'extraDocuments']);
            Route::get('/file-move-to/{subdomain}/{case_id}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fileMoveTo']);
            Route::get('/delete/{subdomain}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'deleteDocument']);
            Route::post('/delete-multiple', [App\Http\Controllers\User\ProfessionalCasesController::class, 'deleteMultipleDocuments']);
            Route::post('/chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'documentChats']);
            Route::post('/fetch-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchDocumentChats']);
            Route::post('/send-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveDocumentChat']);
            Route::post('/send-chat-file', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveDocumentChatFile']);
        });
        Route::post('/upload-documents/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'uploadDocuments']);
        Route::get('/documents-exchanger/{subdomain}/{case_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'documentsExchanger']);
        Route::post('/documents-exchanger', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveExchangeDocuments']);
        Route::get('/my-documents-exchanger/{subdomain}/{case_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'myDocumentsExchanger']);
        Route::post('/my-documents-exchanger', [App\Http\Controllers\User\ProfessionalCasesController::class, 'exportMyDocuments']);
        Route::post('/remove-case-document', [App\Http\Controllers\User\ProfessionalCasesController::class, 'removeCaseDocument']);
        Route::get('/import-to-my-documents/{subdomain}/{case_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'importToMyDocuments']);
        Route::post('/import-documents', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveImportDocuments']);
        Route::post('/remove-user-document', [App\Http\Controllers\User\ProfessionalCasesController::class, 'removeUserDocument']);
        Route::get('/view-document/{case_id}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'viewDocument']);

        Route::group(array('prefix' => '{subdomain}/invoices'), function () {
            Route::get('/list/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseInvoices']);
            Route::post('/case-invoices', [App\Http\Controllers\User\ProfessionalCasesController::class, 'getCaseInvoice']);
            Route::get('/view/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'viewCaseInvoice']);
        });

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

        Route::get('/edit-profile', [App\Http\Controllers\Admin\ProfileController::class, 'EditProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile']);
    }); 
    Route::group(array('middleware' => 'admin'), function () {
        Route::get('/connect-apps', [App\Http\Controllers\Admin\DashboardController::class, 'connectApps']);
        Route::get('/google-auth', [App\Http\Controllers\Admin\DashboardController::class, 'googleAuthention']);
        Route::get('/connect-google', [App\Http\Controllers\Admin\DashboardController::class, 'connectGoogle']);
        Route::get('/notifications', [App\Http\Controllers\Admin\DashboardController::class, 'notifications']);
        Route::get('/role-privileges', [App\Http\Controllers\Admin\DashboardController::class, 'rolePrivileges']);
        Route::post('/role-privileges', [App\Http\Controllers\Admin\DashboardController::class, 'savePrivileges']);
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
        Route::get('/profile', [App\Http\Controllers\Admin\DashboardController::class, 'profile']);

        Route::get('/add-reminder-note', [App\Http\Controllers\Admin\DashboardController::class, 'addReminderNote']);
        Route::post('/fetch-reminder-notes', [App\Http\Controllers\Admin\DashboardController::class, 'fetchReminderNotes']);
        Route::post('/add-reminder-note', [App\Http\Controllers\Admin\DashboardController::class, 'saveReminderNote']);

        Route::get('/edit-reminder-note/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'editReminderNote']);
        Route::post('/edit-reminder-note/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'updateReminderNote']);
        Route::get('/delete-reminder-note/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'deleteReminderNote']);

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
        
        Route::group(array('prefix' => 'articles'), function () {
            Route::get('/', [App\Http\Controllers\Admin\ArticlesController::class, 'publishArticles']);
            Route::get('/draft', [App\Http\Controllers\Admin\ArticlesController::class, 'draftArticles']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\ArticlesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\ArticlesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\ArticlesController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'update']);
            Route::get('/remove-image/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'deleteImage']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\ArticlesController::class, 'deleteMultiple']);
        });
        
        Route::group(array('prefix' => 'webinar'), function () {
            Route::get('/', [App\Http\Controllers\Admin\WebinarController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\WebinarController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\WebinarController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\WebinarController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'update']);
            Route::get('/remove-image/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'deleteImage']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\WebinarController::class, 'deleteMultiple']);
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
            Route::get('/clients', [App\Http\Controllers\Admin\LeadsController::class, 'leadsAsClient']);
            Route::get('/quick-lead', [App\Http\Controllers\Admin\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Admin\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'confirmAsClient']);
            Route::get('/assign/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'assignLeads']);
            Route::post('/assign/save', [App\Http\Controllers\Admin\LeadsController::class, 'saveAssignLeads']);
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
            Route::get('/chats/{id}', [App\Http\Controllers\Admin\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Admin\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Admin\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Admin\CasesController::class, 'saveChatFile']);
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
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\CasesController::class, 'deleteMultipleDocuments']);
                Route::get('/view-document/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'viewDocument']);
                
                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Admin\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Admin\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Admin\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Admin\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Admin\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Admin\CasesController::class, 'saveDocumentChatFile']);
            });
        
            Route::group(array('prefix' => 'invoices'), function () {
                Route::get('/list/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'caseInvoices']);
                Route::post('/case-invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'getCaseInvoice']);
                Route::get('/add/{case_id}', [App\Http\Controllers\Admin\InvoiceController::class, 'addCaseInvoice']);
                Route::post('/add/{case_id}', [App\Http\Controllers\Admin\InvoiceController::class, 'saveCaseInvoice']);
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'editCaseInvoice']);
                Route::post('/edit/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'updateCaseInvoice']);
                Route::get('/view/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'viewCaseInvoice']);
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'deleteSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\InvoiceController::class, 'deleteMultiple']);
            });
    
        });

    });
});

// Manager of Professional Side
Route::group(array('prefix' => 'manager'), function () {
    Route::group(array('middleware' => 'manager'), function () {
        Route::get('/', [App\Http\Controllers\Manager\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Manager\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Manager\DashboardController::class, 'editProfile']);
        Route::post('/update-profile/', [App\Http\Controllers\Manager\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Manager\DashboardController::class, 'changePassword']);
        Route::post('/update-password', [App\Http\Controllers\Manager\DashboardController::class, 'updatePassword']);

        Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Manager\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Manager\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Manager\LeadsController::class, 'assignedLeads']);
            Route::get('/recommended', [App\Http\Controllers\Manager\LeadsController::class, 'recommendLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Manager\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Manager\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Manager\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'update']);
            Route::get('/recommend-as-client/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'recommendAsClient']);
            // Route::post('/mark-as-client/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'confirmAsClient']);
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
            Route::get('/chats/{id}', [App\Http\Controllers\Manager\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Manager\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Manager\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Manager\CasesController::class, 'saveChatFile']);
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
                Route::get('/delete/{id}', [App\Http\Controllers\Manager\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Manager\CasesController::class, 'deleteMultipleDocuments']);

                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Manager\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Manager\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Manager\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Manager\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Manager\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Manager\CasesController::class, 'saveDocumentChatFile']);
            });
        });
    });
});


// Telecaller of Professional Side
Route::group(array('prefix' => 'telecaller'), function () {
    Route::group(array('middleware' => 'telecaller'), function () {
        Route::get('/', [App\Http\Controllers\Telecaller\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Telecaller\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Telecaller\DashboardController::class, 'editProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Telecaller\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Telecaller\DashboardController::class, 'changePassword']);     
        Route::post('/update-password', [App\Http\Controllers\Telecaller\DashboardController::class, 'updatePassword']);

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
            Route::get('/chats/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Telecaller\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Telecaller\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Telecaller\CasesController::class, 'saveChatFile']);
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
                Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteMultipleDocuments']);

                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Telecaller\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Telecaller\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Telecaller\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Telecaller\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Telecaller\CasesController::class, 'saveDocumentChatFile']);
            });
        });
    });
});

// Associate of Professional Side
Route::group(array('prefix' => 'associate'), function () {
    Route::group(array('middleware' => 'associate'), function () {
        Route::get('/', [App\Http\Controllers\Associate\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Associate\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Associate\DashboardController::class, 'editProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Associate\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Associate\DashboardController::class, 'changePassword']);     
        Route::post('/update-password', [App\Http\Controllers\Associate\DashboardController::class, 'updatePassword']);
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

        Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Associate\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Associate\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Associate\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Associate\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Associate\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Associate\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Associate\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Associate\CasesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Associate\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Associate\CasesController::class, 'removeDocuments']);
            Route::get('/chats/{id}', [App\Http\Controllers\Associate\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Associate\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Associate\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Associate\CasesController::class, 'saveChatFile']);
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
                Route::get('/delete/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Associate\CasesController::class, 'deleteMultipleDocuments']);

                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Associate\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Associate\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Associate\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Associate\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Associate\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Associate\CasesController::class, 'saveDocumentChatFile']);
            });
        });
});
