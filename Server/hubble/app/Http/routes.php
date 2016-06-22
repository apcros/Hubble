<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::put('/api/v1/devices/{device_uuid}/latest', 'Device@updateData');

Route::get('/', function () {
    return view('overview');
});
