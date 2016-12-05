<?php
namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceApi extends Controller
{

    public function updateDevice($id, Request $r) {
        $device_to_update = DB::table("devices")->where('id',$id)->first();

        if(isset($device_to_update)) {
            if($device_to_update->key == $r->header("HUBBLE-DEVICE-KEY")) {
                $json = json_encode($r->all());
                $query_status = DB::table("devices-data")->insert([
                    'data' => $json,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    'device_id' => $id
                    ]);

                Log::info("$id has been updated by ".$r->ip());

                return $this->json_response("ok", "$id has been updated");
            } else {
                Log::warning("An attempt to update $id with an invalid key has been made by ".$r->ip());
                return $this->json_response("error","invalid HUBBLE_DEVICE_KEY");
            }
        } else {
            Log::warning("An attempt to update an unknown device ($id) has been made by ".$r->ip());
            return $this->json_response("error", "incorrect device id : $id");
        }
    }

    public function createDevice(Request $r) {
        $device_name = $r->input("name");
        if(!empty($device_name)) {
            $device_id = $this->generateDeviceUID();
            DB::table("devices")->insert(
                [
                    'id' =>  $device_id,
                    'name' => $device_name,
                    'key' => str_random(50),
                ]
            );
            Log::info("$device_name was added with id $device_id by ".$r->ip());
            return $this->json_response("ok", "device $device_name added with success",['id' => $device_id]);

        } else {
            return $this->json_response("error","name is mandatory");
        }
    }

    public function deleteDevice($id, Request $r) {
        if($this->deviceExists($id)) {
            DB::table("devices")->where("id",$id)->delete();

            Log::info("$id was deleted by ".$r->ip());
            return $this->json_response("ok","deleted $id with success");
        } else {
            Log::warning("An attempt to delete an unknown device ($id) has been made by ".$r->ip());
            return $this->json_response("error", "incorrect device id : $id");
        }
    }

    public function getLatestDeviceData($id) {
        $device = DB::table("devices")->where('id',$id)->first();
        if(!$device){
            return $this->json_response("error","device $id does not exist");
        }
        $latest_data = DB::table("devices-data")->where('device_id',$id)->latest()->first();
        if(isset($latest_data->data)){
            $json = $latest_data->data;
            $device_data = json_decode($json);
        } else {
            $device_data = json_decode("{}");
        }

        $timeout = $this->getDeviceTimeout($latest_data);
        if($timeout > 0) {
            $device_data->status = "timeout";
            $device_data->message = $timeout;
        } else {
            $device_data->status = "ok";
            $device_data->message = "In sync";
        }

        if(!isset($latest_data->created_at)) {
            $device_data->status = "warning";
            $device_data->message = "Waiting for first connection...";
        } else {
             $device_data->last_updated = $latest_data->created_at;
        }

        $device_data->hubble_name = $device->name;
        return json_encode($device_data);
    }

    /*
     TODO : Include limits
     TODO : Include max granulatity (Nb of data/sec )
    */
    public function getDeviceDataWithRange($id, Request $r) {
        if($this->deviceExists($id)) {
            $json = $r->all();

            if(!isset($json['from'])) {
                return $this->json_response("error", "You need to specify at least from parameter");
            }

            $from = date('Y-m-d H:m:s',$json['from']);

            if(!isset($json['to'])){
                $to = date('Y-m-d H:m:s',time());
            } else {
                $to = date('Y-m-d H:m:s',$json['to']);
            }

            $data_rows = DB::table("devices-data")->select('created_at','data')->where("device_id",$id)->whereBetween("created_at", [$from, $to])->orderBy('created_at')->get();
            return $this->json_response("ok","$id data between $from and $to",$data_rows);

        } else {
            return $this->json_response("error","device $id does not exist");
        }
    }
    public function listDevices() {
        $devices = DB::table("devices")->get();
        $devices_array = array();

        foreach ($devices as $key => $device) {
            $latest_data = DB::table("devices-data")->where('device_id',$device->id)->latest()->first();
            if(isset($latest_data->updated_at)){
                $status = "Last updated at ".$latest_data->updated_at;
            } else {
                $status = "No data yet";
            }
            $devices_array[] = array(
                'id'     => $device->id,
                'name'   => $device->name,
                'key'    => $device->key,
                'system'   => $this->getDeviceSystem($latest_data),
                'status' => $status
            );
        }
        return json_encode($devices_array);
    }

    private function getDeviceSystem($latest_data) {

        if(isset($latest_data->data)) {
            $json = json_decode($latest_data->data);
            if(isset($json->client_version)) {
                $client_parts = explode("/", $json->client_version);
                return htmlspecialchars(end($client_parts));
            }
        } else {
            return "Unknown";
        }
    }

    private function generateDeviceUID() {
        return sha1(time().str_random(10));
    }
    private function getDeviceTimeout($latest_data) {
        if(isset($latest_data->created_at)) {
            $dateTime = strtotime($latest_data->created_at);
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