<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeviceApiTest extends TestCase
{
    use DatabaseMigrations;

    public function testAddDevice() {
        $json = $this->addDevice("dummy1337_add");
        $this->assertEquals('device dummy1337_add added with success',$json->message);
        $this->assertEquals('ok',$json->status);
        $this->seeInDatabase('devices', ['name' => 'dummy1337_add', 'id' => $json->data->id]);
    }

    public function testRemoveDevice() {
        $json = $this->addDevice("dummy1337_del");
        $response = $this->call('DELETE','/api/v1/devices/'.$json->data->id.'/delete');
        $response_json = json_decode($response->content());
        $this->assertEquals('ok',$response_json->status);
        $this->assertEquals('deleted '.$json->data->id.' with success',$response_json->message);
        $this->notSeeInDatabase('devices',['name' => 'dummy1337_del', 'id' => $json->data->id]);
    }

    public function testUpdateDeviceWrongKey() {
        $json = $this->addDevice("dummy1337_up");
        $response_devices = $this->call('GET','/api/v1/devices/list');
        $json_devices = json_decode($response_devices->content());

        $response = $this->call('POST','/api/v1/devices/'.$json->data->id.'/latest',['
            {
               "name":"MERCURY",
               "os_version":"The os name",
               "client_version":"Unit test",
               "ram_total":"8110",
               "ram_free":"1636",
               "cpu_usage":"4",
               "drives":[
                  {
                     "format":"NTFS",
                     "free_space":"68306548",
                     "total_space":"46546464564",
                     "name":"C:\\",
                     "label":"",
                     "type":"Fixed"
                  },
                  {
                     "format":"NTFS",
                     "free_space":"45464",
                     "total_space":"645256464593",
                     "name":"D:\\",
                     "label":"",
                     "type":"Fixed"
                  },
               ]
            }']);

        $response_json = json_decode($response->content());
        $this->assertEquals('error',$response_json->status);
        $this->assertEquals('invalid HUBBLE_DEVICE_KEY',$response_json->message);
    }

    public function testUpdateDevice() {
      //TODO
    }

    public function testFetchDevice() {
        $json = $this->addDevice("dummy1337_fetch");
        $response = $this->call('GET','/api/v1/devices/'.$json->data->id.'/latest');
        $response_json = json_decode($response->content());
        $this->assertEquals('warning',$response_json->status);
        $this->assertEquals('Waiting for first connection...',$response_json->message);
    }

    private function addDevice($name) {
        $response = $this->call('POST','/api/v1/devices/add',['name' => $name]);
        return json_decode($response->content());
    }
    
}
