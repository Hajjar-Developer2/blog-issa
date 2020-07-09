<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('CustRegister',['uses'=>'ApiController@CustRegister']);

Route::post('CustActivate',['uses'=>'ApiController@CustActivate']);

Route::post('CustPassRestReq',['uses'=>'ApiController@CustPassRestReq']);

Route::post('CustPassRestExec',['uses'=>'ApiController@CustRestPassExec']);

Route::post('/CustLogIn',['uses'=>"ApiController@CustLogIn"]);

Route::group(['middleware' => ['jwt.auth', 'auth:api']], function () {
    
    Route::get('CustInfo',['uses'=>'ApiController@CustInfo']);

    Route::post('CustEdit',['uses'=>'ApiController@CustEdit']);

    Route::post('CustLogOut',['uses'=>'ApiController@CustLogOut']);

    Route::post('SaveOrder',['uses'=>'ApiController@SaveOrder']);

    Route::post('UploadFile',['uses'=>"ApiController@UploadFile"]);

    Route::post('SaveMessage',['uses'=>'ApiController@SaveMessage']);

});