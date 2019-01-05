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
    return Redirect::to('login');
});

Route::match(['get', 'post'], 'login', ['as' => 'login', 'uses' => 'LoginController@auth']);
Route::match(['get', 'post'], 'logout', ['as' => 'logout', 'uses' => 'LoginController@getLogout']);
$userPrefix = "";
	Route::group(['prefix' => $userPrefix, 'middleware' => ['auth']], function() {
	Route::match(['get', 'post'], 'dashboard', ['as' => 'dashboard', 'uses' => 'UserController@dashboard']);
	
});

$adminPrefix = "admin";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
	Route::match(['get', 'post'], 'admin-dashboard', ['as' => 'admin-dashboard', 'uses' => 'Admin\AdminController@dashboard']);
	Route::match(['get', 'post'], 'update-profile', ['as' => 'update-profile', 'uses' => 'Admin\UpdateProfileController@editProfile']);
    Route::match(['get', 'post'], 'change-password', ['as' => 'change-password', 'uses' => 'Admin\UpdateProfileController@changepassword']); 
    Route::match(['get', 'post'], 'list-demo', ['as' => 'list-demo', 'uses' => 'Admin\DemoController@index']);
    Route::match(['get', 'post'], 'demo-ajaxAction', ['as' => 'ajaxAction', 'uses' => 'Admin\DemoController@ajaxAction']);
    Route::match(['get', 'post'], 'add-demo', ['as' => 'add-demo', 'uses' => 'Admin\DemoController@add']);
    Route::match(['get', 'post'], 'edit-demo/{id}', ['as' => 'edit-demo', 'uses' => 'Admin\DemoController@edit']);
});

$employeePrefix = "employee";
Route::group(['prefix' => $employeePrefix, 'middleware' => ['employee']], function() {
	Route::match(['get', 'post'], 'employee-dashboard', ['as' => 'employee-dashboard', 'uses' => 'Employee\EmployeeController@dashboard']);
});

$companyPrefix = "company";
Route::group(['prefix' => $companyPrefix, 'middleware' => ['company']], function() {
	Route::match(['get', 'post'], 'company-dashboard', ['as' => 'company-dashboard', 'uses' => 'Company\CompanyController@dashboard']);
});