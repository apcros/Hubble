<?php
namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Metrics extends Controller
{

    public function showDetailedDevice($id) {
        return view('moredetails');
    }

}

?>