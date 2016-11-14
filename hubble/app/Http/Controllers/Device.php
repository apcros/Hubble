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
            return $this->json_response("ok", "$id has been updated");
        } else {
            return $this->json_response("error", "incorrect device id : $id");
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
            return $this->json_response("ok", "device $device_name added with success",['id' => $device_id]);

        } else {
            return $this->json_response("error","Unexpeted error ocurred while adding $device_name");
        }
    }   

    /*
        This will delete the device
    */
    public function del($id, Request $r) {
        DB::table("devices")->where("id",$id)->delete();
        return $this->json_response("ok","deleted $id with success");
    }

    public function listDevices() {
        $devices = DB::table("devices")->get();
        return view("ajax.device-list-config",["devices" => $devices]);
    }

    public function showData($id) {
        $device = DB::table("devices")->where('id',$id)->first();
        $json = $device->data;
        if(empty($json)) $json = "{}";

        $device_data = json_decode($json);

        $timeout = $this->calculateTimout($device);
        if($timeout > 0) {
            $device_data->status = "error";
            $device_data->message = "Timeout since $timeout seconds !";
        } else {
            $device_data->status = "ok";
            $device_data->message = "In sync";
        }

        if(!isset($device->updated_at)) {
            $device_data->status = "warning";
            $device_data->message = "Waiting for first connection...";
        }

        $device_data->last_updated = $device->updated_at;
        $device_data->hubble_name = $device->name;
        return json_encode($device_data);
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
        $device->data = json_decode($device->data);
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

    //TODO Refactor and move all that crap to Api.php
    public function json_response($status,$message, $data = []) {
        return json_encode(array(
            'status'  =>  $status,
            'message' => $message,
            'data'    => $data
        ));
    }


}

?>