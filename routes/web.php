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


Route::get('/', 'LoginController@index');
Route::get('login/login', 'LoginController@login');
Route::get('login/user_validation', 'LoginController@validateLogin');
Route::get('login/check_username', 'LoginController@validateUsername');

Route::get('login/logout', 'LoginController@logout');


Route::get('user/username_exist_check', 'AdminUserController@usernameExistCheck');
Route::get('user/password_check', 'AdminUserController@userPasswordCheck');
Route::post('user/profile_update', 'AdminUserController@updateProfile');
Route::post('user/password_change', 'AdminUserController@passwordChange');
Route::resource('user', 'AdminUserController');




Route::post('device/add-home', 'DeviceController@insertUpdateHome');
Route::post('device/add-room', 'DeviceController@insertUpdateRoom');
Route::post('device/add-device', 'DeviceController@insertUpdateDevice');
Route::get('device/get-homes', 'DeviceController@getHomesUser');
Route::get('device/get-rooms', 'DeviceController@getRoomsHome');
Route::get('device/get-devices', 'DeviceController@getDevicesRoom');
Route::get('device/get-device-data', 'DeviceController@getDataForGraph2');

Route::resource('device', 'DeviceController');

Route::resource('home', 'HomeController');

Route::post('calculator/calculate', 'CalculatorController@calculation');
Route::resource('calculator', 'CalculatorController');

Route::post('budget/save-report', 'BudgetController@saveReport');
Route::post('budget/regenerate', 'BudgetController@regenerateReport');
Route::post('budget/report', 'BudgetController@generateReport');
Route::resource('budget', 'BudgetController');

Route::post('usage/retrive-data', 'UsageController@retriveUsageHistory');
Route::post('usage/get-graph', 'UsageController@getGraphRecords');  
Route::resource('usage', 'UsageController');

Route::resource('user-guide', 'UserGuideController');

Route::get('help/notify', 'HelpDeskController@SendNotification');
Route::post('help/send', 'HelpDeskController@sendHelp');
Route::resource('help', 'HelpDeskController');
