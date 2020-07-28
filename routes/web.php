<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

use App\Mail\CustActivateMail;

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

Route::get('/',function(){
  return redirect()->route('main',["lang"=>'en']);
});

Route::get('/{lang}',['uses'=>"Controller@MainGet"])->name('main');



// Route::post('/',function(Request $request){
//     if ($request->input('User') === env('BIGBOSSU') && $request->input('Pass') === env('BIGBOSSP')) {
//         $request->session()->put('authenticated', time());
//         return redirect('/test');
//     }

//     return "Somthing Worng";
// });

Route::post('ChangeNotif',['uses'=>'Controller@ChangeNotif','as'=>'ChangeNotifPost']);

Route::post('getMessages',['uses'=>"Controller@getMessages",'as'=>'getMessages']);

Route::group(['prefix'=>'BigBoss'], function () {


    Route::get('/Login',['uses'=>'BigBossController@BigBossLoginGet','as'=>'BigBossLoginGet']);

    Route::post('/Login',['uses'=>"BigBossController@BigBossLoginPost",'as'=>"BigBossLogInPost"]);

    Route::group(['middleware' => ['web', 'BigBossAuth']], function () {

      Route::get('Dashboard',['uses'=>"BigBossController@DashboardGet",'as'=>"DashboardGet"]);

      Route::get('ProviderList',['uses'=>'BigBossController@ProviderListGet','as'=>'ProviderList']);

      Route::post('ProviderOne',['uses'=>'BigBossController@ProviderOne','as'=>'ProviderOne']);

      Route::post('SaveProvider',['uses'=>"BigBossController@SaveProvider",'as'=>'SaveProvider']);

      Route::post('UpdateProvider',['uses'=>'BigBossController@UpdateProvider','as'=>'UpdateProvider']);

      Route::post('DelProvider',['uses'=>'BigBossController@DelProvider','as'=>"DelProvider"]);

      Route::get('CategoryList',['uses'=>'BigBossController@CategoryListGet','as'=>'CategoryList']);

      Route::post('CategoryOne',['uses'=>"BigBossController@CategoryOne",'as'=>'CategoryOne']);

      Route::post('SaveCategory',['uses'=>"BigBossController@SaveCategory",'as'=>'SaveCategory']);

      Route::post('UpdateCategory',['uses'=>"BigBossController@UpdateCategory",'as'=>"UpdateCategory"]);

      Route::post('DelCategory',['uses'=>"BigBossController@DelCategory",'as'=>'DelCategory']);

      Route::get('LogOut',['uses'=>"BigBossController@LogOut","as"=>"LogOut"]);
    });

});

Route::group(['prefix'=>'Provider'], function () {



    Route::get('/Login',['uses'=>'ProviderController@ProviderLoginGet','as'=>'ProviderLoginGet']);

    Route::post('/Login',['uses'=>'ProviderController@ProviderLoginPost',"as"=>"ProviderLoginPost"]);


    Route::group(['middleware'=>['web','auth:ServiceProvider']], function () {

      Route::get('Dashboard',['uses'=>'ProviderController@ProviderDashboard','as'=>'ProviderDashboard']);

      Route::post('getCatProAjax',['uses'=>'ProviderController@getCatProAjax','as'=>'getCatProAjax']);

      Route::get('ServiceList',['uses'=>'ProviderController@ServiceListGet','as'=>'ServiceListGet']);

      Route::post('SaveService',['uses'=>'ProviderController@SaveService','as'=>'SaveService']);

      Route::post('UpdateService',['uses'=>'ProviderController@UpdateService','as'=>'UpdateService']);

      Route::post('DelService',['uses'=>'ProviderController@DeleteService','as'=>'DeleteService']);

      Route::post('GetUpgrades',['uses'=>'ProviderController@GetUpgrades','as'=>'GetUpgrades']);

      Route::post('SaveUpgrade',['uses'=>'ProviderController@SaveUpgrade','as'=>'SaveUpgrade']);

      Route::post('ChangeStatusSer',['uses'=>'ProviderController@ChangeStatusSer','as'=>'ChangeStatusSer']);

      Route::post('DelUpgrade',['uses'=>'ProviderController@DelUpgrade','as'=>'DelUpgrade']);

      Route::get('OrdersList',['uses'=>'ProviderController@OrderListGet','as'=>'OrderListGet']);

      Route::post('OrderDeliver',['uses'=>'ProviderController@OrderDeliver','as'=>'OrderDeliver']);

      Route::post('OrderCancel',['uses'=>'ProviderController@OrderCancel','as'=>'OrderCancel']);

      Route::post('OrderUploadFile',['uses'=>'ProviderController@OrderUploadFile','as'=>'OrderUploadFile']);

      Route::post('OrderSendMessage',['uses'=>'ProviderController@OrderSendMessage','as'=>'OrderSendMessage']);

      Route::get('LogOut',['uses'=>'ProviderController@ProviderLogOut','as'=>'ProviderLogOut']);
        
    });

});

