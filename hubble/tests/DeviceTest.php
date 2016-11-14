<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeviceTest extends TestCase
{
    use DatabaseMigrations;

    public function testAddDevice() {
        $json = $this->_addDevice("dummy1337_add");
        $this->assertEquals('device dummy1337_add added with success',$json->message);
        $this->assertEquals('ok',$json->status);
        $this->seeInDatabase('devices', ['name' => 'dummy1337_add', 'id' => $json->data->id]);
    }

    public function testRemoveDevice() {
        $json = $this->_addDevice("dummy1337_del");
        $response = $this->call('DELETE','/api/v1/devices/'.$json->data->id.'/delete');
        $response_json = json_decode($response->content());
        $this->assertEquals('ok',$response_json->status);
        $this->assertEquals('deleted '.$json->data->id.' with success',$response_json->message);
        $this->notSeeInDatabase('devices',['name' => 'dummy1337_del', 'id' => $json->data->id]);
    }

    public function testUpdateDevice() {
        //TODO
    }

    public function testFetchDevice() {
        //TODO
    }

    public function _addDevice($name) {
        $response = $this->call('POST','/api/v1/devices/add',['name' => $name]);
        return json_decode($response->content());
    }
    
}
