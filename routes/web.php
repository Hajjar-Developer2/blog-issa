<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/',function(Request $request){
    if ($request->input('User') === env('BIGBOSSU') && $request->input('Pass') === env('BIGBOSSP')) {
        $request->session()->put('authenticated', time());
        return redirect('/test');
    }

    return "Somthing Worng";
});


Route::group(['prefix'=>'BigBoss'], function () {


    Route::get('/',['uses'=>'BigBossController@BigBossLoginGet','as'=>'BigBossLoginGet']);

    Route::post('/',['uses'=>"BigBossController@BigBossLoginPost",'as'=>"BigBossLogInPost"]);

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



    Route::get('/',['uses'=>'ProviderController@ProviderLoginGet','as'=>'ProviderLoginGet']);

    Route::post('/',['uses'=>'ProviderController@ProviderLoginPost',"as"=>"ProviderLoginPost"]);


    Route::group(['middleware'=>['web','auth:ServiceProvider']], function () {

      Route::get('Dashboard',['uses'=>'ProviderController@ProviderDashboard','as'=>'ProviderDashboard']);

      Route::post('getCatProAjax',['uses'=>'ProviderController@getCatProAjax','as'=>'getCatProAjax']);

      Route::get('ServiceList',['uses'=>'ProviderController@ServiceListGet','ServiceListGet']);

      Route::post('SaveService',['uses'=>'ProviderController@SaveService','as'=>'SaveService']);
        
    });

});

