<?php
namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceApi extends Controller
{

    /* TODO : This should be removed and replaced by
        a ajax call to listDevices + a handlebarjs template
    */
    public function listDevicesView() {
        $devices = DB::table("devices")->get();
        return view("ajax.device-list-config",["devices" => $devices]);
    }

    public function updateDevice($id, Request $r) {

        if($this->deviceExists($id)) {
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

    public function createDevice(Request $r) {
        $device_name = $r->input("name");
        if(isset($device_name)) {
            $device_id = $this->generateDeviceUID();
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

    public function deleteDevice($id) {
        if($this->deviceExists($id)) {
            DB::table("devices")->where("id",$id)->delete();
            return $this->json_response("ok","deleted $id with success");
        } else {
            return $this->json_response("error", "incorrect device id : $id");
        }
    }

    public function getDeviceData($id) {
        $device = DB::table("devices")->where('id',$id)->first();
        $json = $device->data;
        if(empty($json)) $json = "{}";

        $device_data = json_decode($json);

        $timeout = $this->getDeviceTimeout($device);
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

    public function listDevices() {
        $devices = DB::table("devices")->get();
        $devices_array = array();
        foreach ($devices as $key => $device) {
            $devices_array[] = $device->id;
        }
        return json_encode($devices_array);      
    }

    private function generateDeviceUID() {
        return sha1(time().str_random(10));
    }
    private function getDeviceTimeout($device) {
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

    private function deviceExists($id) {
        $device = DB::table("devices")->where("id",$id)->first();
        return isset($device);
    }

    private function json_response($status, $message, $data = null) {
        $json_array = array(
            'status'  => $status,
            'message' => $message 
        );

        if ($data != null) {
            $json_array["data"] = $data;
        }

        return json_encode($json_array);
    }


}

?>