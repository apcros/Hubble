<?php
namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Device extends Controller
{
    /*
        updateData takes the device id you and to update and the json data
    */
    public function updateData($id, Request $r) {
        if($this->exist($id)) {
            $json = json_encode($r->all());
            DB::table("DEVICE")->where('uuid',$id)->update(['data' => $json]);
            return "OK";
        } else {
            return "INCORRECT_DEVICE";
        }

    }


    /*
        This will create a new device in db.

        CREATE TABLE "DEVICE" (
  "id" integer NOT NULL,
  "uuid" text NOT NULL,
  "name" text,
  "data" json,
  "last_updated" time
    */
    public function add(Request $r) {
        $device_name = $r->input("name");
        if(isset($device_name)) {
            $device_id = sha1(time().$device_name);

            DB::table("DEVICE")->insert(
                [
                    'uuid'          => $device_id,
                    'name'          => $device_name,
                    'last_updated'  => time(),
                ]
                );
            return $device_id;

        }
    }   

    /*
        This will delete the device
    */
    public function del($id, Request $r) {

    }

    //TODO
    public function exist($id) {
        return true;
    }


}

?>