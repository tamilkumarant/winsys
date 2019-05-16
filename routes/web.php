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

	// date_default_timezone_set('Asia/Calcutta'); 
	date_default_timezone_set('Asia/Singapore'); 

    Route::get('/', 'Admin\HomeController@index');	
    Route::get('/login', 'Admin\HomeController@index');	
    Route::post('/auth/login', 'Auth\LoginController@login');	
    Route::get('/logout', 'Auth\LoginController@logout');	
	
	
    Route::any('/profile', 'Admin\PageController@profile');	
    Route::get('/dashboard', 'Admin\PageController@dashboard');	
    Route::any('/display/{id}', 'Admin\PageController@display');	
    Route::any('/display-content/{id}', 'Admin\PageController@displayContent');	
    Route::get('/map/{id}', 'Admin\PageController@map');    
    Route::get('/status', 'Admin\PageController@status');	
    Route::get('/project', 'Admin\PageController@emptyView');
    Route::get('/user', 'Admin\PageController@emptyView');	
    Route::get('/dashboard-data', 'Admin\PageController@dashboardData');	
    Route::any('/summary-data', 'Admin\PageController@summaryData');	
    Route::get('/view-station-group-content', 'Admin\PageController@viewStationGroup');	
    // Route::get('/view-station-group', 'Admin\PageController@viewStationGroupContent');	
    Route::get('/view-station-group', 'Admin\PageController@viewStationGroup');	
    Route::any('/individual-chart/{id}', 'Admin\PageController@individualChart');	
    Route::any('/wl-min-max', 'Admin\PageController@wlMinMax');	
    Route::any('/wl-summary-50', 'Admin\PageController@wlSummary50Content');
    Route::any('/wl-summary-75', 'Admin\PageController@wlSummary75Content');		
    Route::any('/wlsummary50', 'Admin\PageController@wlSummary50');	
    Route::any('/wlsummary75', 'Admin\PageController@wlSummary75');	
    Route::any('/sms-list', 'Admin\PageController@smsList');	
    Route::any('/self-auditing', 'Admin\PageController@selfAuditing');	
    Route::get('/change-cl-station-group/{group_id}/{field}/{value}', 'Admin\PageController@changeCLStationGroup');	
    Route::get('/change-station-group/{group_id}/{field}/{value}', 'Admin\PageController@changeStationGroup');	
	
    Route::get('/export', 'Admin\ServiceController@export');    
    Route::get('/pdf', 'Admin\ServiceController@pdf');	
    Route::get('/export-excel/{id}', 'Admin\ServiceController@exportExcel');    
    Route::get('/export-pdf/{id}', 'Admin\ServiceController@exportPDF');	
    Route::post('/save-image', 'Admin\ServiceController@saveImage');	
    Route::any('/get-dashboard-rawdata-service', 'Admin\ServiceController@getDashboardrawdata');	
	
    // Route::get('/menu', function () {       
    //         return 'Hello, World!';
    // });
    
	Route::any('/menu', 'Admin\UserController@menu');		
	Route::any('/menu/add', 'Admin\UserController@addMenu');		
	Route::any('/menu/edit/{id}', 'Admin\UserController@editMenu');		
	Route::any('/menu/delete/{id}', 'Admin\UserController@deleteMenu');	
	
	Route::any('/menu-access/{user_id}', 'Admin\UserController@menuAccess');
	
	Route::any('/project', 'Admin\ProjectController@index');		
	Route::any('/project/add', 'Admin\ProjectController@add');		
	Route::any('/project/edit/{id}', 'Admin\ProjectController@edit');		
	Route::any('/project/delete/{id}', 'Admin\ProjectController@deleteRow');	
	Route::any('/project/status/{id}', 'Admin\ProjectController@status');	
	
	Route::any('/station', 'Admin\StationController@index');		
	Route::any('/station/add', 'Admin\StationController@add');		
	Route::any('/station/edit/{id}', 'Admin\StationController@edit');		
	Route::any('/station/delete/{id}', 'Admin\StationController@deleteRow');	
	Route::any('/station/status/{id}', 'Admin\StationController@status');		
    Route::get('/get-station/{id}', 'Admin\StationController@getStation');	
    Route::get('/get-station-all/{id}', 'Admin\StationController@getStationAll');	
    Route::any('/get-chart-rawdata', 'Admin\StationController@getChartrawdata');	
    Route::any('/get-dashboard-rawdata', 'Admin\StationController@getDashboardrawdata');	
    Route::any('/station-grouping', 'Admin\StationController@stationGrouping');	
	
	Route::any('/user', 'Admin\UserController@index');		
	Route::any('/user/add', 'Admin\UserController@add');		
	Route::any('/user/edit/{id}', 'Admin\UserController@edit');		
	Route::any('/user/delete/{id}', 'Admin\UserController@deleteRow');	
	Route::any('/user/status/{id}', 'Admin\UserController@status');	
    Route::get('/get-stations/{id}', 'Admin\UserController@getStations');		
	
	Route::any('/calibration', 'Admin\CalibrationController@index');		
	Route::any('/calibration/add/{id}/{station_id}', 'Admin\CalibrationController@add');		
	
	
