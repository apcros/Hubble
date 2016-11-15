<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::post('/api/v1/devices/{device_uuid}/latest', 'Device@updateData');
Route::post('/api/v1/devices/add','Device@add');

Route::get('/api/v1/devices/{device_uuid}/latest', 'Device@showData');
Route::get('/api/v1/devices/list', 'Device@listDevicesRaw');
Route::get('/api/v1/healthcheck', 'Api@healthcheck');

Route::delete('/api/v1/devices/{device_uuid}/delete','Device@del');


Route::get('/ajax/devices/list','Device@listDevices');


Route::get('/', function () {
	return view('overview');
});

Route::get('/config',function() {
	return view('config');
});
