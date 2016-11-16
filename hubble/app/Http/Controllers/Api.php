<?php
namespace App\Http\Controllers;

use DB;
use Log;
use App\Http\Controllers\Controller;

class Api extends Controller
{

    public function healthcheck() {

        $json_array = array(
            'status' => 'ok',
            'version'=> config('app.hubble_version'),
            'message'=> 'All good'
        );
        
        $db_name = DB::connection()->getDatabaseName();
        if(!$db_name){
            $json_array['status'] = 'error';
            $json_array['message'] = 'Database error ';
        }
        return json_encode($json_array);
    }

}

?>