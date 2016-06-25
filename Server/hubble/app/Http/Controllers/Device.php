<?php
namespace App\Http\Controllers;

use DB;
use Log;
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
                ]
                );
            return $device_id;

        } else {
            return "ERROR";
        }
    }   

    /*
        This will delete the device
    */
    public function del($id, Request $r) {
        DB::table("DEVICE")->where("uuid",$id)->delete();
    }

    public function listDevices() {
        $devices = DB::table("DEVICE")->get();
        return view("ajax.device-list-config",["devices" => $devices]);
    }

    public function listDevicesCard() {
        $devices = DB::table("DEVICE")->get();

        foreach ($devices as $key => $device) {
           $devices[$key]->data = json_decode($device->data);
        }
        return view("overview",["devices" => $devices]);
    }

    public function showData($id) {
        $device = DB::table("DEVICE")->where('uuid',$id)->first();
        return json_encode($device->data);
    }

    //TODO
    public function exist($id) {
        return true;
    }


}

?>