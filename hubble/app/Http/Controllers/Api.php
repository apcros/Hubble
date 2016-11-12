<?php
namespace App\Http\Controllers;

use Log;
use App\Http\Controllers\Controller;

class Api extends Controller
{

    public function healthcheck() {
        $json_array = array(
            'status' => 'ok',
            'version'=> config('app.hubble_version'),
        );

        return json_encode($json_array);
    }

}

?>