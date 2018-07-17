<?php

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
})->middleware('auth');

Route::get('/appcode', ['as' => 'url_appcode',function () {
    return view('appcode');
}])->middleware('auth');

Route::get('/appdebug', ['as' => 'url_appcode',function () {
    return view('appdebug');
}])->middleware('auth');

Route::any('/campaign', ['as' => 'url_campaign',function () {
    return view('campaign');
}])->middleware('auth');

Route::any('/xinwang/jump', 'XinwangController@jump');
Route::get('/xinwang', 'XinwangController@index')->middleware('auth');
Route::any('/xinwang/gateway', 'XinwangController@gateway')->middleware('auth');
Route::any('/xinwang/direct', 'XinwangController@direct')->middleware('auth');
Route::any('/xinwang/download', 'XinwangController@download')->middleware('auth');
Route::any('/xinwang/download_prepare', 'XinwangController@download_prepare')->middleware('auth');
Route::any('/xinwang/download_server', 'XinwangController@download_server')->name('download_server')->middleware('auth');
Route::any('/xinwang/readFile', 'XinwangController@readFile')->name('readFile')->middleware('auth');
Route::post('/xinwang/gateway_prepare', 'XinwangController@gateway_prepare')->middleware('auth');
Route::post('/xinwang/direct_prepare', 'XinwangController@direct_prepare')->middleware('auth');
Route::any('/xinwang/direct_server', 'XinwangController@direct_server')->name('direct_server')->middleware('auth');
Route::any('/fanli', 'FanliController@index')->middleware('auth');
Route::any('/newyear', 'NewyearController@index')->middleware('auth');
Route::post('/server/appdecode', 'ServerController@decode')->name('server_appdecode')->middleware('auth');
Route::post('/server/appencode', 'ServerController@encode')->name('server_appencode')->middleware('auth');
Route::post('/server/appdebug', 'ServerController@appdebug')->name('server_appdebug')->middleware('auth');
Route::post('/server/userinfo', 'UserController@userinfo')->name('server_userinfo')->middleware('auth');
Route::get('/code', 'CodeController@userCode')->name('verify_code')->middleware('auth');
Route::post('/code/find', 'CodeController@getUserCode')->name('server_usercode')->middleware('auth');

Route::any('/xinwang/recharge', 'XinwangController@recharge')->middleware('auth');
Route::post('/xinwang/recharge_prepare', 'XinwangController@recharge_prepare')->middleware('auth');
Route::any('/xinwang/recharge_server', 'XinwangController@recharge_server')->name('recharge_server')->middleware('auth');

Route::any('/xinwang/checkbill', 'CheckbillController@index')->middleware('auth');
Route::any('/api/auth',function () {
    return view('api.auth');
})->middleware('auth');
Route::post('/api/server_auth', 'ApiController@auth')->name('server_api_auth')->middleware('auth');

Route::get('/cps/fanliwang/userinfo', ['as' => 'url_cps_fanliwang_userinfo',function () {
    return view('cps.fanliwang_userinfo');
}])->middleware('auth');

Route::get('/cps/fanliwang/investinfo', ['as' => 'url_cps_fanliwang_investinfo',function () {
    return view('cps.fanliwang_investinfo');
}])->middleware('auth');

Route::get('/cps/tools', 'CpsController@tools')->middleware('auth');

Route::post('/cps/fanliwang_userinfo', 'CpsController@fanliwang_userinfo')->name('server_fanliwang_userinfo')->middleware('auth');

Route::post('/cps/fanliwang_investinfo', 'CpsController@fanliwang_investinfo')->name('server_cps_fanliwang_investinfo')->middleware('auth');

Route::any('/git', 'GitController@index');

Route::any('/peixingzhe/search/{order_id}', 'PeiXingZheController@search');

Route::get('/peixingzhe/info', ['as' => 'url_peixingzhe_info',function () {
    return view('peixingzhe.info');
}])->middleware('auth');
Route::post('/peixingzhe/server_info', 'PeixingzheController@info')->name('server_peixingzhe_info')->middleware('auth');

Route::get('/user/info', ['as' => 'url_user_info',function () {
    return view('user.info');
}])->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/mns/push', 'MnsController@push')->middleware('auth');

Route::any('/mns/push_server', 'MnsController@push_server')->name('push_server')->middleware('auth');
