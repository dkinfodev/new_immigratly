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