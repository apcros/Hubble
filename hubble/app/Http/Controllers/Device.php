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
            DB::table("devices")->where('id',$id)->update([
                'data' => $json,
                'updated_at' => \Carbon\Carbon::now(),
                ]);
            return "OK";
        } else {
            return "INCORRECT_DEVICE";
        }

    }

    public function calculateTimout($device) {
       
        if($device->updated_at != "") {
            $dateTime = strtotime($device->updated_at);
            $timeNow = time();
            $timeDifference = $timeNow - $dateTime;

            if($timeDifference > 30) {
                return $timeDifference;
            }
        }

        return 0;
    }
    /*
        This will create a new device in db.

        CREATE TABLE "devices" (
          "uuid" text NOT NULL,
          "name" text,
          "data" json,
          "last_updated" time
    */
    public function add(Request $r) {
        $device_name = $r->input("name");
        if(isset($device_name)) {
            $device_id = sha1(time().$device_name);
            DB::table("devices")->insert(
                [
                    'id' =>  $device_id,
                    'name' => $device_name
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
        DB::table("devices")->where("id",$id)->delete();
    }

    public function listDevices() {
        $devices = DB::table("devices")->get();
        return view("ajax.device-list-config",["devices" => $devices]);
    }

    /*
        This will return the view with all the devices shown. 
        TODO : Moving that totally to AJAX ? 
    */
    public function listDevicesCard() {
        $devices = DB::table("devices")->get();

        foreach ($devices as $key => $device) {
            $devices[$key] = $this->cleanDeviceData($device);
        }
        return view("overview",["devices" => $devices]);
    }

    public function showData($id) {
        $device = DB::table("devices")->where('id',$id)->first();
        return $device->data;
    }

    /*
        This will return the json with all the devices and their cleaned data
        This is to be used on the API entry point. 
        Takes no arguments
    */
    public function listDevicesRaw() {
        $devices = DB::table("devices")->get();
        $devices_array = array();
        foreach ($devices as $key => $device) {
            $devices_array[] = $device->id;
        }
        return json_encode($devices_array);
    }

    public function exist($id) {
        $possible_device = DB::table("devices")->where("id",$id)->first();

        return isset($possible_device->id);
    }

    public function cleanDeviceData($device) {
        $device->data = json_decode($device->data); //This is to allow blade template to access differents part of the json
         $device->timeout_since = 0;
        if(isset($device->data)) {
        $device->timeout_since = $this->calculateTimout($device);

        $device->data->ram_percent = round(100 - (($device->data->ram_free / $device->data->ram_total)*100));

        foreach ($device->data->drives as $key => $drive) {
           $device->data->drives[$key]->percent = round(100 - (($drive->free_space / $drive->total_space)*100));
        }
        }
        return $device;
    }


}

?>