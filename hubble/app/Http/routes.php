<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

//Device API routes
Route::post('/api/v1/devices/{device_uuid}/latest', 'DeviceApi@updateDevice');
Route::post('/api/v1/devices/add','DeviceApi@createDevice');

Route::get('/api/v1/devices/{device_uuid}/latest', 'DeviceApi@getLatestDeviceData');
Route::post('/api/v1/devices/{device_uuid}/data','DeviceApi@getDeviceDataWithRange');

Route::get('/api/v1/devices/list', 'DeviceApi@listDevices');

Route::delete('/api/v1/devices/{device_uuid}/delete','DeviceApi@deleteDevice');

//General API
Route::get('/api/v1/healthcheck', 'Api@healthcheck');

//Front end routes
Route::get('/', function () {
	return view('overview');
});

Route::get('/devices',function() {
	return view('devices-config');
});

Route::get('/settings',function()  {
	return view('settings');
});
