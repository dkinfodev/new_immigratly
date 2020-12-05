<?php

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


Route::group(array('middleware' => 'curl_api'), function () {
	Route::group(array('prefix' => 'main'), function () {
		Route::post('/create-client', [App\Http\Controllers\Api\MasterApiController::class, 'createClient']);
	});	

});
Route::group(array('middleware' => 'professional_curl'), function () {
	Route::group(array('prefix' => 'professional'), function () {
		Route::group(array('prefix' => 'cases'), function () {
			Route::post('/', [App\Http\Controllers\Api\ProfessionalApiController::class, 'clientCases']);
			Route::post('/view', [App\Http\Controllers\Api\ProfessionalApiController::class, 'caseDetail']);
			Route::post('/documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'caseDocuments']);
			Route::post('/default-documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'defaultDocuments']);
			Route::post('/other-documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'otherDocuments']);
			Route::post('/extra-documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'extraDocuments']);
			Route::post('/upload-documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'uploadDocuments']);
			Route::post('/documents-exchanger', [App\Http\Controllers\Api\ProfessionalApiController::class, 'documentsExchanger']);
			Route::post('/save-exchange-documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'saveExchangeDocuments']);
			Route::post('/exchange-user-documents', [App\Http\Controllers\Api\ProfessionalApiController::class, 'exchangeUserDocuments']);
			Route::post('/remove-case-document', [App\Http\Controllers\Api\ProfessionalApiController::class, 'removeCaseDocument']);
			Route::post('/case-document-detail', [App\Http\Controllers\Api\ProfessionalApiController::class, 'caseDocumentDetail']);
			Route::post('/document-detail', [App\Http\Controllers\Api\ProfessionalApiController::class, 'documentDetail']);
			Route::post('/fetch-document-chats', [App\Http\Controllers\Api\ProfessionalApiController::class, 'fetchDocumentChats']);
			Route::post('/save-document-chat', [App\Http\Controllers\Api\ProfessionalApiController::class, 'saveDocumentChat']);

			
		});	
	});	
});
