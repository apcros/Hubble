<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::post('/api/v1/devices/{device_uuid}/latest', 'Device@updateData');
Route::get('/api/v1/devices/{device_uuid}/latest', 'Device@showData');
Route::get('/api/v1/devices/list', 'Device@listDevicesRaw');

Route::get('/ajax/devices/list','Device@listDevices');
Route::post('/ajax/devices/add','Device@add');
Route::delete('/ajax/devices/{device_uuid}/delete','Device@del');

Route::get('/','Device@listDevicesCard');

Route::get('/config',function() {
	return view('config');
});
